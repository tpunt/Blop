<?php

namespace app\models\DomainModel;

/**
 * This class encapsulates the business logic for populating the content of all web pages.
 *
 * @package  Blop/app/models/DomainModel
 * @author   Thomas Punt
 * @license  MIT
 */
class WebPageContent
{
    /**
     * @var string| $webPageTitle    The title of the web page.
     * @var array|  $webPageContent  The content of all dynamic elements of a web page.
     */
    private $webPageTitle = '',
            $webPageContent = [];

    /**
     * Sets the web page title via a private validation function.
     *
     * @param  string $webPageTitle      The title of the web page.
     * @throws InvalidArgumentException  Thrown if the page title being set is too short.
     */
    public function __construct($webPageTitle)
    {
        $this->setWebPageTitle($webPageTitle);
    }

    /**
     * Validates and sets the user ID to an instance variable.
     *
     * @param  string $webPageTitle      The title of the web page.
     * @throws InvalidArgumentException  Thrown if the page title is too short.
     */
    private function setWebPageTitle($webPageTitle)
    {
        if(strlen($webPageTitle) < 3)
            throw new \InvalidArgumentException('The page title is too short.');

        $this->webPageTitle = $webPageTitle;
    }

    /**
     * Validates and adds a page content element to the webPageContent instance variable.
     *
     * @param  string $content           The content of an element of the web page.
     * @throws InvalidArgumentException  Thrown if the page content is too short.
     */
    public function addWebPageContent($content)
    {
        if(strlen($content) < 50)
            throw new \InvalidArgumentException('The page content isn\'t long enough');
            
        array_push($this->webPageContent, $content);
    }

    use MagicGetter;
}