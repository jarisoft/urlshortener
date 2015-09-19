<?php
namespace Jarisoft\Resources;

/**
 * File Name: Event.php
 * Author: Jakob Richter
 * Date: 17.09.2015
 * Version @version
 * =================================================================
 *
 * This script is used to
 * =================================================================
 */
 

class Event
{

    /**
     *
     * @var Indicates an error event
     */
    const ERROR = 0;

    /**
     *
     * @var Indicates a normal event
     */
    const MESSAGE = 1;
    
    const WARNING = 2;

    private $eventType;

    private $eventMessage;

    public function __construct($type)
    {
        $this->eventType = $type;
    }

    public function setEventMessage($string)
    {
        $this->eventMessage = $string;
    }

    public function getEventMessage()
    {
        return $this->eventMessage;
    }

    /**
     */
    public function getEventType()
    {
        return $this->eventType;
    }
}