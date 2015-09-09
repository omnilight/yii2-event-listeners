<?php

namespace omnilight\events;
use omnilight\events\contracts\ListenerMethodFinderInterface;


/**
 * Class PrefixMethodFinder
 */
class PrefixMethodFinder implements ListenerMethodFinderInterface
{
    public $prefix = 'when';

    /**
     * @param \ReflectionClass $class
     * @param string $eventName
     * @return \ReflectionMethod | false
     */
    public function getMethodForEvent(\ReflectionClass $class, $eventName)
    {
        $methodName = $this->prefix . ucfirst($eventName);

        if ($class->hasMethod($methodName) == false) {
            return false;
        }

        return $class->getMethod($methodName);
    }
}