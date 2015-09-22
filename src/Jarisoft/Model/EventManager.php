<?php

/*
 * Copyright 2015 Jakob
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Jarisoft\Model;

require_once 'src/Jarisoft/Model/EventManagerInterface.php';

use Jarisoft\Resources\EventListener;
use Jarisoft\Resources\Event;

/**
 * This class handles events and (un)subscibe EventListener.
 *
 * This class implements Jarisoft\Model\EventManagerInterface and handles events in order to
 * dispatch them to all EventListener. Use the functions add- or removeEventListener to
 * subscribe or unsubscribe objects from listening for events.
 *
 * @since 0.0.1
 * @author jakob
 * @see Event
 *
 */
class EventManager implements \EventManagerInterface
{

    /* array holds all eventListener */
    private $eventListener;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->eventListener = array();
    }

    /*
     * (non-PHPdoc)
     * @see EventManagerInterface::addEventListener()
     */
    public function addEventListener(EventListener $eventListener)
    {
        $this->eventListener[] = $eventListener;
    }

    /*
     * (non-PHPdoc)
     * @see EventManagerInterface::removeEventListener()
     */
    public function removeEventListener(EventListener $listener)
    {
        $key = array_search($listener, $this->eventListener, true);
        if (FALSE !== $key) {
            unset($this->eventListener[$key]);
        }
    }

    /*
     * (non-PHPdoc)
     * @see EventManagerInterface::notifyListener()
     */
    public function notifyListener(Event $event)
    {
        foreach ($this->eventListener as $listener) {
            
            $event->setEventMessage($event->getEventMessage() . "<br>");
            echo $event->getEventMessage();
            $listener->processEvent($event);
        }
    }
}


