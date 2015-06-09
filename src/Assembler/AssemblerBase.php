<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormValidation\Assembler;

/**
 * This class provides basic methods being used from various assemblers.
 *
 * @package Netzmacht\Contao\FormValidation\Assembler
 */
abstract class AssemblerBase
{
    /**
     * Extract the field identifier.
     *
     * @param \FormFieldModel $model The field model.
     *
     * @return mixed|null|string
     */
    protected function getFieldIdentifier(\FormFieldModel $model)
    {
        $name = $model->name;

        if ($model->type === 'select' && $model->multiple) {
            $name .= '[]';
        } elseif($model->type === 'checkbox') {
            $name .= '[]';
        }

        return $name;
    }
}
