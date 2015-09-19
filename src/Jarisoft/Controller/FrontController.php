<?php
namespace Jarisoft\Controller;

require_once 'src/Jarisoft/Controller/Controller.php';

use Jarisoft\Resources\EventListener;
use Jarisoft\Resources\Event;
use Jarisoft\Model\EventManager;

/**
 * File Name: FrontController.php
 * Author: Jakob Richter
 * Date: 18.09.2015
 * Version @version
 * =================================================================
 *
 * This script is used to
 * =================================================================
 */
class FrontController extends Controller implements EventListener
{
    
    private $eventList = array();
    private $eventManager;

    public function __construct()
    {
        $this->eventManager = new EventManager();
        $this->eventManager->addEventListener($this);
        
     
    }

    public function __toString() {
        return "FrontController";
    }
    
    /*
     * (non-PHPdoc)
     * @see \Jarisoft\Resources\EventListener::processEvent()
     */
    public function processEvent(Event $event)
    {
        // just store all incoming events
        $this->eventList[] = $event;
    }
}