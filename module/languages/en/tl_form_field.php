<?php

/**
 * @package    contao-form-validation
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

$GLOBALS['TL_LANG']['tl_form_field']['formvalidation_legend'] = 'Client side validation';

$GLOBALS['TL_LANG']['tl_form_field']['fv_enabled'][0]      = 'Enable validation';
$GLOBALS['TL_LANG']['tl_form_field']['fv_enabled'][1]      = 'Enable client side validation.';
$GLOBALS['TL_LANG']['tl_form_field']['fv_autofocus'][0]    = 'Auto focus';
$GLOBALS['TL_LANG']['tl_form_field']['fv_autofocus'][1]    = 'Indicate the field will be focused on automatically if it is not valid.';
$GLOBALS['TL_LANG']['tl_form_field']['fv_selector'][0]     = 'Field selector';
$GLOBALS['TL_LANG']['tl_form_field']['fv_selector'][1]     = 'The CSS selector to indicate the field. It is used in case that it\'s not possible to use the name attribute for the field.';
$GLOBALS['TL_LANG']['tl_form_field']['fv_message'][0]      = 'Default error message';
$GLOBALS['TL_LANG']['tl_form_field']['fv_message'][1]      = 'The default error message for the field.';
$GLOBALS['TL_LANG']['tl_form_field']['fv_icon'][0]         = 'Show feedback icon';
$GLOBALS['TL_LANG']['tl_form_field']['fv_icon'][1]         = 'Enable or disable feedback icons.';
$GLOBALS['TL_LANG']['tl_form_field']['fv_verbose'][0]      = 'Verbose';
$GLOBALS['TL_LANG']['tl_form_field']['fv_verbose'][1]      = 'Whether to be verbose when validating a field or not.';
$GLOBALS['TL_LANG']['tl_form_field']['fv_threshold'][0]    = 'Threshold';
$GLOBALS['TL_LANG']['tl_form_field']['fv_threshold'][1]    = 'Do not live validate field until the length of field value exceed this number.';
$GLOBALS['TL_LANG']['tl_form_field']['fv_row'][0]          = 'Row selector';
$GLOBALS['TL_LANG']['tl_form_field']['fv_row'][1]          = 'CSS selector indicates the parent element of field.';
$GLOBALS['TL_LANG']['tl_form_field']['fv_trigger'][0]      = 'Verbose';
$GLOBALS['TL_LANG']['tl_form_field']['fv_trigger'][1]      = 'The field events (separated by a space) which are fired when the live validating mode is enabled.';
$GLOBALS['TL_LANG']['tl_form_field']['fv_err'][0]          = 'Error location';
$GLOBALS['TL_LANG']['tl_form_field']['fv_err'][1]          = 'Indicate where the error messages are shown.';
$GLOBALS['TL_LANG']['tl_form_field']['fv_err_selector'][0] = 'Error message selector';
$GLOBALS['TL_LANG']['tl_form_field']['fv_err_selector'][1] = 'CSS selector which indicates where the error messages should be shown.';
$GLOBALS['TL_LANG']['tl_form_field']['fv_advanced'][0]     = 'Advanced settings';
$GLOBALS['TL_LANG']['tl_form_field']['fv_advanced'][1]     = 'Override form validation settings.';
