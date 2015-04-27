<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormValidation\Assembler;

use Netzmacht\Contao\FormValidation\Event\BuildValidationFieldEvent;
use Netzmacht\Contao\FormValidation\Field;
use Netzmacht\Contao\FormValidation\Validation;

/**
 * The field assembler assembles the validation for a form field.
 *
 * @package Netzmacht\Contao\FormValidation\Assembler
 */
class FieldAssembler
{
    /**
     * List of supported widget types.
     *
     * @var array
     */
    private $supportedWidgets;

    /**
     * Fields which supports the rgxp validation.
     *
     * @var array
     */
    private $rgxpWidgets = array('text', 'password', 'textarea', 'hidden');

    /**
     * Supported date formats.
     *
     * @var array
     */
    private $dateFormats = array('date', 'time', 'datim');

    /**
     * Construct.
     *
     * @param array $supportedWidgets The supported widget.
     */
    public function __construct(array $supportedWidgets)
    {
        $this->supportedWidgets = $supportedWidgets;
    }

    /**
     * Handle the validation build event.
     *
     * @param BuildValidationFieldEvent $event The subscribed event.
     *
     * @return void
     */
    public function handle(BuildValidationFieldEvent $event)
    {
        $fieldModel = $event->getFieldModel();

        if (!in_array($fieldModel->type, $this->supportedWidgets)) {
            return;
        }

        $validation = $event->getValidation();
        $field      = $this->createField($validation, $fieldModel);

        $this->assembleStringLengthValidator($field, $fieldModel);
        $this->assembleFileValidator($field, $fieldModel);
        $this->assemblePasswordValidators($validation, $field, $fieldModel);
        $this->assembleDateValidator($field, $fieldModel);
    }

    /**
     * Create the field validation object.
     *
     * @param Validation      $validation The form validation.
     * @param \FormFieldModel $model      The field model.
     *
     * @return Field
     */
    private function createField(Validation $validation, $model)
    {
        $field = $validation->addField($model->name)
            ->setAutoFocus($model->fv_autofocus)
            ->setIcon($model->fv_icon)
            ->setVerbose($model->fv_verbose);

        foreach (array('message', 'selector') as $option) {
            $this->assembleOption($field, $model, $option, true);
        }

        if ($model->fv_advanced) {
            $this->assembleOption($field, $model, 'row', true);

            if (is_numeric($model->fv_threshold)) {
                $field->setThreshold($model->fv_threshold);
            }

            if ($model->fv_err) {
                if ($model->fv_err === 'selector') {
                    $field->setErr($model->fv_err_selector);
                } else {
                    $field->setErr($model->fv_err);
                }
            }
        }

        return $field;
    }

    /**
     * Assemble an option.
     *
     * @param mixed  $object The object.
     * @param \Model $model  The model.
     * @param string $option The option name.
     * @param bool   $prefix Should the fv_ prefix be added.
     * @param bool   $force  Force setting of option. Otherwise check if not empty.
     *
     * @return void
     */
    private function assembleOption($object, $model, $option, $prefix = false, $force = false)
    {
        $method = 'set' . ucfirst($option);

        if ($prefix) {
            $option = 'fv_' . $option;
        }

        if ($force || $model->$option) {
            $object->$method($model->$option);
        }
    }

    /**
     * Assemble the string length validator.
     *
     * @param Field           $field The validation field.
     * @param \FormFieldModel $model The field model.
     *
     * @return void
     */
    private function assembleStringLengthValidator(Field $field, $model)
    {
        if (($model->type === 'text' || $model->type === 'textarea') && ($model->minlength || $model->maxlength)) {
            $options = array(
                'trim' => true
            );

            if ($model->minlength > 0) {
                $options['min'] = (int) $model->minlength;
            }

            if ($model->maxlength > 0) {
                $options['max'] = (int) $model->maxlength;
            }

            $field->addValidator('stringLength', $options);
        }
    }

    /**
     * Assemble the file validator for upload widgets.
     *
     * @param Field           $field The validation field.
     * @param \FormFieldModel $model The field model.
     *
     * @return void
     */
    private function assembleFileValidator(Field $field, $model)
    {
        if ($model->type === 'upload') {
            $options = array('maxFiles' => 1);

            if ($model->extensions) {
                $options['extension'] = $model->extensions;
            }

            if ($model->maxlength > 0) {
                $options['maxSize'] = (int) $model->maxlength;
            }

            $field->addValidator('file', $options);
        }
    }

    /**
     * Assemble the password validators.
     *
     * @param Validation      $validation Form validation.
     * @param Field           $field      The validation field.
     * @param \FormFieldModel $model      The field model.
     *
     * @return void
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    private function assemblePasswordValidators(Validation $validation, Field $field, $model)
    {
        if ($model->type !== 'password') {
            return;
        }

        $minLength = \Config::get('minPasswordLength');
        $confirm   = $validation->addField($model->name . '_confirm');

        $confirm->addValidator(
            'identical',
            array(
                'field'   => $model->name,
                'message' => $GLOBALS['TL_LANG']['ERR']['passwordMatch']
            )
        );

        if ($minLength) {
            $options = array(
                'trim' => true,
                'min'  => $minLength
            );

            $field->addValidator('stringLength', $options);
            $confirm->addValidator('stringLength', $options);
        }
    }

    /**
     * Assemble the file validator for upload widgets.
     *
     * @param Field           $field The validation field.
     * @param \FormFieldModel $model The field model.
     *
     * @return void
     */
    private function assembleDateValidator(Field $field, \FormFieldModel $model)
    {
        if (!in_array($model->type, $this->rgxpWidgets) || !in_array($model->rgxp, $this->dateFormats)) {
            return;
        }

        $dateFormat = $this->convertDateFormat(\Config::get($model->rgxp . 'Format'));

        if ($dateFormat !== false) {
            $field->addValidator('date', array('format' => $dateFormat));
        }
    }

    /**
     * Convert a given date format.
     *
     * @param string $format The php date format.
     *
     * @return bool
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    private function convertDateFormat($format)
    {
        $converted = '';
        $length    = strlen($format);

        for ($pos = 0; $length > $pos; $pos++) {
            switch ($format[$pos]) {
                case 'd':
                    $converted .= 'DD';
                    break;

                case 'm':
                    $converted .= 'MM';
                    break;

                case 'Y':
                    $converted .= 'YYYY';
                    break;

                case 'i':
                    $converted .= 'm';
                    break;

                case 'h':
                case 's':
                case '.':
                case ' ':
                case '|':
                case '/':
                case '-':
                    $converted .= $format[$pos];
                    break;

                default:
                    // unsupported format.
                    return false;
            }
        }

        return $converted;
    }
}
