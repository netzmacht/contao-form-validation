<?php

/**
 * @package    contao-form-validation
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015-2016 netzmacht David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormValidation;

use Netzmacht\Contao\FormValidation\Event\BuildValidationFieldEvent;
use Netzmacht\Contao\FormValidation\Event\BuildValidationSettingEvent;
use Netzmacht\Contao\FormValidation\Model\ValidationModel;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as EventDispatcher;

/**
 * Assembler takes the form configuration and creates the validation object.
 *
 * @package Netzmacht\Contao\FormValidation
 */
class Assembler
{
    /**
     * The event dispatcher.
     *
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * Construct.
     *
     * @param EventDispatcher $eventDispatcher The event dispatcher.
     */
    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Assemble the form validation.
     *
     * @param \Form             $form          The form.
     * @param \FormFieldModel[] $fields        The form fields.
     * @param ValidationModel   $settings      The validation model.
     * @param string|null       $defaultLocale The default locale.
     *
     * @return Validation
     */
    public function assemble($form, $fields, $settings, $defaultLocale = null)
    {
        $cssId      = deserialize($form->cssID, true);
        $formId     = $cssId[0] ?: ('f' . $form->id);
        $validation = new Validation($formId);

        $validation->setLocale($defaultLocale);

        $event = new BuildValidationSettingEvent($validation, $form, $settings);
        $this->eventDispatcher->dispatch($event::NAME, $event);

        foreach ($fields as $model) {
            $event = new BuildValidationFieldEvent($validation, $form, $model);
            $this->eventDispatcher->dispatch($event::NAME, $event);
        }

        return $validation;
    }
}
