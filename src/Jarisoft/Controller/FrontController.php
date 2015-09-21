<?php
namespace Jarisoft\Controller;

require_once 'src/Jarisoft/Controller/Controller.php';
require_once 'src/Jarisoft/Controller/ViewController.php';
require_once 'src/Jarisoft/Resources/EventListener.php';
require_once 'src/Jarisoft/Model/EventManager.php';
require_once 'src/Jarisoft/Model/URLShortener.php';
require_once 'src/Jarisoft/Model/DBManager.php';
use Jarisoft\Resources\EventListener;
use Jarisoft\Resources\Event;
use Jarisoft\Model\EventManager;
use Jarisoft\Controller\ViewController;
use URLShortener;

/**
 * This class is the controller of this application.
 *
 * It handles the GET and POST requests, it initialised the applications components
 * and handles the responses.
 *
 * @author jakob
 *        
 */
class FrontController extends Controller implements EventListener
{

    /**
     * This array stores all incoming events
     *
     * @var array
     */
    private $eventList = array();

    private $eventManager;

    private $viewController;

    private $urlShortenator;

    private $configFile = "/src/config/config.php";

    private $config;

    /**
     * Constructor of this class initialised several components of this appliaction
     * and set them up to control them.
     */
    public function __construct()
    {
        $this->configFile = realpath(".") . $this->configFile;
        $this->config = parse_ini_file($this->configFile, TRUE);
        $this->eventManager = new EventManager();
        $this->eventManager->addEventListener($this);
        $this->viewController = new ViewController();
        $this->urlShortenator = new URLShortener($this->eventManager, $this->config);
        
        $this->initApplication();
    }

    /**
     * This method checks for the method that was called and handles them accordingly
     */
    private function initApplication()
    {
        
        /*
         * We have only two cases to handle.
         *
         * GET means we have to handle redirections (if any parameter) or show forms
         *
         * POST only means we have to handle form submissions.
         */
        if ($this->isGetRequest()) {
            
            if ($this->hasValidParameter()) {
                
                $parameter = $this->getParameter();
                /*
                 * if we have no parameter show welcome page
                 */
                if (strlen($parameter) === 0) {
                    $this->viewController->welcomeAction($this->getPageInformation(), $this->eventList);
                } else {
                    /*
                     * This is the part where we need the URLShortenater
                     *
                     * If we have a parameter that fit one of our valid URLs
                     * we redirect immediately.
                     */
                    
                    $targetURL = $this->urlShortenator->getTargetURL($parameter);
                    /*
                     * If no match could be found for parameter $parameter we should show error page.
                     */
                    if (empty($targetURL)) {
                        $event = new Event(Event::WARNING);
                        $event->setEventMessage("No matching URL could be found with this parameter. Please try again.");
                        $this->eventManager->notifyListener($event);
                        $this->viewController->errorAction($this->getPageInformation(), $this->eventList);
                    } else {
                        $this->redirectTo($targetURL);
                    }
                }
            } else {
                $event = new Event(Event::WARNING);
                $event->setEventMessage("This URL couldn't be found please make sure you have not misspelled the address. Please try again.");
                $this->eventManager->notifyListener($event);
                $this->viewController->errorAction($this->getPageInformation(), $this->eventList);
            }
        } else {
            $this->handlePost();
        }
    }

