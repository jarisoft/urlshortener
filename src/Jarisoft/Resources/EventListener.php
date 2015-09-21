<?php
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