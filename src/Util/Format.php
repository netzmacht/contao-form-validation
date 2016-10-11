<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015-2016 netzmacht David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormValidation\Util;

/**
 * Javascript string format util class.
 *
 * @package Netzmacht\Contao\FormValidation\Util
 */
class Format
{
    /**
     * Convert a locale to an country code.
     *
     * @param string $locale The locale.
     *
     * @return string
     */
    public static function convertLocaleToCountryCode($locale)
    {
        $parts = explode('_', $locale);

        if (isset($parts[1])) {
            return $parts[1];
        }

        return strtoupper($parts[0]);
    }

    /**
     * Convert a given date format.
     *
     * @param string $format The php date format.
     *
     * @return bool
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public static function convertDateFormat($format)
    {
        $converted = '';
        $length    = strlen($format);

        for ($pos = 0; $length > $pos; $pos++) {
            switch ($format[$pos]) {
                case 'd':
                    $converted .= 'DD';
                    break;

                case 'm':
                    $converted .= 'MM';
                    break;

                case 'Y':
                    $converted .= 'YYYY';
                    break;

                case 'i':
                    $converted .= 'm';
                    break;

                case 'h':
                case 's':
                case '.':
                case ' ':
                case '|':
                case '/':
                case '-':
                    $converted .= $format[$pos];
                    break;

                default:
                    // unsupported format.
                    return false;
            }
        }

        return $converted;
    }
}
