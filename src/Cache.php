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
    const BASE_PATH = 'assets/js';

    /**
     * Contao file system.
     *
     * @var \Files
     */
    private $fileSystem;

    /**
     * Construct.
     *
     * @param \Files $fileSystem The file system.
     */
    public function __construct(\Files $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    /**
     * Check if the form validation is cached.
     *
     * @param int         $formId The form id.
     * @param string|null $locale The locale.
     *
     * @return bool
     */
    public function isCached($formId, $locale = null)
    {
        return file_exists(TL_ROOT . '/' . $this->filename($formId, $locale));
    }

    /**
     * Cache the content and return the cache file.
     *
     * @param int         $formId  The form id.
     * @param string      $content The javascript.
     * @param string|null $locale  The locale.
     *
     * @return string
     */
    public function save($formId, $content, $locale = null)
    {
        $fileName = $this->filename($formId, $locale);
        $file     = new \File($fileName);

        $file->write($content);
        $file->close();

        return $fileName;
    }

    /**
     * Delete the cached config. If no locale is given the whole related cache is removed.
     *
     * @param int         $formId The form id.
     * @param string|null $locale The locale.
     *
     * @return void
     */
    public function remove($formId, $locale = null)
    {
        if ($locale) {
            $this->fileSystem->delete($this->filename($formId, $locale));
        } else {
            $pattern = sprintf(
                '%s/%s/formvalidation-*-%s.js',
                TL_ROOT,
                static::BASE_PATH,
                $formId
            );

            foreach (glob($pattern) as $path) {
                $this->fileSystem->delete(substr($path, (strlen(TL_ROOT) + 1)));
            }
        }
    }

    /**
     * Generate the file name.
     *
     * @param int         $formId The form id.
     * @param string|null $locale The locale.
     *
     * @return string
     */
    public function filename($formId, $locale = null)
    {
        $locale = $locale ?: 'en';

        return sprintf(
            '%s/formvalidation-%s-%s-%s.js',
            static::BASE_PATH,
            substr(md5('form-' . $formId . '-' . $locale), 0, 8),
            $locale,
            $formId
        );
    }
}
