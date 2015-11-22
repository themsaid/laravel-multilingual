<?php

namespace Themsaid\Multilingual;

trait Translatable
{
    /**
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (isset($this->translatable)) {
            // We check if the attribute is translatable and return a proper
            // value based on the current locale
            if (in_array($key, $this->translatable)) {
                return $this->getValueOfCurrentLocaleForKey($key);
            };

            // We check if the attribute is expected to return the
            // TranslationManager's object
            $translatableKey = str_replace('Translations', '', $key);
            if (in_array($translatableKey, $this->translatable)) {
                return new TranslationsManager(
                    $this->getAttributeValue($translatableKey)
                );
            }
        }

        return parent::getAttribute($key);
    }

    /**
     * Get the value of current locale for $key attribute, if not found it falls
     * back to the fallback locale or the first locale in array.
     *
     * @param $key
     * @return string
     */
    public function getValueOfCurrentLocaleForKey($key)
    {
        $translations = $this->getAttributeValue($key);
        $currentLocale = config('app.locale');
        $fallbackLocale = config('multilingual.fallback_locale');

        if ( ! $translations) return "";

        if ( ! @$translations[$currentLocale]) {
            return @$translations[$fallbackLocale] ?: '';
        };

        return @$translations[$currentLocale];
    }

    /**
     * Alter the default Illuminate\Database\Eloquent\Model method for checking if attribute
     * should be casted as JSON, we check if the attribute is translatable & cast
     * it as JSON even if it's not casted as JSON in Model::$casts
     *
     * @param  string $key
     * @return bool
     */
    protected function isJsonCastable($key)
    {
        if (isset($this->translatable) && in_array($key, $this->translatable)) {
            return true;
        }

        return parent::isJsonCastable($key);
    }
}