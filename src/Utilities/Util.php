<?php

namespace Tpay\OriginApi\Utilities;

/**
 * Utility class which helps with:
 *  - parsing template files
 *  - log library operations
 *  - handle POST array
 */
class Util
{
    const REMOTE_ADDR = 'REMOTE_ADDR';

    static $lang = 'en';
    static $libraryPath;
    static $loggingEnabled = true;
    static $customLogPatch;

    /** Override to set your own templates directory. You can modify the library templates copied to your custom path */
    static $customTemplateDirectory;

    /**
     * Parse template file
     *
     * @param string $templateFileName filename
     * @param array  $data
     *
     * @return string
     */
    public static function parseTemplate($templateFileName, $data = [])
    {
        if (is_null(static::$libraryPath)) {
            $data['static_files_url'] = $_SERVER['REQUEST_URI'].'/../../src/';
        } else {
            $data['static_files_url'] = static::$libraryPath;
        }
        if (is_null(static::$customTemplateDirectory)) {
            $templateDirectory = dirname(__FILE__).'/../../View/Templates/';
        } else {
            $templateDirectory = static::$customTemplateDirectory;
        }
        $buffer = false;

        if (ob_get_length() > 0) {
            $buffer = ob_get_contents();
            ob_clean();
        }
        $lang = new Lang();
        $lang->setLang(static::$lang);

        ob_start();
        if (file_exists($templateDirectory.$templateFileName.'.phtml')) {
            include_once $templateDirectory.$templateFileName.'.phtml';
        }

        if (file_exists($templateDirectory.$templateFileName.'.php')) {
            include_once $templateDirectory.$templateFileName.'.php';
        }

        $parsedHTML = ob_get_contents();
        ob_clean();

        if (false !== $buffer) {
            ob_start();
            echo $buffer;
        }

        return $parsedHTML;
    }

    /**
     * Save text to log file with details
     *
     * @param string $title action name
     * @param string $text  text to save
     */
    public static function log($title, $text)
    {
        if (false === self::$loggingEnabled) {
            return;
        }

        if (self::$customLogPatch) {
            Logger::setLogPath(self::$customLogPatch);
        }

        Logger::log($title, $text);
    }

    /**
     * Save one line to log file
     *
     * @param string $text text to save
     */
    public static function logLine($text)
    {
        if (false === self::$loggingEnabled) {
            return;
        }

        if (self::$customLogPatch) {
            Logger::setLogPath(self::$customLogPatch);
        }

        Logger::logLine($text);
    }

    /**
     * @param float|int $number
     * @param int       $decimals
     *
     * @return string
     */
    public static function numberFormat($number, $decimals = 2)
    {
        return number_format($number, $decimals, '.', '');
    }

    /**
     * Get value from $_POST array.
     * If not exists return false
     *
     * @param string $name
     * @param string $type variable type
     *
     * @throws TException
     */
    public static function post($name, $type)
    {
        if (!isset($_POST[$name])) {
            return false;
        }
        $val = $_POST[$name];
        if ('int' === $type) {
            $val = (int) $val;
        } elseif ('float' === $type) {
            $val = (float) $val;
        } elseif ('string' === $type) {
            $val = (string) $val;
        } elseif ('array' === $type) {
            $val = (array) $val;
        } else {
            throw new TException('Undefined $_POST variable type');
        }

        return $val;
    }

    public function setLanguage($lang)
    {
        static::$lang = $lang;

        return $this;
    }

    /**
     * Set custom library path
     *
     * @param string $path
     *
     * @return $this
     */
    public function setPath($path)
    {
        static::$libraryPath = $path;

        return $this;
    }
}
