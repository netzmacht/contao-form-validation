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

use Netzmacht\Contao\FormValidation\Model\ValidationModel;
use Netzmacht\Contao\FormValidation\Validation;
use Symfony\Component\EventDispatcher\Event;

/**
 * The build validation setting event is triggered when building the validation settings from the form model.
 *
 * @package Netzmacht\Contao\FormValidation\Event
 */
class BuildValidationSettingEvent extends Event
{
    const NAME = 'form-validation.build-validation-setting';

    /**
     * The form model.
     *
     * @var \FormModel
     */
    private $form;

    /**
     * The validation object.
     *
     * @var Validation
     */
    private $validation;

    /**
     * The validation model.
     *
     * @var ValidationModel
     */
    private $validationModel;

    /**
     * Construct.
     *
     * @param Validation      $validation      The validation.
     * @param \Form           $form            The form.
     * @param ValidationModel $validationModel The validation model.
     */
    public function __construct(Validation $validation, \Form $form, ValidationModel $validationModel)
    {
        $this->validation      = $validation;
        $this->form            = $form;
        $this->validationModel = $validationModel;
    }

    /**
     * Get formModel.
     *
     * @return \Form
     */
    public function getForm()
    {
        return $this->form;
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

    /**
     * Get validationModel.
     *
     * @return ValidationModel
     */
    public function getValidationModel()
    {
        return $this->validationModel;
    }
}
