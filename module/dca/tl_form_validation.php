<?php

/**
 * @package    contao-form-validation
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

$GLOBALS['TL_DCA']['tl_form_validation'] = array
(
    'config' => array(
        'dataContainer'    => 'Table',
        'enableVersioning' => true,
        'onload_callback'  => array(
            array('Netzmacht\Contao\FormValidation\Dca\Form', 'initializeView'),
        ),
        'sql'              => array
        (
            'keys' => array
            (
                'id'    => 'primary',
            )
        )
    ),

    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 1,
            'fields'                  => array('title'),
            'flag'                    => 1,
            'panelLayout'             => 'limit',
            'headerFields'            => array('title', 'type'),
        ),
        'label' => array
        (
            'fields'                  => array('title', 'type'),
            'format'                  => '%s <span class="tl_gray">[%s]</span>',
        ),
        'global_operations' => array
        (
            'form' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_form_validation']['form'],
                'href'                => 'table=tl_form',
                'icon'                => 'form.gif',
                'attributes'          => 'onclick="Backend.getScrollOffset();"'
            ),
            'all' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
            ),
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_form_validation']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_form_validation']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.gif'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_form_validation']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_form_validation']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            )
        )
    ),

    'metapalettes'    => array(
        'default' => array(
            'title'    => array('title', 'framework', 'message'),
            'config'   => array('live', 'threshold', 'autofocus', 'verbose'),
            'icon'     => array('icon_valid', 'icon_invalid', 'icon_validating'),
            'selector' => array('button_selector', 'button_disabled', 'error_class', 'error_container', 'excluded'),
        ),
    ),

    'metasubpalettes' => array(
        'autoPan' => array('autoPanPadding')
    ),

    'fields' => array
    (
        'id'           => array
        (
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp'       => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'title'        => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_form_validation']['title'],
            'exclude'   => true,
            'inputType' => 'text',
            'eval'      => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql'       => "varchar(255) NOT NULL default ''"
        ),

        'framework' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_form_validation']['framework'],
            'inputType' => 'select',
            'exclude'   => true,
            'options_callback' => array('Netzmacht\Contao\FormValidation\Dca\Form', 'getFrameworks'),
            'eval'      => array(
                'tl_class'           => 'w50',
                'includeBlankOption' => true,
            ),
            'sql'       => "varchar(128) NOT NULL default ''"
        ),

        'live' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_form_validation']['live'],
            'inputType' => 'select',
            'exclude'   => true,
            'options'   => array('enabled', 'disabled', 'submitted'),
            'default'   => 'enabled',
            'eval'      => array(
                'tl_class' => 'w50',
                'choosen'  => true,
            ),
            'sql'       => "char(1) NOT NULL default ''"
        ),

        'autofocus' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_form_validation']['autofocus'],
            'inputType' => 'checkbox',
            'exclude'   => true,
            'default'   => true,
            'eval'      => array(
                'tl_class'           => 'w50',
            ),
            'sql'       => "char(1) NOT NULL default ''"
        ),

        'message' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_form_validation']['message'],
            'inputType' => 'text',
            'exclude'   => true,
            'eval'      => array(
                'tl_class'     => 'w50',
            ),
            'sql'       => "varchar(128) NOT NULL default ''"
        ),
        
        'threshold' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_form_validation']['threshold'],
            'inputType' => 'text',
            'exclude'   => true,
            'eval'      => array(
                'tl_class'     => 'w50',
                'rxgp'         => 'digit',
                'nullIfEmpty'  => true,
            ),
            'sql'       => "int(3) NULL"
        ),
        
        'verbose' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_form_validation']['verbose'],
            'inputType' => 'checkbox',
            'exclude'   => true,
            'default'   => true,
            'eval'      => array(
                'tl_class'           => 'w50',
            ),
            'sql'       => "char(1) NOT NULL default ''"
        ),
        
        'button_selector' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_form_validation']['button_selector'],
            'inputType' => 'text',
            'exclude'   => true,
            'eval'      => array(
                'tl_class'       => 'w50',
                'decodeEntities' => true
            ),
            'sql'       => "varchar(128) NOT NULL default ''"
        ),
        
        'button_disabled' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_form_validation']['button_disabled'],
            'inputType' => 'text',
            'exclude'   => true,
            'eval'      => array(
                'tl_class'     => 'w50',
            ),
            'sql'       => "varchar(128) NOT NULL default ''"
        ),
        
        'icon_valid' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_form_validation']['icon_valid'],
            'inputType' => 'text',
            'exclude'   => true,
            'eval'      => array(
                'tl_class'     => 'w50',
            ),
            'sql'       => "varchar(128) NOT NULL default ''"
        ),

        'icon_invalid' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_form_validation']['icon_invalid'],
            'inputType' => 'text',
            'exclude'   => true,
            'eval'      => array(
                'tl_class'     => 'w50',
            ),
            'sql'       => "varchar(128) NOT NULL default ''"
        ),

        'icon_validating' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_form_validation']['icon_validating'],
            'inputType' => 'text',
            'exclude'   => true,
            'eval'      => array(
                'tl_class'     => 'w50',
            ),
            'sql'       => "varchar(128) NOT NULL default ''"
        ),

        'error_class' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_form_validation']['error_class'],
            'inputType' => 'text',
            'exclude'   => true,
            'eval'      => array(
                'tl_class'     => 'w50',
            ),
            'sql'       => "varchar(128) NOT NULL default ''"
        ),

        'error_container' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_form_validation']['error_container'],
            'inputType' => 'text',
            'exclude'   => true,
            'eval'      => array(
                'tl_class'     => 'w50',
            ),
            'sql'       => "varchar(128) NOT NULL default ''"
        ),

        'excluded' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_form_validation']['excluded'],
            'inputType' => 'multiColumnWizard',
            'exclude'   => true,
            'eval'      => array(
                'tl_class'           => 'clr',
                'columnFields'       => array(
                    'exclude' => array(
                        'inputType' => 'text',
                        'exclude'   => true,
                        'eval'      => array(
                            'style' => 'width: 300px'
                        ),
                        'sql'       => "varchar(128) NOT NULL default ''"
                    )
                ),
                'flatArray' => true,
            ),
            'sql'       => "mediumblob NULL"
        )
    )
);
