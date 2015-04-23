<?php

/**
 * @package    contao-form-validation
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormValidation;

use Netzmacht\Contao\FormValidation\Model\ValidationModel;

/**
 * Assembler takes the form configuration and creates the validation object.
 *
 * @package Netzmacht\Contao\FormValidation
 */
class Assembler
{
    /**
     * Supported validation widgets.
     *
     * @var array
     */
    private $widgets;

    /**
     * Construct.
     *
     * @param array $supportedWidgets List of supported widgets.
     */
    public function __construct($supportedWidgets)
    {
        $this->widgets = $supportedWidgets;
    }

    /**
     * Assemble the form validation.
     *
     * @param \FormModel        $model    The form model.
     * @param \FormFieldModel[] $fields   The form fields.
     * @param ValidationModel   $settings The validation model.
     *
     * @return Validation
     */
    public function assemble($model, $fields, $settings)
    {
        $cssId      = deserialize($model->cssID, true);
        $formId     = $cssId[0] ?: ('f' . $model->id);
        $validation = new Validation($formId);

        $this->assembleSettings($validation, $settings);
        $this->assembleFields($validation, $fields);

        return $validation;
    }

    /**
     * Assemble form settings.
     *
     * @param Validation      $validation The form validation.
     * @param ValidationModel $settings   The validation model.
     *
     * @return void
     */
    private function assembleSettings(Validation $validation, $settings)
    {
        if ($settings->button_selector || $settings->button_disabled) {
            $validation->setButton($settings->button_selector, $settings->button_disabled);
        }

        if ($settings->err_class || $settings->err_container) {
            $validation->setError($settings->err_class, $settings->err_container ?: null);
        }

        $this->assembleIcon($validation, $settings, Validation::ICON_VALID);
        $this->assembleIcon($validation, $settings, Validation::ICON_INVALID);
        $this->assembleIcon($validation, $settings, Validation::ICON_VALIDATING);

        foreach (deserialize($settings->excluded, true) as $excluded) {
            $validation->addExcluded($excluded);
        }

        $validation->setAutoFocus($settings->autofocus);
    }

    /**
     * Assemble validations for the form fields.
     *
     * @param Validation        $validation The form validation.
     * @param \FormFieldModel[] $fields     The form fields.
     *
     * @return void
     */
    private function assembleFields(Validation $validation, $fields)
    {
        foreach ($fields as $model) {
            if (!in_array($model->type, $this->widgets) || !$model->fv_enabled) {
                continue;
            }

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

            $this->assembleFieldValidators($field, $model);
        }
    }

    /**
     * Assemble icon setting.
     *
     * @param Validation      $validation The validation object.
     * @param ValidationModel $setting    The validation model.
     * @param string          $icon       The icon.
     *
     * @return void
     */
    private function assembleIcon(Validation $validation, $setting, $icon)
    {
        $property = 'icon_' . $icon;

        if ($setting->$property) {
            $validation->setIcon($icon, $setting->$property);
        }
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
     * Assemble field validators.
     *
     * @param Field           $field The validation field.
     * @param \FormFieldModel $model The field model.
     *
     * @return void
     */
    private function assembleFieldValidators(Field $field, $model)
    {
        $this->assembleStringLengthValidator($field, $model);
        $this->assembeFileValidator($field, $model);
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
                $options['min'] = (int)$model->minlength;
            }

            if ($model->maxlength > 0) {
                $options['max'] = (int)$model->maxlength;
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
    private function assembeFileValidator(Field $field, $model)
    {
        if ($model->type === 'upload') {
            $options = array('maxFiles' => 1);

            if ($model->extensions) {
                $options['extension'] = $model->extensions;
            }

            if ($model->maxlength > 0) {
                $options['maxSize'] = (int)$model->maxlength;
            }

            $field->addValidator('file', $options);
        }
    }
}
