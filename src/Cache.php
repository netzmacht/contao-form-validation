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

/**
 * Form validation cache.
 *
 * @package Netzmacht\Contao\FormValidation
 */
class Cache
{
    /**
     * Check if the form validation is cached.
     *
     * @param int $formId The form id.
     *
     * @return bool
     */
    public function isCached($formId)
    {
        return file_exists(TL_ROOT . '/' . $this->filename($formId));
    }

    /**
     * Cache the content and return the cache file.
     *
     * @param int    $formId  The form id.
     * @param string $content The javascript.
     *
     * @return string
     */
    public function save($formId, $content)
    {
        $fileName = $this->filename($formId);
        $file     = new \File($fileName);

        $file->write($content);
        $file->close();

        return $fileName;
    }

    /**
     * Delete the cached config.
     *
     * @param int $formId The form id.
     *
     * @return void
     */
    public function remove($formId)
    {
        \Files::getInstance()->delete($this->filename($formId));
    }

    /**
     * Generate the file name.
     *
     * @param int $formId The form id.
     *
     * @return string
     */
    public function filename($formId)
    {
        return sprintf('assets/js/formvalidation-%s-%s.js', substr(md5('form-' . $formId), 0, 8), $formId);
    }
}
