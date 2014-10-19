<?php

namespace app\models\DomainModel;

/**
 * This trait is used to give domain model objects getter-like methods to all of their properties.
 *
 * @package  Blop/app/models/DomainModel
 * @author   Thomas Punt
 * @license  MIT
 */
trait MagicGetter
{
    /**
     * Implements getter methods for all properties of a class.
     *
     * Because of the naming convention used, when wanting to get the value of a property
     * called 'phoneNumber', we would invoke the method 'getPhoneNumber'. The __call method
     * simply removes the first three characters ('get') from the method name invoked (to get
     * 'PhoneNumber'), and then it changed the first letter to lower case (to get the property
     * name 'phoneNumber').
     *
     * @param  string $methodName      The name of the method invoked
     * @param  array  $args            The arguments to be passed to the method called. (This argument is ignored)
     * @throws BadMethodCallException  Thrown if the method called does not have a corresponding property
     * @return mixed                   The value of the property
     */
    public function __call($methodName, $args)
    {
        $property = lcfirst(substr($methodName, 3));

        if(!isset($this->$property))
            throw new \BadMethodCallException('Call to an undefined getter method.');

        return $this->$property;
    }
}