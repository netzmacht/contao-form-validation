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

use Bit3\Contao\MetaPalettes\MetaPalettes;
use Netzmacht\Contao\FormValidation\Cache;
use Netzmacht\Contao\Toolkit\Dca\Callback\Callbacks;
use Netzmacht\Contao\Toolkit\Dca\Manager;

/**
 * Helper for form field data container.
 *
 * @package Netzmacht\Contao\FormValidation\Dca
 */
class FormFieldCallbacks extends Callbacks
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
     * Supported widgets.
     *
     * @var array
     */
    private $supportedWidgets;

    /**
     * FormField constructor.
     *
     * @param Manager $dcaManager       Data container manager.
     * @param Cache   $cache            Form validation cache.
     * @param array   $supportedWidgets Supported widget.
     */
    public function __construct(Manager $dcaManager, Cache $cache, array $supportedWidgets)
    {
        parent::__construct($dcaManager);

        $this->cache            = $cache;
        $this->supportedWidgets = $supportedWidgets;
    }

    /**
     * Add form validation to the palette of supported widgets.
     *
     * @return void
     */
    public function addFormValidationToPalette()
    {
        foreach ($this->getDefinition()->get(['palettes'], []) as $name => $palette) {
            if (is_array($palette) || !in_array($name, $this->supportedWidgets)) {
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
