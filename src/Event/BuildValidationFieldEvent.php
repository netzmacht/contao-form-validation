<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015-2016 netzmacht David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormValidation\Event;

use Netzmacht\Contao\FormValidation\Validation;
use Symfony\Component\EventDispatcher\Event;

/**
 * The build validation field event is triggered for building validation for a form field.
 *
 * @package Netzmacht\Contao\FormValidation\Event
 */
class BuildValidationFieldEvent extends Event
{
    const NAME = 'form-validation.build-validation-field';

    /**
     * The form model.
     *
     * @var \Form
     */
    private $form;

    /**
     * The field model.
     *
     * @var \FormFieldModel
     */
    private $fieldModel;

    /**
     * The validation object.
     *
     * @var Validation
     */
    private $validation;

    /**
     * Construct.
     *
     * @param Validation      $validation The validation object.
     * @param \Form           $form       The form.
     * @param \FormFieldModel $fieldModel The form field model.
     */
    public function __construct(Validation $validation, \Form $form, \FormFieldModel $fieldModel)
    {
        $this->validation = $validation;
        $this->form       = $form;
        $this->fieldModel = $fieldModel;
    }

    /**
     * Get the form.
     *
     * @return \Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Get fieldModel.
     *
     * @return \FormFieldModel
     */
    public function getFieldModel()
    {
        return $this->fieldModel;
    }

    /**
     * Get validation.
     *
     * @return Validation
     */
    public function getValidation()
    {
        return $this->validation;
    }
}
