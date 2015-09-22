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

use Jarisoft\Model\EventManager;

/**
 * This interface is implemented by every class that listens for Jarisoft\Resources\Event's.
 *
 * It has one function which is notifying Observers for incoming events.
 * Objects must be subscribed as Listener via addEventListener function of Jarisoft\Model\EventManager
 * and can be unsubscribed via removeEventListener function.
 *
 * @since 0.0.1
 * @author jakob
 * @see EventManager
 *
 */
interface EventListener
{

    /**
     * This method is called every time an Event occoures.
     *
     * @param Event $event            
     */
    public function processEvent(Event $event);
}