<?php

namespace app\models\DomainModel;

// require config settings

/**
 * This class encapsulates the business logic for pagination for displaying content that
 * requires more than one page.
 *
 * @package  Blop/app/models/DomainModel
 * @author   Thomas Punt
 * @license  MIT
 */
class Pagination
{
    /**
     * @var string|   $usage         The route this pagination object is attached to.
     * @var array|[]  $usages        The routes pagination can be used for.
     * @var int|1     $pageNo        The page number to load.
     * @var int|10    $perPageNo     The number of elements to load per page.
     * @var int|0     $elementCount  The number of records in the system that can be fetched.
     * @var bool|true $validity      Whether the pagination object is valid.
     * @var int|0     $from          The element number to start fetching results from.
     */
    private $usage = '',
            $usages = ['products'], // load in from config
            $pageNo = 1,
            $perPageNo = 1, // load in from config file
            $elementCount = 0,
            $validity = true,
            $from = 0;

    /**
     * Validates and sets the route the pagination is being used for, along with
     *
     * @param  string $usage             The title of the web page.
     * @param  int    $elementCount      The number of records in the system that can be fetched.
     * @param  int    $pageNo            The page number.
     * @throws InvalidArgumentException  Thrown if the usage specified is invalid.
     */
    public function __construct($usage, $elementCount, $pageNo)
    {
        $this->setUsage($usage);
        $this->setElementCount($elementCount);
        $this->setPageNo($pageNo);
    }

    /**
     * Validates and sets the usage (according to route name).
     *
     * @param  string $usage             The title of the web page.
     * @throws InvalidArgumentException  Thrown if the usage specified is invalid.
     */
    private function setUsage($usage)
    {
        if(!in_array($usage, $this->usages, true))
            throw new \InvalidArgumentException('Invalid usage specified.');

        $this->usage = $usage;
    }

    /**
     * Sets the element count to an instance variable.
     *
     * @param  string $eCount  The number of records in the system that can be fetched.
     */
    private function setElementCount($eCount)
    {
        $this->elementCount = (int) $eCount;
    }   

    /**
     * Validates and sets the page number to an instance variable.
     *
     * The validity instance variable is set to false (denoting that the pagination object
     * is invalid) if the page specified is out of range.
     *
     * @param  string $pageNo  The page number.
     */
    private function setPageNo($pageNo)
    {
        if($pageNo === '')
            return $this->setPageNo(1);

        $pageNo = (int) $pageNo;

        if($pageNo > 0 && $pageNo * $this->perPageNo - $this->perPageNo <= $this->elementCount) {
            $this->pageNo = $pageNo;
            $this->calculateRange();
        }else{
            $this->validity = false;
        }

    }

    /**
     * Sets the to and from instance variables by calculating them from the pageNo and perPageNo
     * instance variables;
     */
    private function calculateRange()
    {
        $this->from = $this->pageNo * $this->perPageNo - $this->perPageNo;
    }

    use MagicGetter;
}