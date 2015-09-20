<?php

class Validator
{

    /**
     * Checks if a given parameter array ($_GET) is valid according to application needs.
     *
     * This method checks if $parameterArray has length 0 or 1 and if there is a key checks if
     * key is either 0 or 'route'. If all the conditions validates to true return true
     * otherwise this method will return false.
     *
     * Example:
     * Following URLs should return true:
     * - www.example.com/
     * - www.example.com/me
     * - www.example.com/1
     * - www.example.com/?route=value
     * Following URLs shoudl return false:
     * - www.example.com/?row=value
     * - www.example.com/?route=value1&anotherky=value2
     *
     * @param array $parameterArray
     *            usually taken from $_GET
     * @return bool true if parameter array is valid according to the needs of this application,
     *         otherwise false.
     */
    public static function isValidParameter($parameterArray)
    {
        var_dump($parameterArray);
        $bool = (sizeof($parameterArray) <= 1);
        if (sizeof($parameterArray) === 1) {
            reset($parameterArray);
            $key = key($parameterArray);
            $bool = $bool && ($key === 0 || $key === 'route');
        }
        return $bool;
    }

    public static function isValidURL($urlToTest)
    {
        if (! filter_var($urlToTest, FILTER_VALIDATE_URL) === false) {
            
            return true;
        } else {
            if (strpos($urlToTest, "http://") === 0 || strpos($urlToTest, "https://") === 0) {
                return false;
            } else {
                return ((! filter_var("http://" . $urlToTest, FILTER_VALIDATE_URL) === false) || (! filter_var("https://" . $urlToTest, FILTER_VALIDATE_URL) === false));
            }
        }
    }
    
    public static function getValidatedURL($url) {
        if (strpos($url, "http://") === 0 || strpos($url, "https://") === 0 ) {
            return $url;
        } else {
            return "http://" . $url;
        }
    }
}