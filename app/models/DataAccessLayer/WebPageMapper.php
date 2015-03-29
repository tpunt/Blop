<?php

namespace app\models\DataAccessLayer;

use app\models\DomainModel\WebPage;
use app\models\DomainModel\WebPageContent;

/**
 * This class handles the web page.
 *
 * It hydrates the WebPage domain object from the DB to be sent to the corresponding
 * view.
 *
 * @package  Blop/app/models/DataAccessLayer
 * @author   Thomas Punt
 * @license  MIT
 */
class WebPageMapper
{
    /**
     * @var PDO|null $pdo  The PDO object
     */
    private $pdo = null;

    /**
     * Sets the PDO object to an instance variable.
     *
     * @param PDO $pdo  The PDO object
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Sets the page instance variable to a WebPage domain object.
     *
     * It takes the route name and passes it to the getWebPage method that populates the
     * WebPage domain object using data from the DB that corresponds to the route name.
     *
     * @param WebPage $page  The name of the route
     */
    // public function setPage($page)
    // {
        // $this->page = $page;
    // }

    /**
     * Gets the WebPage domain object.
     *
     * @param  string $route  The name of the route
     * @return WebPage        An object containing the page information
     */
    public function getPage($route)
    {
        if (empty($route)) {
            header('Location: /');
            die;
        }

        $pageTitleQuery = $this->pdo->prepare('SELECT page_title, page_description, page_keywords FROM WebPages WHERE web_page = ?');
        $pageTitleQuery->execute([$route]);

        if (!$page = $pageTitleQuery->fetch(\PDO::FETCH_ASSOC)) {
            header('Location: /');
            die;
        }

        $page = (
            new WebPage($page['page_title'])
        )->setPageName($route)->setPageDescription($page['page_description'])->setPageKeywords($page['page_keywords']);

        $pageContentQuery = $this->pdo->prepare(
            'SELECT web_content_id, content FROM WebPageContent WHERE web_page = ? ORDER BY content_order'
        );
        $pageContentQuery->execute([$route]);

        while ($content = $pageContentQuery->fetch(\PDO::FETCH_ASSOC))
            $page->addPageContent(new WebPageContent($content['web_content_id'], $content['content']));

        return $page;
    }

    private function webPageExists($page)
    {
        //
    }

    public function getAllPagesOverview()
    {
        $pages = [];

        $pageQuery = $this->pdo->query('SELECT web_page, page_title FROM WebPages');

        while ($page = $pageQuery->fetch(\PDO::FETCH_ASSOC))
            $pages[] = (new WebPage($page['page_title']))->setPageName($page['web_page']);

        return $pages;
    }

    public function modifyWebPage($page, $postData)
    {
        if (empty($_POST['pageDescription']) || empty($_POST['pageKeywords']) || empty($_POST['pageTitle'])) {
            header('Location: /admin/pages');
            die;
        }

        $updateTitle = $this->pdo->prepare('UPDATE WebPages SET page_description = ?, page_keywords = ?, page_title = ? WHERE web_page = ?');

        if (!$updateTitle->execute([$postData['pageDescription'], $postData['pageKeywords'], $postData['pageTitle'], $page])) {
            header('Location: /admin/pages');
            die;
        }

        $i = 0;

        while (isset($postData['content'][$i]) && isset($postData['content'][$i + 1])) {
            $updateContent = $this->pdo->prepare('UPDATE WebPageContent SET content = :content WHERE web_content_id = :contentID');
            $updateContent->execute(
                [':contentID' => $postData['content'][$i++],
                ':content' => $postData['content'][$i++]]
            );
        }

        header('Location: /admin/pages');
    }

    public function updatePage(WebPage $webPage)
    {
        //
    }
}
