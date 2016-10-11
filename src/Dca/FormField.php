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

use Bit3\Contao\MetaPalettes\MetaPalettes;
use Netzmacht\Contao\FormValidation\Cache;
use Netzmacht\Contao\Toolkit\Dca\Callback\Callbacks;
use Netzmacht\Contao\Toolkit\Dca\Manager;

/**
 * Helper for form field data container.
 *
 * @package Netzmacht\Contao\FormValidation\Dca
 */
class FormField extends Callbacks
{
    /**
     * Name of the data container.
     *
     * @var string
     */
    protected static $name = 'tl_form_field';

    /**
     * Helper service name.
     *
     * @var string
     */
    protected static $serviceName = 'form-validation.dca.form-field';

    /**
     * Form validation cache.
     *
     * @var Cache
     */
    private $cache;

    /**
     * FormField constructor.
     *
     * @param Manager $dcaManager Data container manager.
     * @param Cache   $cache      Form validation cache.
     */
    public function __construct(Manager $dcaManager, Cache $cache)
    {
        parent::__construct($dcaManager);

        $this->cache = $cache;
    }

    public static function callback($serviceName, $methodName = null)
    {
        return parent::callback($serviceName, $methodName); // TODO: Change the autogenerated stub
    }

    /**
     * Add form validation to the palette of supported widgets.
     *
     * @return void
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function addFormValidationToPalette()
    {
        foreach ($this->getDefinition()->get(['palettes'], []) as $name => $palette) {
            if (is_array($palette) || !in_array($name, $GLOBALS['FORMVALIDATION_WIDGETS'])) {
                continue;
            }

            MetaPalettes::appendBefore('tl_form_field', $name, 'expert', array(
                'formvalidation' => array('fv_enabled')
            ));
        }

        if ($this->getDefinition()->has(['palettes', 'checkbox'])) {
            MetaPalettes::appendFields('tl_form_field', 'checkbox', 'expert', array('minlength', 'maxlength'));
        }
    }

    /**
     * Clear the cached form field when form changed.
     *
     * @param \DataContainer $dataContainer The data container driver.
     *
     * @return void
     */
    public function clearCache($dataContainer)
    {
        $this->cache->remove($dataContainer->activeRecord->pid);
    }
}
