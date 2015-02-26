<?php

foreach ($GLOBALS['TL_DCA']['tl_form_field']['palettes'] as $name => $palette) {
    if (is_array($palette)) {
        continue;
    }
}

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fv_autofocus'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fv_autofocus'],
    'inputType' => 'checkbox',
    'exclude'   => true,
    'default'   => true,
    'eval'      => array(
        'tl_class'           => 'w50',
    ),
    'sql'       => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fv_enabled'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fv_enabled'],
    'inputType' => 'checkbox',
    'exclude'   => true,
    'default'   => true,
    'eval'      => array(
        'tl_class'           => 'w50',
    ),
    'sql'       => "char(1) NOT NULL default ''"
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
    'sql'       => "varchar(128) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fv_excluded'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fv_excluded'],
    'inputType' => 'checkbox',
    'exclude'   => true,
    'default'   => true,
    'eval'      => array(
        'tl_class'           => 'w50',
    ),
    'sql'       => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fv_icon'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fv_icon'],
    'inputType' => 'checkbox',
    'exclude'   => true,
    'default'   => true,
    'eval'      => array(
        'tl_class'           => 'w50',
    ),
    'sql'       => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fv_row'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fv_row'],
    'inputType' => 'text',
    'exclude'   => true,
    'eval'      => array(
        'tl_class'           => 'long clr',
        'submitOnChange'     => true,
        'includeBlankOption' => true,
    ),
    'sql'       => "varchar(128) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fv_selector'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fv_selector'],
    'inputType' => 'text',
    'exclude'   => true,
    'eval'      => array(
        'tl_class'     => 'w50',
    ),
    'sql'       => "varchar(128) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fv_threshold'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fv_threshold'],
    'inputType' => 'text',
    'exclude'   => true,
    'eval'      => array(
        'tl_class'     => 'w50',
        'rxgp'         => 'digit'
    ),
    'sql'       => "int(3) NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fv_trigger'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fv_trigger'],
    'inputType' => 'text',
    'exclude'   => true,
    'eval'      => array(
        'tl_class'     => 'w50',
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
        'tl_class'           => 'w50',
    ),
    'sql'       => "char(1) NOT NULL default ''"
);
