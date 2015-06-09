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
use Netzmacht\Contao\Toolkit\ServiceContainerTrait;

/**
 * Helper for form field data container.
 *
 * @package Netzmacht\Contao\FormValidation\Dca
 */
class FormField
{
    use ServiceContainerTrait;

    /**
     * Add form validation to the palette of supported widgets.
     *
     * @return void
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function addFormValidationToPalette()
    {
        foreach ($GLOBALS['TL_DCA']['tl_form_field']['palettes'] as $name => $palette) {
            if (is_array($palette) || !in_array($name, $GLOBALS['FORMVALIDATION_WIDGETS'])) {
                continue;
            }

            MetaPalettes::appendBefore('tl_form_field', $name, 'expert', array(
                'formvalidation' => array('fv_enabled')
            ));
        }

        if (isset($GLOBALS['TL_DCA']['tl_form_field']['palettes']['checkbox'])) {
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
        $cache = $this->getService('form-validation.cache');
        $cache->remove($dataContainer->activeRecord->pid);
    }
}
