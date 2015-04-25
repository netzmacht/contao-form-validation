<?php

/**
 * @package    contao-form-validation
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

global $container;

$container['form-validation.integration'] = $container->share(
    function ($container) {
        return new \Netzmacht\Contao\FormValidation\Integration(
            $container['form-validation.javascript-builder'],
            $container['form-validation.assembler'],
            $container['form-validation.cache'],
            \Config::get('fv_assetPath'),
            (array) $GLOBALS['FORMVALIDATION_FRAMEWORKS'],
            $container['form-validation.locale']
        );
    }
);

$container['form-validation.cache'] = $container->share(
    function () {
        return new \Netzmacht\Contao\FormValidation\Cache(\Files::getInstance());
    }
);

$container['form-validation.assembler'] = $container->share(
    function () {
        return new \Netzmacht\Contao\FormValidation\Assembler((array) $GLOBALS['FORMVALIDATION_WIDGETS']);
    }
);

$container['form-validation.javascript-builder'] = $container->share(
    function () {
        return new \Netzmacht\JavascriptBuilder\Builder();
    }
);

$container['form-validation.locale'] = function ($container) {
    $page = $container['page-provider']->getPage();

    if (!$page) {
        return null;
    }

    $language = str_replace('-', '_', $page->language);
    $locales  = (array) $GLOBALS['FORMVALIDATION_LOCALES'];

    if (array_search($language, $locales) !== false) {
        $this->locale = $language;

        return $language;
    }

    $language = substr($language, 0, 2);

    foreach ($locales as $locale) {
        if (substr($locale, 0, 2) === $language) {
            $this->locale = $locale;

            return $locale;
        }
    }

    return null;
};
