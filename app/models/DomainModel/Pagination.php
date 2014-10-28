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
     * @var string| $webPageTitle    The title of the web page.
     * @var array|  $webPageContent  The content of all dynamic elements of a web page.
     */
    private $usage = '',
            $usages = ['Products'], // load in from config
            $pageNo = 1,
            $perPageNo = 2, // load in from config file
            $elementCount = 0,
            $validity = true,
            $from = 0,
            $to = 0;

    /**
     * Sets the web page title via a private validation function.
     *
     * @param  string $webPageTitle      The title of the web page.
     * @throws InvalidArgumentException  Thrown if the page title being set is too short.
     */
    public function __construct($usage, $elementCount, $pageNo)
    {
        $this->setUsage($usage);
        $this->setElementCount($elementCount);
        $this->setPageNo($pageNo);
    }

    /**
     * Validates and sets the web page title to an instance variable.
     *
     * @param  string $webPageTitle      The title of the web page.
     * @throws InvalidArgumentException  Thrown if the page title is too short.
     */
    private function setUsage($usage)
    {
        if(!in_array($usage, $this->usages, true))
            throw new \InvalidArgumentException('Invalid usage specified.');

        $this->usage = $usage;
    }

    /**
     * Validates and sets the web page title to an instance variable.
     *
     * @param  string $webPageTitle      The title of the web page.
     */
    private function setElementCount($eCount)
    {
        $this->elementCount = (int) $eCount;
    }   

    /**
     * Validates and sets the web page title to an instance variable.
     *
     * @param  string $webPageTitle      The title of the web page.
     * @throws InvalidArgumentException  Thrown if the page title is too short.
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

    private function calculateRange()
    {
        $this->to = $this->pageNo * $this->perPageNo;
        $this->from = $this->to - $this->perPageNo + 1;
    }

    use MagicGetter;
}