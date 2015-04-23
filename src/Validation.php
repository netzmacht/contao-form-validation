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
use Netzmacht\JavascriptBuilder\Flags;
use Netzmacht\JavascriptBuilder\Type\ConvertsToJavascript;

/**
 * Validation class.
 *
 * @package Netzmacht\Contao\FormValidation
 */
class Validation implements ConvertsToJavascript
{
    const ICON_VALID      = 'valid';
    const ICON_INVALID    = 'invalid';
    const ICON_VALIDATING = 'validating';

    /**
     * The uses validation state icons.
     *
     * @var array
     */
    private $icon = array(
        self::ICON_VALID      => null,
        self::ICON_INVALID    => null,
        self::ICON_VALIDATING => null
    );

    /**
     * The gramework.
     *
     * @var string
     */
    private $framework;

    /**
     * Excluded selectors.
     *
     * @var array
     */
    private $excluded = array();

    /**
     * The button.
     *
     * @var array
     */
    private $button;

    /**
     * Enable autofocus.
     *
     * @var bool
     */
    private $autoFocus;

    /**
     * Error options.
     *
     * @var array
     */
    private $err;

    /**
     * Live setting.
     *
     * @var string
     */
    private $live;

    /**
     * Default error message.
     *
     * @var string
     */
    private $message;

    /**
     * The row container.
     * 
     * @var string
     */
    private $row;

    /**
     * Threshold character length.
     * 
     * @var int
     */
    private $threshold;

    /**
     * The trigger.
     *
     * @var string
     */
    private $trigger;

    /**
     * Verbose mode.
     *
     * @var bool
     */
    private $verbose;

    /**
     * Validation fields.
     *
     * @var array
     */
    private $fields = array();

    /**
     * The form html id.
     *
     * @var string
     */
    private $formId;

    /**
     * Locale setting.
     *
     * @var string
     */
    private $locale;

    /**
     * Construct.
     *
     * @param string $formId The form id.
     * @param string $locale The locale.
     */
    public function __construct($formId, $locale = null)
    {
        $this->formId = $formId;
        $this->locale = $locale;
    }

    /**
     * Set the icon.
     *
     * @param string $type  The icon type.
     * @param string $class The icon class.
     *
     * @return $this
     */
    public function setIcon($type, $class)
    {
        $this->icon[$type] = $class;

        return $this;
    }

    /**
     * Get framework.
     *
     * @return string
     */
    public function getFramework()
    {
        return $this->framework;
    }

    /**
     * Set framework.
     *
     * @param string $framework Framework.
     *
     * @return $this
     */
    public function setFramework($framework)
    {
        $this->framework = $framework;

        return $this;
    }

    /**
     * Get excluded.
     *
     * @return array
     */
    public function getExcluded()
    {
        return $this->excluded;
    }

    /**
     * Add excluded.
     *
     * @param string $excluded Excluded selector.
     *
     * @return $this
     */
    public function addExcluded($excluded)
    {
        $this->excluded[] = $excluded;

        return $this;
    }

    /**
     * Get button selector.
     *
     * @return string
     */
    public function getButtonSelector()
    {
        if (!empty($this->button['selector'])) {
            return $this->button['selector'];
        }

        return null;
    }

    /**
     * Get button disabled.
     *
     * @return string
     */
    public function getButtonDisabled()
    {
        if (!empty($this->button['disabled'])) {
            return $this->button['disabled'];
        }

        return null;
    }

    /**
     * Set button.
     *
     * @param string $button   The button.
     * @param string $disabled The disabled class.
     *
     * @return $this
     */
    public function setButton($button, $disabled = '')
    {
        $this->button = array(
            'selector' => $button,
            'disabled' => $disabled
        );

        return $this;
    }

    /**
     * Get autofocus.
     *
     * @return boolean
     */
    public function isAutoFocus()
    {
        return $this->autoFocus;
    }

    /**
     * Set auto focus.
     *
     * @param boolean $autoFocus Auto focus.
     *
     * @return $this
     */
    public function setAutoFocus($autoFocus)
    {
        $this->autoFocus = (bool) $autoFocus;

        return $this;
    }

    /**
     * Set error data.
     *
     * @param string $class     The error class.
     * @param null   $container The container selector.
     *
     * @return $this
     */
    public function setError($class, $container = null)
    {
        $this->err = array(
            'clazz'     => $class,
            'container' => $container
        );

        return $this;
    }

    /**
     * Get error class.
     *
     * @return string|null
     */
    public function getErrorClass()
    {
        if (!empty($this->err['clazz'])) {
            return $this->err['clazz'];
        }

        return null;
    }

    /**
     * Get error class.
     *
     * @return string|null
     */
    public function getErrorContainer()
    {
        if (!empty($this->err['container'])) {
            return $this->err['container'];
        }

        return null;
    }

    /**
     * Get live.
     *
     * @return string
     */
    public function getLive()
    {
        return $this->live;
    }

    /**
     * Set live.
     *
     * @param string $live Live.
     *
     * @return $this
     */
    public function setLive($live)
    {
        $this->live = $live;

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
     * @return mixed
     */
    public function getRow()
    {
        return $this->row ? $this->row['container'] : null;
    }

    /**
     * Set row.
     *
     * @param mixed $row Row.
     *
     * @return $this
     */
    public function setRow($row)
    {
        $this->row = array(
            'container' => $row
        );

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
     * Get trigger.
     *
     * @return mixed
     */
    public function getTrigger()
    {
        return $this->trigger;
    }

    /**
     * Set trigger.
     *
     * @param mixed $trigger Trigger.
     *
     * @return $this
     */
    public function setTrigger($trigger)
    {
        $this->trigger = $trigger;

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
        $this->verbose = $verbose;

        return $this;
    }

    /**
     * Add a field.
     *
     * @param Field|field $field The form field.
     *
     * @return Field
     */
    public function addField($field)
    {
        if (!$field instanceof Field) {
            $field = new Field($field);
        }

        $this->fields[$field->getName()] = $field;

        return $field;
    }

    /**
     * Get formId.
     *
     * @return string
     */
    public function getFormId()
    {
        return $this->formId;
    }

    /**
     * Get locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set locale.
     *
     * @param string $locale Locale.
     *
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Encode the javascript representation of the object.
     *
     * @param Encoder  $encoder The javascript encoder.
     * @param int|null $flags   The encoding flags.
     *
     * @return string
     */
    public function encode(Encoder $encoder, $flags = null)
    {
        $options = get_object_vars($this);
        unset($options['formId']);
        $options = $this->removeEmptyOptions($options);

        if (!empty($options['fields'])) {
            foreach ($options['fields'] as $name => $value) {
                /** @var Field $value */
                $options['fields'][$name] = $value->getOptions();
            }
        }

        return sprintf(
            '$(\'#%s\').formValidation(%s);',
            $this->getFormId(),
            $encoder->encodeArray($options, Flags::add(JSON_FORCE_OBJECT, $flags))
        );
    }

    /**
     * Remove empty options.
     *
     * @param array $options Options.
     *
     * @return array
     */
    private function removeEmptyOptions($options)
    {
        $options = array_filter(
            $options,
            function ($item) {
                return $item !== null;
            }
        );

        $options = array_map(
            function ($item) {
                if (is_array($item)) {
                    $item = $this->removeEmptyOptions($item);
                }

                return $item;
            },
            $options
        );

        return $options;
    }
}
