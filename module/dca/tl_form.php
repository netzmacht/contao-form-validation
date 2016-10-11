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
 * Config
 */
$GLOBALS['TL_DCA']['tl_form']['config']['onsubmit_callback'][] = \Netzmacht\Contao\FormValidation\Dca\Form::callback(
    'clearCache'
);

$GLOBALS['TL_DCA']['tl_form']['config']['ondelete_callback'][] = \Netzmacht\Contao\FormValidation\Dca\Form::callback(
    'clearCache'
);

/*
 * Global operations.
 */
array_insert(
    $GLOBALS['TL_DCA']['tl_form']['list']['global_operations'],
    0,
    array(
        'formvalidation' => array(
            'label'      => &$GLOBALS['TL_LANG']['tl_form']['formvalidation'],
            'href'       => 'table=tl_form_validation',
            'icon'       => 'form.gif',
            'attributes' => 'onclick="Backend.getScrollOffset();"'
        )
    )
);


/*
 * Palettes
 */
\Bit3\Contao\MetaPalettes\MetaPalettes::appendBefore(
    'tl_form',
    'expert',
    array(
        'formvalidation' => array(':hide', 'fv_active')
    )
);

$GLOBALS['TL_DCA']['tl_form']['metasubpalettes']['fv_active'] = array('fv_setting');


/*
 * Fields
 */
$GLOBALS['TL_DCA']['tl_form']['fields']['fv_active'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_form']['fv_active'],
    'inputType' => 'checkbox',
    'exclude'   => true,
    'eval'      => array(
        'tl_class'       => 'w50 m12',
        'submitOnChange' => true,
    ),
    'sql'       => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form']['fields']['fv_setting'] = array
(
    'label'            => &$GLOBALS['TL_LANG']['tl_form']['fv_setting'],
    'inputType'        => 'select',
    'exclude'          => true,
    'options_callback' => array(
        'Netzmacht\Contao\FormValidation\Dca\Form',
        'getSettings'
    ),
    'save_callback'    => array(
        \Netzmacht\Contao\FormValidation\Dca\Form::callback('addIncompleteWarning')
    ),
    'wizard'           => array(
        \Netzmacht\Contao\Toolkit\Dca\Callback\CallbackFactory::popupWizard(
            'do=form&amp;table=tl_form_validation',
            $GLOBALS['TL_LANG']['tl_form']['fv_edit_setting'],
            $GLOBALS['TL_LANG']['tl_form']['fv_edit_setting'],
            'edit.gif'
        ),
    ),
    'eval'             => array(
        'includeBlankOption' => true,
        'chosen'             => true,
        'tl_class'           => 'w50',
    ),
    'sql'              => "int(10) NOT NULL default '0'"
);
