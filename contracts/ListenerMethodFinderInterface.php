<?php
/**
 * Created by PhpStorm.
 * User: Павел
 * Date: 09.09.2015
 * Time: 12:21
 */

namespace omnilight\events\contracts;


/**
 * Interface ListenerMethodFinderInterface
 */
interface ListenerMethodFinderInterface
{
    /**
     * @param \ReflectionClass $class
     * @param string $eventName
     * @return \ReflectionMethod | false
     */
    public function getMethodForEvent(\ReflectionClass $class, $eventName);
}