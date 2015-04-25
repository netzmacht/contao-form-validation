<?php

/**
 * @package    contao-form-validation
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormValidation\Dca;

use Netzmacht\Contao\FormValidation\Model\ValidationModel;
use Netzmacht\Contao\Toolkit\Dca;
use Netzmacht\Contao\Toolkit\Dca\Options\OptionsBuilder;
use Netzmacht\Contao\Toolkit\ServiceContainerTrait;

/**
 * Dca helper for form data container.
 *
 * @package Netzmacht\Contao\FormValidation\Dca
 */
class Form
{
    use ServiceContainerTrait;

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
     * Get framework options.
     *
     * Contao forms are only supported of Contao 3.3 with the new form widget style.
     *
     * @return array
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function getFrameworks()
    {
        $options = $GLOBALS['FORMVALIDATION_FRAMEWORKS'];

// @codingStandardsIgnoreStart
//        if (version_compare(VERSION, '3.4', '>=')) {
//            $options[] = 'contao';
//        }
// @codingStandardsIgnoreEnd

        return $options;
    }

    /**
     * Get all settings.
     *
     * @return array
     */
    public function getSettings()
    {
        $collection = ValidationModel::findAll(array('order' => 'title'));

        return OptionsBuilder::fromCollection($collection, 'id', 'title')->getOptions();
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
        $cache = $this->getService('form-validation.cache');
        $cache->remove($dataContainer->id);
    }
}
