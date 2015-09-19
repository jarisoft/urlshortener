<?php
namespace Jarisoft\Controller;

/**
 * This controller handles URL and basic server focused functions.
 *
 * The main functionality of this controller is to serve other controllers with basic
 * functionality like URL validation and redirects.
 * 
 * @author jakob
 * @since 0.0.1
 *         
 */
class Controller
{

    public function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getURL()
    {
        $url = $_SERVER['REQUEST_URI'];
        echo "<br>" . $_SERVER['HTTP_HOST'] . "<br>";
        return $url;
    }

    /**
     * Checks if a given URL is redirecting to another URL.
     *
     * @param string $url
     *            the url to be checked
     * @return string|boolean If the given $url redirected to another URL the method will
     *         return the URL otherwise false which indicates that the $url does not redirect.
     */
    public function isUrlRedirect($url)
    {
        $ch = curl_init();
        // We want the header to be passed to the data stream
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $out = curl_exec($ch);
        $out = str_replace("\r", "", $out);
        // We are only interested in the real header information not the rest of if
        $headers_end = strpos($out, "\n\n");
        if ($headers_end !== false) {
            $out = substr($out, 0, $headers_end);
        }
        $headers = explode("\n", $out);
        foreach ($headers as $header) {
            // Check if key 'Location' exist in array
            if (substr($header, 0, 10) == "Location: ") {
                $redirectURL = substr($header, 10);
                return $redirectURL;
            }
        }
        
        return false;
    }

    /**
     * Checks if a given $url exists.
     *
     * @param string $url
     *            the URL
     * @return boolean FALSE if the URL does not exists otherwise TRUE
     */
    public function isUrlExist($url)
    {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_exec($ch);
        $returnCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($returnCode === 200) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Redirects to the given $url.
     *
     * @param string $url            
     */
    public function redirectTo($url)
    {
        header("Location: " . $url);
        exit();
    }
}