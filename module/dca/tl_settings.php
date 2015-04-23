<?php

/**
 * @package    contao-form-validation
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

\Bit3\Contao\MetaPalettes\MetaPalettes::appendFields(
    'tl_settings',
    'form_validation',
    array('fv_assetPath')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['fv_assetPath'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['fv_assetPath'],
    'inputType' => 'text',
    'exclude'   => true,
    'eval'      => array(
        'tl_class' => 'long',
    ),
    'sql'       => "varchar(128) NOT NULL default ''"
);
