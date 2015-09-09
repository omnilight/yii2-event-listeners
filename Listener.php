<?php

namespace omnilight\events;

use omnilight\events\contracts\EmitterEventsProviderInterface;
use omnilight\events\contracts\ListenerMethodFinderInterface;
use yii\base\Component;
use yii\base\Event;


/**
 * Class Listener
 */
class Listener
{
    /**
     * @var EmitterEventsProviderInterface
     */
    private $eventsProvider;
    /**
     * @var ListenerMethodFinderInterface
     */
    private $methodFinder;

    function __construct(EmitterEventsProviderInterface $eventsProvider, ListenerMethodFinderInterface $methodFinder)
    {
        $this->eventsProvider = $eventsProvider;
        $this->methodFinder = $methodFinder;
    }


    /**
     * @param string | Component $emitter Class or class name that emits events
     * @param string | object $listener Listener class or class name that will listen to those events
     */
    public function bind($emitter, $listener)
    {
        $emitterReflection = new \ReflectionClass($emitter);
        $listenerReflection = new \ReflectionClass($listener);

        foreach ($this->eventsProvider->getEventNames($emitterReflection) as $eventName) {
            $methodReflection = $this->methodFinder->getMethodForEvent($listenerReflection, $eventName);

            $handler = $this->createHandler($listener, $methodReflection);

            if ($handler === false) {
                continue;
            }

            if (is_string($emitter)) {
                Event::on($emitter, $eventName, $handler);
            } elseif ($emitter instanceof Component) {
                $emitter->on($eventName, $handler);
            }
        }
    }

    /**
     * @param string | object $listener
     * @param \ReflectionMethod $methodReflection
     * @return array
     */
    protected function createHandler($listener, \ReflectionMethod $methodReflection)
    {
        if (is_string($listener) && $methodReflection->isStatic()) {
            return [$listener, $methodReflection->getName()];
        } elseif (is_object($listener) && $methodReflection->isStatic()) {
            return [get_class($listener), $methodReflection->getName()];
        } elseif (is_object($listener) && $methodReflection->isStatic() == false) {
            return [$listener, $methodReflection->getName()];
        }
        return false;
    }

    /**
     * @param string | Component $emitter Class or class name that emits events
     * @param string | object $listener Listener class or class name that will listen to those events
     */
    public function unbind($emitter, $listener)
    {
        $emitterReflection = new \ReflectionClass($emitter);
        $listenerReflection = new \ReflectionClass($listener);

        foreach ($this->eventsProvider->getEventNames($emitterReflection) as $eventName) {
            $methodReflection = $this->methodFinder->getMethodForEvent($listenerReflection, $eventName);

            $handler = $this->createHandler($listener, $methodReflection);

            if ($handler === false) {
                continue;
            }

            if (is_string($emitter)) {
                Event::off($emitter, $eventName, $handler);
            } elseif ($emitter instanceof Component) {
                $emitter->off($eventName, $handler);
            }
        }
    }
}