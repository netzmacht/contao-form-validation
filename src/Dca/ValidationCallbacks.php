<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015-2016 netzmacht David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormValidation\Dca;

use Netzmacht\Contao\FormValidation\Cache;
use Netzmacht\Contao\Toolkit\Dca\Callback\Callbacks;
use Netzmacht\Contao\Toolkit\Dca\Manager;

/**
 * Validation data container helper class.
 *
 * @package Netzmacht\Contao\FormValidation\Dca
 */
class ValidationCallbacks extends Callbacks
{
    /**
     * Name of the data container.
     *
     * @var string
     */
    protected static $name = 'tl_form_validation';

    /**
     * Helper service name.
     *
     * @var string
     */
    protected static $serviceName = 'form-validation.dca.validation';

    /**
     * Cache.
     *
     * @var Cache
     */
    private $cache;

    /**
     * Form constructor.
     *
     * @param Manager $dcaManager Data container manager.
     * @param Cache   $cache      Form validation cache.
     */
    public function __construct(Manager $dcaManager, Cache $cache)
    {
        parent::__construct($dcaManager);

        $this->cache = $cache;
    }

    /**
     * Initialize the view.
     *
     * @return void
     */
    public function initializeView()
    {
        if (\Input::get('popup')) {
            $operations = &$this->getDefinition()->get(['list', 'global_operations']);
            unset($operations['form']);
        }
    }

    /**
     * Clear the cache of the forms when a validation setting has changed.
     *
     * @param \DataContainer $dataContainer The data container.
     *
     * @return void
     */
    public function clearCache($dataContainer)
    {
        $collection = \FormModel::findBy(['fv_active=1', 'fv_setting=?'], $dataContainer->id);

        if ($collection) {
            foreach ($collection as $form) {
                $this->cache->remove($form->id);
            }
        }
    }
}
