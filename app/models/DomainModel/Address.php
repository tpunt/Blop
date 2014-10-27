<?php

namespace app\models\DomainModel;

// make full name lengths configurable?

/**
 * This class encapsulates the business logic for an address
 *
 * @package  Blop/app/models/DomainModel
 * @author   Thomas Punt
 * @license  MIT
 */
class Address
{
    /**
     * @var string| $fullName     The first and last name of the person.
     * @var string| $addressLine  The road name and number.
     * @var string| $townOrCity   The town/city of the addressLine.
     * @var string| $county       The county of the addressLine.
     * @var string| $postCode     The post code of the addressLine.
     * @var string| $phoneNumber  The phone number of the person to contact if need be.
     */
    private $fullName = '',
            $addressLine = '',
            $townOrCity = '',
            $county = '',
            $postCode = '',
            $phoneNumber = '';

    /**
     * Validate and set each of the properties of an address.
     *
     * @param  string $fullName          The first and last name of the person.
     * @param  string $addressLine       The road name and number.
     * @param  string $townOrCity        The town/city of the addressLine.
     * @param  string $county            The county of the addressLine.
     * @param  string $postCode          The post code of the addressLine.
     * @param  string $phoneNumber       The phone number of the person to contact if need be.
     * @throws InvalidArgumentException  Thrown if any fields contain invalid data.
     */
    public function __construct($fullName, $addressLine, $townOrCity, $county, $postCode, $phoneNumber)
    {
        $this->setFullName($fullName);
        $this->addressLine = $addressLine;
        $this->townOrCity = $townOrCity;
        $this->county = $county;
        $this->setPostCode($postCode);
        $this->setPhoneNumber($phoneNumber);
    }

    /**
     * Validates and sets the full name of the user for their address.
     *
     * @param  string $fullName          The first and last name of the person.
     * @throws InvalidArgumentException  Thrown if the full name is an invalid length.
     */
    private function setFullName($fullName)
    {
        if(strlen($fullName) < 3)
            throw new \InvalidArgumentException('Full name must be at least 3 characters in length.');

        $this->fullName = $fullName;
    }

    /**
     * Validates and sets the post code of the user for their address.
     *
     * @param string $postCode           The post code of the addressLine.
     * @throws InvalidArgumentException  Thrown if the post code is invalid
     */
    public function setPostCode($postCode)
    {
        if(!preg_match('~^([a-z]{2}[0-9]{1,2}) ?([0-9]{1}[a-z]{2})$~i', $postCode, $matches))
            throw new \InvalidArgumentException('Post code is invalid');

        $this->postCode = $matches[1].$matches[2];
    }

    /**
     * Validates and sets the phone number of the user for their address.
     *
     * @param string $phoneNumber        The phone number of the person to contact if need be.
     * @throws InvalidArgumentException  Thrown if the phone number is invalid
     */
    public function setPhoneNumber($phoneNumber)
    {
        $phoneNumber = str_replace(' ', '', $phoneNumber); // perhaps using a regular expression would be easier?

        if(!ctype_digit($phoneNumber))
            throw new \InvalidArgumentException('Only digits may be used within phone numbers.');

        $this->phoneNumber = $phoneNumber;
    }

    use MagicGetter;
}