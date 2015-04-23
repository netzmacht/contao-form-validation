<?php

global $container;

$container['form-validation.integration'] = $container->share(
    function ($container) {
        return new \Netzmacht\Contao\FormValidation\Integration(
            $container['form-validation.javascript-builder'],
            $container['form-validation.assembler'],
            new \Netzmacht\Contao\FormValidation\Cache(),
            \Config::get('fv_assetPath'),
            (array) $GLOBALS['FORMVALIDATION_FRAMEWORKS'],
            $container['form-validation.locale']
        );
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
