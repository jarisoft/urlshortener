<?php
namespace Jarisoft\Controller;

require_once 'src/Jarisoft/Resources/Validator.php';

/**
 * This controller handles URL and basic server focused issues.
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

    /**
     * Returns the requested method.
     *
     * @return string
     */
    public function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
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
            // Checks if 'Location' is one of the substring of each header
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
       
        if ($returnCode < 400) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns the single parameter if REQUEST_METHOD is GET because we only accept only one
     * paramter.
     * Otherwise it will return the $_POST array.
     *
     * @return mixed|unknown
     */
    public function getParameter()
    {
        if ($this->isGetRequest()) {
            $parameter = "";
            /*
             * Remove trailing slashes from parameter.
             */
            if (array_key_exists('route', $_GET)) {
                $parameter = preg_replace('/[\/]+/i', '', $_GET['route']);
            }
            return $parameter;
        } else 
            if ($this->isPostRequest()) {
                return $_POST;
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

    /**
     * Checks if REQUEST_METHOD is GET
     *
     * @return boolean
     */
    public function isGetRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if REQUEST_METHOD is POST
     *
     * @return boolean
     */
    public function isPostRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Uses Validator to check if $_GET array is valid according to
     * the needs of this application
     *
     * @return boolean true if parameter of $_GET are valid.
     */
    public function hasValidParameter()
    {
        return \Validator::isValidParameter($_GET);
    }

    /**
     * Creates or keeps a running session alive.
     * If $newSessionID === true the parameter
     * $_SESSION['random_key'] is set to a random string if this value has not been set
     * before.
     * 
     * @param bool $newSessionID            
     * 
     * @return the $_SESSION variale.
     */
    public function getSession($newSessionID)
    {
        session_start();
        if ($newSessionID) {
            if (! isset($_SESSION['random_key'])) {
                $_SESSION["random_key"] = substr(md5(rand()), 0, 20);
            }
        }
        return $_SESSION;
    }
}
