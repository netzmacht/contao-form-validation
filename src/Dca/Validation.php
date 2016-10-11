<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormValidation\Dca;

use Netzmacht\Contao\Toolkit\Dca\Callback\Callbacks;
use Netzmacht\Contao\Toolkit\ServiceContainerTrait;

/**
 * Validation data container helper class.
 *
 * @package Netzmacht\Contao\FormValidation\Dca
 */
class Validation extends Callbacks
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
     * Initialize the view.
     *
     * @return void
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function initializeView()
    {
        if (\Input::get('popup')) {
            unset($GLOBALS['TL_DCA']['tl_form_validation']['list']['global_operations']['form']);
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
            $cache = $this->getServiceContainer()->getService('form-validation.cache');

            foreach ($collection as $form) {
                $cache->remove($form->id);
            }
        }
    }
}
