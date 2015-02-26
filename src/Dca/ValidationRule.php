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


use Netzmacht\Contao\Toolkit\Dca;
use Netzmacht\Contao\Toolkit\Dca\Options\OptionsBuilder;

class ValidationRule
{
    /**
     * Get the form fields.
     *
     * @param $dataContainer
     *
     * @return array
     */
    public function getFormFields($dataContainer)
    {
        if ($dataContainer->activeRecord->pid) {
            $fields = \FormFieldModel::findBy('pid', $dataContainer->activeRecord->pid, array('order' => 'name'));

            return OptionsBuilder::fromCollection($fields, 'id', 'name')->getOptions();
        }

        return array();
    }

}
