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
use Jarisoft\Resources\EventListener;
use Jarisoft\Resources\Event;
require_once 'src/Jarisoft/Resources/Event.php';
require_once 'src/Jarisoft/Resources/EventListener.php';

/**
 * This interface is used for event handling.
 *
 * @author jakob
 *        
 */
interface EventManagerInterface
{

    /**
     * This method adds a new EventListener to the set of subscibed listeners.
     *
     * @param EventListener $eventListener            
     */
    public function addEventListener(EventListener $eventListener);

    /**
     * Removes the listener from the list of EventListner.
     *
     * @param EventListener $eventListener            
     */
    public function removeEventListener(EventListener $eventListener);

    /**
     * Notifies all event listener for incoming Event.
     *
     * @param Event $event            
     */
    public function notifyListener(Event $event);
}