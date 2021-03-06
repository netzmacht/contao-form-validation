<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015-2016 netzmacht David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormValidation\Assembler;

use ContaoCommunityAlliance\Translator\TranslatorInterface as Translator;
use Netzmacht\Contao\FormValidation\Event\BuildValidationFieldEvent;
use Netzmacht\Contao\FormValidation\Field;
use Netzmacht\Contao\FormValidation\Util\Format;
use Netzmacht\Contao\FormValidation\Validation;

/**
 * Validator assembler creates the validators for the fields.
 *
 * @package Netzmacht\Contao\FormValidation\Assembler
 */
class ValidatorAssembler extends AssemblerBase
{
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
    private $dateFormats = array('date', 'datim');

    /**
     * Rgxp expression validator mappings.
     *
     * @var array
     */
    private $rgxpFormatsValidators = array(
        'digit'   => 'numeric',
        'natural' => 'integer'
    );
    
    /**
     * Contao config.
     * 
     * @var \Config
     */
    private $config;
    
    /**
     * Translator.
     * 
     * @var Translator
     */
    private $translator;

    /**
     * ValidatorAssembler constructor.
     *
     * @param \Config    $config     Contao config.
     * @param Translator $translator Translator.
     */
    public function __construct(\Config $config, Translator $translator)
    {
        $this->config     = $config;
        $this->translator = $translator;
    }

    /**
     * Construct.
     *
     * @param BuildValidationFieldEvent $event The subscribed event.
     *
     * @return void
     */
    public function handle(BuildValidationFieldEvent $event)
    {
        $validation = $event->getValidation();
        $fieldModel = $event->getFieldModel();
        $field      = $validation->getField($this->getFieldIdentifier($fieldModel));

        if (!$field) {
            return;
        }

        $this->assembleFormatValidator($field, $fieldModel);
        $this->assembleStringLengthValidator($field, $fieldModel);
        $this->assembleCheckboxRequiredValidator($field, $fieldModel);
        $this->assembleFileValidator($field, $fieldModel);
        $this->assemblePasswordValidators($validation, $field, $fieldModel);
        $this->assembleDateValidator($field, $fieldModel);
        $this->assemblePhoneValidator($validation, $field, $fieldModel);
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
     */
    private function assemblePasswordValidators(Validation $validation, Field $field, $model)
    {
        if ($model->type !== 'password') {
            return;
        }

        $minLength = $this->config->get('minPasswordLength');
        $confirm   = $validation->addField($model->name . '_confirm');

        $confirm->addValidator(
            'identical',
            array(
                'field'   => $model->name,
                'message' => $this->translator->translate('ERR.passwordMatch')
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

        $dateFormat = Format::convertDateFormat($this->config->get($model->rgxp . 'Format'));

        if ($dateFormat !== false) {
            $field->addValidator('date', array('format' => $dateFormat));
        }
    }

    /**
     * Assemble the phone validator.
     *
     * @param Validation      $validation The form validation.
     * @param Field           $field      The validation field.
     * @param \FormFieldModel $model      The field model.
     *
     * @return void
     */
    private function assemblePhoneValidator(Validation $validation, Field $field, \FormFieldModel $model)
    {
        if (in_array($model->type, $this->rgxpWidgets) && $model->rgxp === 'phone') {
            $field->addValidator(
                'phone',
                array('country' => Format::convertLocaleToCountryCode($validation->getLocale()))
            );
        }
    }

    /**
     * Assemble the format validator.
     *
     * @param Field           $field The validation field.
     * @param \FormFieldModel $model The field model.
     *
     * @return void
     */
    private function assembleFormatValidator(Field $field, \FormFieldModel $model)
    {
        if (in_array($model->type, $this->rgxpWidgets) && isset($this->rgxpFormatsValidators[$model->type])) {
            $field->addValidator($this->rgxpFormatsValidators[$model->type], array());
        }
    }

    /**
     * Assemble the format validator.
     *
     * @param Field           $field The validation field.
     * @param \FormFieldModel $model The field model.
     *
     * @return void
     */
    private function assembleCheckboxRequiredValidator(Field $field, \FormFieldModel $model)
    {
        if ($model->type === 'checkbox' && $model->mandatory) {
            if ($model->minlength > 0) {
                $options = array('min' => (int) $model->minlength);

                if ($model->maxlength > 0) {
                    $options['message'] = sprintf(
                        $this->translator->translate(
                            'ERR.between',
                            null,
                            [
                                $model->label,
                                $model->minlength,
                                $model->maxlength
                            ]
                        )
                    );
                } else {
                    $options['message'] = sprintf(
                        $this->translator->translate(
                            'ERR.minoption',
                            null,
                            [
                                $model->label,
                                $model->minlength,
                            ]
                        )
                    );
                }
            } else {
                $options = array('min' => 1);

                if ($model->maxlength > 0) {
                    $options['message'] = $this->translator->translate(
                        'ERR.maxoption',
                        null,
                        [
                            $model->label,
                            $model->maxlength,
                        ]
                    );
                } else {
                    $errorKey           = $model->label ? 'ERR.mandatory' : 'ERR.mdtryNoLabel';
                    $options['message'] = $this->translator->translate($errorKey, null, [$model->label]);
                }
            }

            if ($model->maxlength > 0) {
                $options['max'] = (int) $model->maxlength;
            }

            $field->addValidator('choice', $options);
        }
    }
}
