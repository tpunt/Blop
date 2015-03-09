<?php

namespace app\models\DataAccessLayer;

use app\models\DomainModel\WebPageContent;

/**
 * This class handles the contents of every web page.
 *
 * It hydrates the WebPageContent domain object from the DB to be sent to the corresponding
 * view.
 *
 * @package  Blop/app/models/DataAccessLayer
 * @author   Thomas Punt
 * @license  MIT
 */
class WebPageContentMapper
{
    /**
     * @var PDO|null            $pdo   The PDO object.
     * @var WebPageContent|null $page  The WebPageContent domain model object.
     */
    private $pdo = null,
            $page = null;

    /**
     * Sets the PDO object to an instance variable.
     *
     * @param PDO $pdo  The PDO object.
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Sets the page instance variable to a WebPageContent domain object.
     *
     * It takes the route name and passes it to the getWebPageContent method that populates the
     * WebPageContent domain object using data from the DB that corresponds to the route name.
     *
     * @param string $page   The name of the route
     */
    public function setPage($page)
    {
        $this->page = $this->getWebPageContent($page);
    }

    /**
     * Gets the WebPageContent domain object.
     *
     * @return WebPageContent   An object containing the page information
     */
    public function getWebPage()
    {
        return $this->page;
    }

    /**
     * Creates a new WebPageContent domain object containing information corresponding to the route.
     *
     * @return WebPageContent   An object containing the page information
     */
    public function getWebPageContent($page)
    {
        $pageTitleQuery = $this->pdo->prepare('SELECT page_title FROM WebPages WHERE web_page = ?');
        $pageTitleQuery->execute([$page]);

        $webPage = new WebPageContent($pageTitleQuery->fetch(\PDO::FETCH_ASSOC)['page_title']);

        $pageContentQuery = $this->pdo->prepare('SELECT content FROM WebPageContent WHERE web_page = ?');
        $pageContentQuery->execute([$page]);

        while($pageContent = $pageContentQuery->fetch(\PDO::FETCH_ASSOC)['content'])
            $webPage->addWebPageContent($pageContent);

        return $webPage;
    }
}