<?php

namespace omnilight\events;
use omnilight\events\contracts\EmitterEventsProviderInterface;


/**
 * Class PatternEventsProvider
 */
class PatternEventsProvider implements EmitterEventsProviderInterface
{
    public $pattern = '/^EVENT_/';

    /**
     * @param \ReflectionClass $class
     * @return array
     */
    public function getEventNames(\ReflectionClass $class)
    {
        $events = [];

        foreach ($class->getConstants() as $constantName => $constantValue) {
            if (preg_match($this->pattern, $constantName) == 0) {
                continue;
            }

            $events[] = $constantValue;
        }

        return $events;
    }
}