    /**
     * This method handles all form submissions.
     */
    private function handlePost()
    {
        $session = $this->getSession(false);
        $parameter = $this->getParameter();
        $event = null;
        // Check if we have submitted the right form.
        if ($parameter['random_key'] === $session['random_key']) {
            
            if (isset($_POST['submit_create'])) {
                $url = $_POST['input_field'];
                if (\Validator::isValidURL($url)) {
                    // Check now if url exists and if it redirects
                    $url = \Validator::getValidatedURL($url);
                    // check if url even exists before we move on
                    if ($this->isUrlExist($url)) {
                        // check if target url redirects
                        $allowRedirect = ($this->config['shortener']['redirect'] === 'on');
                        if ($allowRedirect || ! $this->isUrlRedirect($url)) {
                            /*
                             * Check if we have already a record for this target url
                             */
                            if ($this->urlShortenator->targetURLExists(\Validator::getValidatedURL($url))) {
                                $event = new Event(Event::WARNING);
                                $event->setEventMessage("A shortened URL with of this target already exists. You can redirect a URL only once.");
                                $this->eventManager->notifyListener($event);
                                $this->viewController->errorAction($this->getPageInformation(), $this->eventList);
                            } else {
                                $shortURL = $this->urlShortenator->generateShortURL($url);
                                var_dump($shortURL);
                                $data = $this->getPageInformation();
                                $data["shortURL"] = $shortURL;
                                $this->viewController->shortGeneratedAction($data, $this->eventList);
                            }
                        } else {
                            $event = new Event(Event::WARNING);
                            $event->setEventMessage("Given URL points to a redirecting node which is permitted.");
                            $this->eventManager->notifyListener($event);
                            $this->viewController->errorAction($this->getPageInformation(), $this->eventList);
                        }
                    } else {
                        $event = new Event(Event::ERROR);
                        $event->setEventMessage("The URL '$url doesn't exist or produces an error.");
                        $this->eventManager->notifyListener($event);
                        $this->viewController->errorAction($this->getPageInformation(), $this->eventList);
                    }
                } else {
                    $event = new Event(Event::ERROR);
                    $event->setEventMessage("Given URL has not the right format and doesn't validate to a URL.");
                    $this->eventManager->notifyListener($event);
                    $this->viewController->errorAction($this->getPageInformation(), $this->eventList);
                }
            } else 
                
                // This is the case where we want to look up a shortURL or a targetURL
                
                if (isset($_POST['submit_lookup'])) {
                    $url = \Validator::getValidatedURL($_POST['input_field']);
                    // var_dump($this->config);
                    $pos = strpos($url, $this->config['shortener']['targetURL']);
                    var_dump($pos);
                    // we probably have a targetURL as input and are looking for the shortURL
                    $data = $this->getPageInformation();
                    $data['lookup'] = $url;
                    if ($pos === false) {
                        $shortURLs = $this->urlShortenator->getShortenURL($url);
                        if ($shortURLs !== false) {
                            $shortURL = $shortURLs;
                            $data['match_found'] = true;
                            $data['match'] = $shortURL;
                        } else {
                            $data['match_found'] = false;
                        }
                    } else {
                        // get Parameter from given shortURL
                        $param = substr($url, strlen($this->config['shortener']['targetURL']) + 1);
                        if (strlen($param) === 0) {
                            $data['match_found'] = false;
                        } else {
                            $targetURLs = $this->urlShortenator->getTargetURLObject($param);
                            if ($targetURLs !== false) {
                                $data['match_found'] = true;
                                $data['match'] = $targetURLs;
                            } else {
                                $data['match_found'] = false;
                            }
                        }
                    }
                    
                    $this->viewController->matchResultAction($data, $this->eventList);
                }
        } else {
            $event = new Event(Event::WARNING);
            $event->setEventMessage("An older form was submitted. Try again");
            $this->eventManager->notifyListener($event);
            $this->viewController->welcomeAction($this->getPageInformation(), $this->eventList);
        }
    }

    public function __toString()
    {
        return "FrontController";
    }

    /**
     * This method is called every time we want to issue the ViewController.
     *
     * @return array holds information for ViewController
     */
    private function getPageInformation()
    {
        $data = array(
            "countActiveShortURLs" => $this->urlShortenator->countActiveShortURLs(), "server_address" => $this->config['shortener']['targetURL']
        );
        return $data;
    }

    /*
     * (non-PHPdoc)
     * @see \Jarisoft\Resources\EventListener::processEvent()
     */
    public function processEvent(Event $event)
    {
        // just store all incoming events inside the event list in allocated array.
        $this->eventList[$event->getEventType()][] = $event;
    }
}