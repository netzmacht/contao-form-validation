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
 * Backend modules
 */
$GLOBALS['BE_MOD']['content']['form']['tables'][] = 'tl_form_validation';
$GLOBALS['BE_MOD']['content']['form']['tables'][] = 'tl_form_validator';


/*
 * Models
 */
$GLOBALS['TL_MODELS']['tl_form_validation'] = 'Netzmacht\Contao\FormValidation\Model\ValidationModel';


/*
 * Hooks
 */

// Not possible because of https://github.com/contao/core/issues/7660
//$GLOBALS['TL_HOOKS']['getForm'][] = array('Netzmacht\Contao\FormValidation\Integration', 'injectFormValidation');
$GLOBALS['TL_HOOKS']['compileFormFields'][] = array(
    'Netzmacht\Contao\FormValidation\Integration',
    'injectFormValidation'
);


/*
 * Form validation configuration
 */
$GLOBALS['FORMVALIDATION_WIDGETS'] = array(
    'text',
    'select',
    'checkbox',
    'radio',
    'upload',
    'textarea',
    'password'
);

$GLOBALS['FORMVALIDATION_LOCALES'] = array(
    'ar_MA',
    'be_FR', 'be_NL',
    'bg_BG',
    'ca_ES',
    'cs_CZ',
    'da_DK',
    'de_DE',
    'en_US',
    'es_CL', 'es_ES',
    'eu_ES',
    'fa_IR',
    'fi_FI',
    'fr_FR',
    'gr_EL',
    'he_IL',
    'hi_IN',
    'hu_HU',
    'id_ID',
    'it_IT',
    'ja_JP',
    'nl_NL',
    'no_NO',
    'pl_PL',
    'pt_BR', 'pt_PT',
    'ro_RO',
    'ru_RU',
    'sk_SK',
    'sq_AL',
    'sr_RS',
    'sv_SE',
    'th_TH',
    'tr_TR',
    'ua_UA',
    'vi_VN',
    'zh_CN', 'zh_TW'
);

$GLOBALS['FORMVALIDATION_FRAMEWORKS'] = array(
    'bootstrap',
    'foundation',
    'pure',
    'semantic',
    'uikit'
);
