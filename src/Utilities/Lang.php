<?php

namespace Tpay\Utilities;

use Tpay\Translations\Keys;

class Lang extends Keys
{
    private $currentLanguage = 'en';

    /**
     * Change current language
     *
     * @param string $lang language code
     *
     * @throws TException
     */
    public function setLang($lang)
    {
        if (array_key_exists($lang, $this->translations)) {
            $this->currentLanguage = $lang;
        } else {
            throw new TException('This language is not supported: '.print_r($lang, true));
        }
    }

    public function getLang()
    {
        return $this->currentLanguage;
    }

    /**
     * Get and print translated string
     */
    public function l($key)
    {
        echo $this->get($key);
    }

    /**
     * Get translated string
     *
     * @param string $key
     *
     * @return string
     */
    public function get($key)
    {
        return $this->translations[$this->currentLanguage][$key];
    }
}
