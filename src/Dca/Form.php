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
     * Add warning if the assets path is not set.
     *
     * @param mixed $value The value.
     *
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function addIncompleteWarning($value)
    {
        if ($value && !\Config::get('fv_assetPath')) {
            \Message::addError($GLOBALS['TL_LANG']['tl_form']['fv_incompleteWarning']);
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
        $cache = $this->getService('form-validation.cache');
        $cache->remove($dataContainer->id);
    }
}
