<?php
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
     * @param Event $event
     */
    public function notifyListener(Event $event);
}