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

use Netzmacht\Contao\FormValidation\Event\BuildValidationSettingEvent;
use Netzmacht\Contao\FormValidation\Model\ValidationModel;
use Netzmacht\Contao\FormValidation\Validation;

/**
 * Class SettingsAssembler creates the validation settings.
 *
 * @package Netzmacht\Contao\FormValidation\Assembler
 */
class SettingsAssembler
{
    /**
     * Handle the event.
     *
     * @param BuildValidationSettingEvent $event The subscribed event.
     *
     * @return void
     */
    public function handle(BuildValidationSettingEvent $event)
    {
        $settings   = $event->getValidationModel();
        $validation = $event->getValidation();

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
}
