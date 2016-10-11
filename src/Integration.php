<?php

/**
 * @package    contao-form-validation
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015-2016 netzmacht David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormValidation;

use Netzmacht\Contao\FormValidation\Model\ValidationModel;
use Netzmacht\Contao\Toolkit\View\Assets\AssetsManager;
use Netzmacht\JavascriptBuilder\Builder;

/**
 * Form validation integration into Contao.
 *
 * @package Netzmacht\Contao\FormValidation
 */
class Integration
{
    /**
     * The javascript builder.
     *
     * @var Builder
     */
    private $builder;

    /**
     * Validation assembler.
     *
     * @var Assembler
     */
    private $assembler;

    /**
     * The asset path.
     *
     * @var string
     */
    private $assetPath;

    /**
     * Supported frameworks.
     *
     * @var array
     */
    private $frameworks;

    /**
     * Default locale.
     *
     * @var string
     */
    private $locale;

    /**
     * Form validation cache.
     *
     * @var Cache
     */
    private $cache;

    /**
     * Loaded forms.
     *
     * @var array
     */
    private $loaded = array();

    /**
     * Assets manager.
     *
     * @var AssetsManager
     */
    private $assetsManager;

    /**
     * Construct.
     *
     * @param Builder       $builder       The javascript builder.
     * @param Assembler     $assembler     The form validation assembler.
     * @param Cache         $cache         Form validation cache.
     * @param AssetsManager $assetsManager Assets manager.
     * @param string        $assetPath     The asset path.
     * @param array         $frameworks    Default locale.
     * @param string        $locale        Loaded forms.
     */
    public function __construct(
        Builder $builder,
        Assembler $assembler,
        Cache $cache,
        AssetsManager $assetsManager,
        $assetPath,
        array $frameworks,
        $locale
    ) {
        $this->builder       = $builder;
        $this->assembler     = $assembler;
        $this->cache         = $cache;
        $this->assetsManager = $assetsManager;
        $this->locale        = $locale;
        $this->frameworks    = $frameworks;
        $this->assetPath     = $assetPath;
    }

    /**
     * Access the shared instance from the DI.
     *
     * @return Integration
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public static function getInstance()
    {
        return $GLOBALS['container']['form-validation.integration'];
    }

    /**
     * Inject the form validation.
     *
     * It's not possible to use the getForm hook for it. It's not called.
     *
     * @param \FormFieldModel[] $fields Form field widgets.
     * @param string            $formId The form id.
     * @param \FormModel        $model  The form model.
     *
     * @see    https://github.com/contao/core/issues/7660
     * @return \FormFieldModel[]
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function injectFormValidation($fields, $formId, $model)
    {
        if (TL_MODE === 'FE' && $model->fv_active && $model->fv_setting && !isset($this->loaded[$model->id])) {
            $settings = ValidationModel::findByPk($model->fv_setting);

            $this->assetsManager->addStylesheet($this->assetPath . '/css/formValidation.min.css', 'screen');
            $this->assetsManager->addJavascript($this->assetPath . '/js/formValidation.min.js');

            if ($settings && in_array($settings->framework, $this->frameworks)) {
                $this->assetsManager->addJavascript(
                    sprintf('%s/js/framework/%s.min.js', $this->assetPath, $settings->framework)
                );
            }

            if ($this->locale) {
                $this->assetsManager->addJavascript(sprintf('%s/js/language/%s.js', $this->assetPath, $this->locale));
            }

            $this->assetsManager->addJavascript($this->getValidationJavascript($model, $fields, $settings), false);

            $this->loaded[$model->id] = true;
        }

        return $fields;
    }

    /**
     * Get the validation javascript as file path.
     *
     * @param \FormModel        $model    The form model.
     * @param \FormFieldModel[] $fields   The form fields.
     * @param ValidationModel   $settings The validation settings.
     *
     * @return string
     */
    protected function getValidationJavascript($model, $fields, $settings)
    {
        if (!$this->cache->isCached($model->id, $this->locale) || \Config::get('bypassCache')) {
            $validation = $this->assembler->assemble($model, $fields, $settings, $this->locale);
            $javascript = $this->buildJavascript($validation);

            $this->cache->save($model->id, $javascript, $this->locale);
        }

        return $this->cache->filename($model->id, $this->locale);
    }

    /**
     * Build the javascript.
     *
     * @param Validation $validation Form validation.
     *
     * @return string
     */
    private function buildJavascript($validation)
    {
        $template = new \FrontendTemplate('form_validation_js');

        $template->validation = $validation;
        $template->javascript = $this->builder->encode($validation);

        return $template->parse();
    }
}
