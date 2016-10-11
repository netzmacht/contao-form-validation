<?php

/**
 * @package    contao-form-validation
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

/*
 * Config.
 */
$GLOBALS['TL_DCA']['tl_form_field']['config']['palettes_callback'][] = \Netzmacht\Contao\FormValidation\Dca\FormField::callback(
    'addFormValidationToPalette'
);

$GLOBALS['TL_DCA']['tl_form_field']['config']['onsubmit_callback'][] = \Netzmacht\Contao\FormValidation\Dca\FormField::callback(
    'clearCache'
);

$GLOBALS['TL_DCA']['tl_form_field']['config']['ondelete_callback'][] = \Netzmacht\Contao\FormValidation\Dca\FormField::callback(
    'clearCache'
);


/*
 * Palettes.
 */
$GLOBALS['TL_DCA']['tl_form_field']['metasubpalettes']['fv_advanced'] = array(
    'fv_row',
    'fv_threshold',
    'fv_trigger',
    'fv_err',
);

$GLOBALS['TL_DCA']['tl_form_field']['metasubselectpalettes']['fv_enabled']['custom'] = array(
    'fv_autofocus',
    'fv_selector',
    'fv_message',
    'fv_icon',
    'fv_verbose',
    'fv_advanced'
);

$GLOBALS['TL_DCA']['tl_form_field']['metasubselectpalettes']['fv_err']['selector'] = array(
    'fv_err_selector'
);


/*
 * Fields.
 */
$GLOBALS['TL_DCA']['tl_form_field']['fields']['fv_autofocus'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fv_autofocus'],
    'inputType' => 'checkbox',
    'exclude'   => true,
    'default'   => true,
    'eval'      => array(
        'tl_class' => 'w50 m12',
    ),
    'sql'       => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fv_enabled'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fv_enabled'],
    'inputType' => 'select',
    'exclude'   => true,
    'default'   => 'default',
    'options'   => array('default', 'custom', 'disabled'),
    'eval'      => array(
        'tl_class'       => 'w50',
        'submitOnChange' => true,
    ),
    'sql'       => "char(8) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fv_message'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fv_message'],
    'inputType' => 'text',
    'exclude'   => true,
    'eval'      => array(
        'tl_class' => 'w50',
    ),
    'sql'       => "varchar(128) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fv_err'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fv_err'],
    'inputType' => 'select',
    'exclude'   => true,
    'options'   => array('tooltip', 'popover', 'selector'),
    'eval'      => array(
        'tl_class'           => 'w50',
        'submitOnChange'     => true,
        'includeBlankOption' => true,
    ),
    'sql'       => "varchar(16) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fv_err_selector'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fv_err_selector'],
    'inputType' => 'text',
    'exclude'   => true,
    'eval'      => array(
        'tl_class'           => 'w50',
        'submitOnChange'     => true,
        'includeBlankOption' => true,
        'decodeEntities'     => true,
    ),
    'sql'       => "varchar(128) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fv_icon'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fv_icon'],
    'inputType' => 'checkbox',
    'exclude'   => true,
    'default'   => true,
    'eval'      => array(
        'tl_class' => 'w50',
    ),
    'sql'       => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fv_advanced'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fv_advanced'],
    'inputType' => 'checkbox',
    'exclude'   => true,
    'default'   => false,
    'eval'      => array(
        'tl_class'       => 'w50 m12 clr',
        'submitOnChange' => true,
    ),
    'sql'       => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fv_row'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fv_row'],
    'inputType' => 'text',
    'exclude'   => true,
    'eval'      => array(
        'tl_class' => 'w50',
    ),
    'sql'       => "varchar(128) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fv_selector'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fv_selector'],
    'inputType' => 'text',
    'exclude'   => true,
    'eval'      => array(
        'tl_class'       => 'w50',
        'decodeEntities' => true,
    ),
    'sql'       => "varchar(128) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fv_threshold'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fv_threshold'],
    'inputType' => 'text',
    'exclude'   => true,
    'eval'      => array(
        'tl_class'    => 'w50',
        'rxgp'        => 'digit',
        'nullIfEmpty' => true,
    ),
    'sql'       => "int(3) NULL"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fv_trigger'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fv_trigger'],
    'inputType' => 'text',
    'exclude'   => true,
    'eval'      => array(
        'tl_class' => 'w50',
    ),
    'sql'       => "varchar(128) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fv_verbose'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fv_verbose'],
    'inputType' => 'checkbox',
    'exclude'   => true,
    'default'   => true,
    'eval'      => array(
        'tl_class' => 'w50',
    ),
    'sql'       => "char(1) NOT NULL default ''"
);
