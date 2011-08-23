<?php
/**
 * GooglPHP
 *
 * A PHP class for shorting/expanding URLs with the official Goo.gl API.
 *
 * @author Fabian Beiner (mail@fabian-beiner.de)
 * @link http://fabian-beiner.de
 * @license Creative Commons Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0)
 * @version 1.0 (January 11th, 2011)
 * @package Google
 */

if (!function_exists('curl_init')) {
    trigger_error('Sorry, you need the cURL PHP extension.');
}

class GooglPHP {
    /**
     * The URL of the Goo.gl API.
     * @var string
     */
    private static $_strApiUrl = 'https://www.googleapis.com/urlshortener/v1/url?key=AIzaSyDwxW4H-oKpL7aua_IvO5W1yGUxXb_O33Y';

    /**
     * cURL timeout.
     * @var int
     */
    private static $_intCurlTimeout = 5;


    /**
     * Shorten a long URL with the Goo.gl URL.
     *
     * @param string $strLongUrl
     * @return string If the shortening was successful, return Goo.gl URL, else return the long URL.
     */
    public static function shortURL($strLongUrl) {
        // I would love to use “filter_var($strLongUrl, FILTER_VALIDATE_URL)” here,
        // but let us be honest, it sucks even more than regular expressions do.
        // (http://snipplr.com/view/14198/useful-regex-functions/)
        if (!preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $strLongUrl)) {
            return false;
        }
        $oCurl = curl_init(self::$_strApiUrl);
        curl_setopt_array($oCurl, array (CURLOPT_HTTPHEADER     => array('Content-Type: application/json')
                                        ,CURLOPT_RETURNTRANSFER => 1
                                        ,CURLOPT_TIMEOUT        => ($intTimeout = (int)self::$_intCurlTimeout ? $intTimeout : 5)
                                        ,CURLOPT_CONNECTTIMEOUT => 0
                                        ,CURLOPT_POST           => 1
                                        ,CURLOPT_SSL_VERIFYHOST => 0
                                        ,CURLOPT_SSL_VERIFYPEER => 0
                                        ,CURLOPT_POSTFIELDS     => '{"longUrl": "' . $strLongUrl . '"}'));
        $strJson = json_decode(curl_exec($oCurl), true);
        return ($strJson['id'] ? $strJson['id'] : $strLongUrl);
    }

    /**
     * Expand a Goo.gl URL to the long URL.
     *
     * @param string $strShortUrl
     * @return string If the expanding was successful, return long URL, else return the Goo.gl URL.
     */
    public static function expandURL($strShortUrl) {
        if (!preg_match('#http://goo.gl/(.*)#i', $strShortUrl)) {
            return false;
        }
        $oCurl = curl_init(self::$_strApiUrl . '?shortUrl=' . $strShortUrl);
        curl_setopt_array($oCurl, array (CURLOPT_RETURNTRANSFER => 1
                                        ,CURLOPT_TIMEOUT        => ($intTimeout = (int)self::$_intCurlTimeout ? $intTimeout : 5)
                                        ,CURLOPT_CONNECTTIMEOUT => 0
                                        ,CURLOPT_SSL_VERIFYHOST => 0
                                        ,CURLOPT_SSL_VERIFYPEER => 0));
        $strJson = json_decode(curl_exec($oCurl), true);
        return ($strJson['longUrl'] ? $strJson['longUrl'] : $strShortUrl);
    }
}
?>