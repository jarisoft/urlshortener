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

namespace Jarisoft\Resources;

/**
 * This class is used for all error, information and warning procession.
 *
 *
 * Events can occour at several points of this application for instance 
 * when accessing the database, wrong inputs, ...
 * 
 * @author jakob
 *        
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

    /**
     * Indicates something not critical happened.
     * 
     * @var unknown
     */
    const WARNING = 2;

    private $eventType;

    private $eventMessage;

    /**
     * Each event is constructed with a event type.
     * Events can be instantiated by: 
     * 
     *  $event = new Event(Event::ERROR);
     *  which indicates that instantiated event has error type. 
     * @param int event type.
     */
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

    public function getEventType()
    {
        return $this->eventType;
    }
}