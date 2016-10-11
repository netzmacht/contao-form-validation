<?php

/**
 * @package    contao-form-validation
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015-2016 netzmacht David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormValidation\Model;

/**
 * Validation model stores the validation settings.
 *
 * @package Netzmacht\Contao\FormValidation\Model
 */
class ValidationModel extends \Model
{
    /**
     * The table name.
     *
     * @var string
     */
    protected static $strTable = 'tl_form_validation';
}
