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
        $this->createField($validation, $fieldModel);
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
}
