<?php

namespace Themsaid\Multilingual;

class TranslationsManager
{
    private $translations;

    /**
     * @param $translations
     */
    public function __construct($translations)
    {
        $this->translations = $translations;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        return @$this->translations[$key] ?: '';
    }

    /**
     * Return an array of available locales with values
     *
     * @return array
     */
    public function toArray()
    {
        return $this->translations;
    }
}