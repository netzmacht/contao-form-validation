<?php

/**
 * @package    contao-form-validation
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

use Netzmacht\Contao\FormValidation\Assembler;
use Netzmacht\Contao\FormValidation\Assembler\FieldAssembler;
use Netzmacht\Contao\FormValidation\Cache;
use Netzmacht\Contao\FormValidation\Dca\Form;
use Netzmacht\Contao\FormValidation\Dca\FormField;
use Netzmacht\Contao\FormValidation\Dca\Validation;
use Netzmacht\Contao\FormValidation\Integration;
use Netzmacht\Contao\Toolkit\DependencyInjection\Services;
use Netzmacht\JavascriptBuilder\Builder;

global $container;

$container['form-validation.integration'] = $container->share(
    function ($container) {
        return new Integration(
            $container['form-validation.javascript-builder'],
            $container['form-validation.assembler'],
            $container['form-validation.cache'],
            $container[Services::ASSETS_MANAGER],
            \Config::get('fv_assetPath'),
            (array) $GLOBALS['FORMVALIDATION_FRAMEWORKS'],
            $container['form-validation.locale']
        );
    }
);

$container['form-validation.cache'] = $container->share(
    function ($container) {
        return new Cache(
            $container[Services::FILE_SYSTEM]
        );
    }
);

$container['form-validation.assembler'] = $container->share(
    function ($container) {
        return new Assembler($container['event-dispatcher']);
    }
);

$container['form-validation.assembler.field-assembler'] = function () {
    return new FieldAssembler(
        (array) $GLOBALS['FORMVALIDATION_WIDGETS']
    );
};

$container['form-validation.javascript-builder'] = $container->share(
    function () {
        return new Builder();
    }
);

$container['form-validation.locale'] = function ($container) {
    /** @var \DependencyInjection\Container\PageProvider $provider */
    $provider = $container[Services::PAGE_PROVIDER];
    $page     = $provider->getPage();

    if (!$page) {
        return null;
    }

    $language = str_replace('-', '_', $page->language);
    $locales  = (array) $GLOBALS['FORMVALIDATION_LOCALES'];

    if (array_search($language, $locales) !== false) {
        return $language;
    }

    $language = substr($language, 0, 2);

    foreach ($locales as $locale) {
        if (substr($locale, 0, 2) === $language) {
            return $locale;
        }
    }

    return null;
};

$container['form-validation.dca.form'] = $container->share(
    function ($container) {
        return new Form(
            $container[Services::DCA_MANAGER],
            $container['form-validation.cache'],
            $GLOBALS['FORMVALIDATION_FRAMEWORKS']
        );
    }
);

$container['form-validation.dca.form-field'] = $container->share(
    function ($container) {
        return new FormField(
            $container[Services::DCA_MANAGER],
            $container['form-validation.cache']
        );
    }
);

$container['form-validation.dca.validation'] = $container->share(
    function ($container) {
        return new Validation(
            $container[Services::DCA_MANAGER],
            $container['form-validation.cache']
        );
    }
);
