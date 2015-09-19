<?php
use Jarisoft\Resources\EventListener;
use Jarisoft\Resources\Event;
require_once 'src/Jarisoft/Resources/Event.php';
require_once 'src/Jarisoft/Resources/EventListener.php';
/**
 * File Name: EventManagerInterface.php
 * Author: Jakob Richter
 * Date: 17.09.2015
 * Version @version
 * =================================================================
 *
 * This script is used to
 * =================================================================
 */
interface EventManagerInterface
{

    public function addEventListener(EventListener $eventListener);

    public function removeEventListener(EventListener $eventListener);

    public function notifyListener(Event $event);
}