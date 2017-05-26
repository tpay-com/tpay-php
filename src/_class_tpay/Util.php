<?php

/*
 * Created by tpay.com
 */

namespace tpay;

/**
 * Class Util
 *
 * Utility class which helps with:
 *  - parsing template files
 *  - class loading
 *  - log library operations
 *  - handle POST array
 *
 * @package tpay
 */
class Util
{
    const REMOTE_ADDR = 'REMOTE_ADDR';

    /**
     * Parse template file
     * @param string $templateFileName filename
     * @return string
     */
    public static function parseTemplate($templateFileName, $data = array())
    {
        $templateDirectory = dirname(__FILE__) . '/../';
        $buffer = false;

        if (ob_get_length() > 0) {
            $buffer = ob_get_contents();
            ob_clean();
        }
        ob_start();

        if (!file_exists($templateDirectory . $templateFileName . '.phtml')) {
            return '';
        }
        include_once $templateDirectory . $templateFileName . '.phtml';
        $parsedHTML = ob_get_contents();
        ob_clean();

        if ($buffer !== false) {
            ob_start();
            echo $buffer;
        }

        return $parsedHTML;
    }

    /**
     * Checking installed PHP version
     *
     * @throws TException
     */
    public static function checkVersionPHP()
    {
        if (version_compare(phpversion(), '5.3.0', '<')) {
            throw new TException(sprintf('Your PHP version is too old, please upgrade to a newer version.
             Your version is %s, library requires %s', phpversion(), '5.3.0'));
        }
    }

    /**
     * Require PHP file
     *
     * @param string $name file name without php extension
     *
     * @throws TException
     */
    public static function loadClass($name)
    {
        $classDirectory = dirname(__FILE__) . '/../_class_tpay/';
        $filePath = $classDirectory . $name . '.php';

        if (!file_exists($classDirectory)) {

            throw new TException('directory not found (' . $classDirectory . ')');
        }
        if (!file_exists($filePath)) {
            throw new TException('no such a file (' . $filePath . ')');
        }
        require_once($filePath);
    }

    /**
     * Save text to log file with details
     *
     * @param string $title action name
     * @param string $text text to save
     */
    public static function log($title, $text)
    {
        $text = (string)$text;
        $logFilePath = dirname(__FILE__) . '/../log';

        $ip = (isset($_SERVER[static::REMOTE_ADDR])) ? $_SERVER[static::REMOTE_ADDR] : '';

        $logText = "\n===========================";
        $logText .= "\n" . $title;
        $logText .= "\n===========================";
        $logText .= "\n" . date('Y-m-d H:i:s');
        $logText .= "\nip: " . $ip;
        $logText .= "\n";
        $logText .= $text;
        $logText .= "\n\n";

        if (file_exists($logFilePath) && is_writable($logFilePath)) {
            file_put_contents($logFilePath, $logText, FILE_APPEND);
        }
    }

    /**
     * Save one line to log file
     *
     * @param string $text text to save
     */
    public static function logLine($text)
    {
        $text = (string)$text;
        $logFilePath = dirname(__FILE__) . '/../log';
        if (file_exists($logFilePath) && is_writable($logFilePath)) {
            file_put_contents($logFilePath, "\n" . $text, FILE_APPEND);
        }
    }

    /**
     * Get value from $_POST array.
     * If not exists return false
     *
     * @param string $name
     * @param string $type variable type
     *
     * @return mixed
     * @throws TException
     */
    public static function post($name, $type)
    {
        if (!isset($_POST[$name])) {
            return false;
        }
        $val = $_POST[$name];
        if ($type === 'int') {
            $val = (int)$val;
        } elseif ($type === 'float') {
            $val = (float)$val;
        } elseif ($type === 'string') {
            $val = (string)$val;
        } elseif ($type === 'array') {
            $val = (array)$val;
        } else {
            throw new TException('Undefined $_POST variable type');
        }

        return $val;
    }

    /**
     * Get substring by pattern
     *
     * @param string $pattern pattern
     * @param string $string content
     *
     * @return string
     */
    public static function findSubstring($pattern, $string)
    {
        preg_match_all($pattern, $string, $matches);
        if (isset($matches[1]) && isset($matches[1][0])) {
            return $matches[1][0];
        }
        return '';
    }
}
