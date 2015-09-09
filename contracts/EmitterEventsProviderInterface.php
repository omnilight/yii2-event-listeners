<?php

namespace omnilight\events\contracts;


/**
 * Interface EmitterEventsProviderInterface
 */
interface EmitterEventsProviderInterface
{
    /**
     * @param \ReflectionClass $class
     * @return array
     */
    public function getEventNames(\ReflectionClass $class);
}