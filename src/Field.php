<?php

/**
 * @package    contao-form-validation
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormValidation;

use Netzmacht\JavascriptBuilder\Encoder;

/**
 * Form Validation field.
 *
 * @package Netzmacht\Contao\FormValidation
 */
class Field
{
    /**
     * The field name.
     *
     * @var string
     */
    private $name;

    /**
     * Indicate the field will be focused on automatically if it is not valid.
     *
     * @var bool
     */
    private $autoFocus;

    /**
     * Enable or disable the field validators.
     *
     * @var bool
     */
    private $enabled;

    /**
     * Indicate where the error messages are shown.
     *
     * @var string
     */
    private $err;

    /**
     * Indicate whether or not the field is excluded.
     *
     * @var bool
     */
    private $excluded;

    /**
     * The default error message for the field.
     *
     * @var string
     */
    private $message;

    /**
     * CSS selector indicates the parent element of field.
     *
     * @var string
     */
    private $row;

    /**
     * Enable or disable feedback icons.
     *
     * @var bool
     */
    private $icon;

    /**
     * The CSS selector to indicate the field.
     *
     * It is used in case that it's not possible to use the name attribute for the field.
     *
     * @var string
     */
    private $selector;

    /**
     * Verbose error messages.
     *
     * @var bool
     */
    private $verbose;

    /**
     * Validators.
     *
     * @var array
     */
    private $validators = array();

    /**
     * Threshold.
     *
     * @var int
     */
    private $threshold;

    /**
     * Construct.
     *
     * @param string $name The field name.
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get field name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get autoFocus.
     *
     * @return boolean
     */
    public function isAutoFocus()
    {
        return $this->autoFocus;
    }

    /**
     * Set autoFocus.
     *
     * @param boolean $autoFocus AutoFocus.
     *
     * @return $this
     */
    public function setAutoFocus($autoFocus)
    {
        $this->autoFocus = (bool) $autoFocus;

        return $this;
    }

    /**
     * Get enabled.
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set enabled.
     *
     * @param boolean $enabled Enabled.
     *
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = (bool) $enabled;

        return $this;
    }

    /**
     * Get err.
     *
     * @return string
     */
    public function getErr()
    {
        return $this->err;
    }

    /**
     * Set err.
     *
     * @param string $err Err.
     *
     * @return $this
     */
    public function setErr($err)
    {
        $this->err = $err;

        return $this;
    }

    /**
     * Get excluded.
     *
     * @return boolean
     */
    public function isExcluded()
    {
        return $this->excluded;
    }

    /**
     * Set excluded.
     *
     * @param boolean $excluded Excluded.
     *
     * @return $this
     */
    public function setExcluded($excluded)
    {
        $this->excluded = (bool) $excluded;

        return $this;
    }

    /**
     * Get message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set message.
     *
     * @param string $message Message.
     *
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get row.
     *
     * @return string
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * Set row.
     *
     * @param string $row Row.
     *
     * @return $this
     */
    public function setRow($row)
    {
        $this->row = $row;

        return $this;
    }

    /**
     * Get icon.
     *
     * @return boolean
     */
    public function isIcon()
    {
        return $this->icon;
    }

    /**
     * Set icon.
     *
     * @param boolean $icon Icon.
     *
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = (bool) $icon;

        return $this;
    }

    /**
     * Get selector.
     *
     * @return string
     */
    public function getSelector()
    {
        return $this->selector;
    }

    /**
     * Set selector.
     *
     * @param string $selector Selector.
     *
     * @return $this
     */
    public function setSelector($selector)
    {
        $this->selector = $selector;

        return $this;
    }

    /**
     * Get verbose.
     *
     * @return boolean
     */
    public function isVerbose()
    {
        return $this->verbose;
    }

    /**
     * Set verbose.
     *
     * @param boolean $verbose Verbose.
     *
     * @return $this
     */
    public function setVerbose($verbose)
    {
        $this->verbose = (bool) $verbose;

        return $this;
    }

    /**
     * Get threshold.
     *
     * @return int
     */
    public function getThreshold()
    {
        return $this->threshold;
    }

    /**
     * Set threshold.
     *
     * @param int $threshold Threshold.
     *
     * @return $this
     */
    public function setThreshold($threshold)
    {
        $this->threshold = $threshold;

        return $this;
    }

    /**
     * Get validators.
     *
     * @return array
     */
    public function getValidators()
    {
        return $this->validators;
    }

    /**
     * Add a validator option.
     *
     * @param string $type    Validator type.
     * @param array  $options Validator options.
     *
     * @return $this
     */
    public function addValidator($type, $options = array())
    {
        $this->validators[$type] = $options;

        return $this;
    }

    /**
     * Get field options.
     *
     * @return array
     */
    public function getOptions()
    {
        $options = get_object_vars($this);
        unset($options['name']);
        $options = array_filter(
            $options,
            function ($item) {
                return $item !== null;
            }
        );

        if (empty($options['validators'])) {
            unset($options['validators']);
        }

        return $options;
    }
}
