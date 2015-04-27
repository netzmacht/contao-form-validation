<?php

/**
 * @package    contao-form-validation
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

return array(
    \Netzmacht\Contao\FormValidation\Event\BuildValidationFieldEvent::NAME => array(
        array($GLOBALS['container']['form-validation.assembler.field-assembler'], 'handle')
    ),

    \Netzmacht\Contao\FormValidation\Event\BuildValidationSettingEvent::NAME => array(
        array(new \Netzmacht\Contao\FormValidation\Assembler\SettingsAssembler(), 'handle')
    ),
);
