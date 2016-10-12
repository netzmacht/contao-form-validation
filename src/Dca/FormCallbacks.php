<?php

/**
 * @package    contao-form-validation
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015-2016 netzmacht David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormValidation\Dca;

use ContaoCommunityAlliance\Translator\TranslatorInterface as Translator;
use Netzmacht\Contao\FormValidation\Cache;
use Netzmacht\Contao\FormValidation\Model\ValidationModel;
use Netzmacht\Contao\Toolkit\Dca;
use Netzmacht\Contao\Toolkit\Dca\Manager;
use Netzmacht\Contao\Toolkit\Dca\Options\OptionsBuilder;

/**
 * Dca helper for form data container.
 *
 * @package Netzmacht\Contao\FormValidation\Dca
 */
class FormCallbacks extends Dca\Callback\Callbacks
{
    /**
     * Name of the data container.
     *
     * @var string
     */
    protected static $name = 'tl_form';

    /**
     * Helper service name.
     *
     * @var string
     */
    protected static $serviceName = 'form-validation.dca.form';

    /**
     * Framework options.
     *
     * @var array
     */
    private $frameworks;

    /**
     * Data container manager.
     *
     * @var Cache
     */
    private $cache;

    /**
     * Translator.
     *
     * @var Translator
     */
    private $translator;

    /**
     * Form constructor.
     *
     * @param Manager    $dcaManager Data container manager.
     * @param Cache      $cache      Form validation cache.
     * @param Translator $translator Translator.
     * @param array      $frameworks Framework options.
     */
    public function __construct(Manager $dcaManager, Cache $cache, Translator $translator, array $frameworks)
    {
        parent::__construct($dcaManager);

        $this->frameworks = $frameworks;
        $this->cache      = $cache;
        $this->translator = $translator;
    }

    /**
     * Get framework options.
     *
     * Contao forms are only supported of Contao 3.3 with the new form widget style.
     *
     * @return array
     */
    public function getFrameworks()
    {
        return $this->frameworks;
    }

    /**
     * Get all settings.
     *
     * @return array
     */
    public function getSettings()
    {
        $collection = ValidationModel::findAll(array('order' => 'title'));

        return OptionsBuilder::fromCollection($collection, 'title')->getOptions();
    }

    /**
     * Add warning if the assets path is not set.
     *
     * @param mixed $value The value.
     *
     * @return mixed
     */
    public function addIncompleteWarning($value)
    {
        if ($value && !\Config::get('fv_assetPath')) {
            \Message::addError($this->translator->translate('fv_incompleteWarning', 'tl_form'));
        }

        return $value;
    }

    /**
     * Clear the cached form when form changed.
     *
     * @param \DataContainer $dataContainer The data container driver.
     *
     * @return void
     */
    public function clearCache($dataContainer)
    {
        $this->cache->remove($dataContainer->id);
    }
}
