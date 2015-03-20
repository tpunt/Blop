<?php

namespace app\models\DomainModel;

/**
 * This class is the aggregate root for a web page. It encapsulates the domain logic for
 * a web page (title, name (used for referencing) and content).
 *
 * @package  Blop/app/models/DomainModel
 * @author   Thomas Punt
 * @license  MIT
 */
class WebPage
{
    /**
     * @var string| $pageName     The (hidden) name of the web page used for referencing it in the DB
     * @var string| $pageTitle    The title of the web page
     * @var array|  $pageContent  The content of all dynamic elements of a web page
     */
    private $pageName = '',
            $pageTitle = '',
            $pageContent = [];

    /**
     * Sets the web page title via a private validation function.
     *
     * @param  string $pageTitle         The title of the web page
     * @throws InvalidArgumentException  Thrown if the page title is too short
     */
    public function __construct($pageTitle)
    {
        $this->setPageTitle($pageTitle);
    }

    /**
     * Sets the name that is associated to the web page.
     *
     * @param  string $pageName  The (hidden) name of the web page
     * @return WebPage           The current instance
     */
    public function setPageName($pageName)
    {
        $this->pageName = $pageName;

        return $this;
    }

    /**
     * Validates and sets the web page title to an instance variable.
     *
     * @param  string $pageTitle         The title of the web page
     * @throws InvalidArgumentException  Thrown if the page title is too short or long
     */
    private function setPageTitle($pageTitle)
    {
        $pageTitleLength = strlen($pageTitle);

        if ($pageTitleLength < 3 || $pageTitleLength > 50)
            throw new \InvalidArgumentException('The page title should be between 3 and 50 characters long (inclusive).');

        $this->pageTitle = $pageTitle;
    }

    /**
     * Validates and adds a page content element to the webPageContent instance variable.
     *
     * @param  string $content           The content of an element of the web page
     * @throws InvalidArgumentException  Thrown if the page content is too short
     */
    public function addPageContent(WebPageContent $content)
    {
        array_push($this->pageContent, $content);
    }

    /**
     * Returns the web page title.
     *
     * The MagicGetter trait is not used here because getting the web page content requires
     * the use of a generator (which the MagicGetter does not offer).
     *
     * @return string  The web page title
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    /**
     * Gets the name associated to the web page. This is used when updating a page's content, where each
     * page has a name associated to it in the DB.
     *
     * The MagicGetter trait is not used here because getting the web page content requires
     * the use of a generator (which the MagicGetter does not offer).
     *
     * @return string  The (hidden) name of the web page
     */
    public function getPageName()
    {
        return $this->pageName;
    }

    /**
     * Returns the web page content.
     *
     * A generator is used here so that we can automatically iterate over the array on sequential
     * invocations of this function.
     *
     * @return string  Parts of the web page content
     */
    public function getPageContent()
    {
        foreach ($this->pageContent as $content)
            yield $content->getContent();
    }

    public function getAllPageContent()
    {
        return $this->pageContent;
    }

    /**
     * Checks to see if the web page has any content associated to it.
     *
     * @return bool  Whether there is any content
     */
    public function hasPageContent()
    {
        return !empty($this->pageContent);
    }
}
