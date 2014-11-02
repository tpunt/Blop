<?php

namespace app\models\DataAccessLayer;

use app\models\DomainModel\Post as Post;
use app\models\DomainModel\Pagination as Pagination;

/**
 * This class handles the new and already created blog posts.
 *
 * It both hydrates the Post domain object from the DB to be sent to the corresponding
 * view, and persists the ThreadPost object to the database.
 *
 * @package  Blop/app/models/DataAccessLayer
 * @author   Thomas Punt
 * @license  MIT
 */
class PostMapper
{
    /**
     * @var PDO|null        $pdo         The PDO object.
     * @var Pagination|null $pagination  The Pagination domain model object.
     */
    private $pdo = null,
            $pagination = null;

    /**
     * Assign the PDO object to an object instance.
     *
     * @param PDO $pdo  The PDO object.
     */
    public function __construct(\PDO $pdo) // include a CommentMapper here?
    {
        $this->pdo = $pdo;
    }

    /**
     * Creates and sets a new Pagination object to the pagination instance variable.
     *
     * @param int $pageNo  The page number for pagination.
     */
    public function newPagination($pageNo)
    {
        $elementCount = $this->pdo->query('SELECT COUNT(*) FROM Posts')->fetch(\PDO::FETCH_NUM)[0];

        $this->pagination = new Pagination('posts', $elementCount, $pageNo);
    }

    /**
     * Gets a group of posts corresponding to the range of post ID's specified via pagination.
     *
     * @return array  An array of Post objects containing individual post information.
     */
    public function getPosts()
    {
        $posts = [];

        if(!$this->pagination)
            $this->newPagination(1);

        if(!$this->pagination->getValidity())
            return $posts;

        $from = $this->pagination->getFrom();
        $perPageNo = $this->pagination->getPerPageNo();

        $postsQuery = $this->pdo->query("SELECT post_id, post_title, LEFT(post_content, 50) as excerpt, post_date, user_id
                                         FROM Posts LIMIT {$from}, {$perPageNo}");

        while($p = $postsQuery->fetch(\PDO::FETCH_ASSOC))
            array_push($posts,
                       new Post($p['post_title'], $p['excerpt'], $p['user_id'], new \DateTime($p['post_date']), $p['post_id']));

        return $posts;
    }

    /**
     * Gets a post corresponding to the specified post ID.
     *
     * @param  int  $postID  The ID of the post to be returned.
     * @return Post          A Post object containing the post information.
     */
    public function getPostByID($postID)
    {
        $postID = (int) $postID;

        $p = $this->pdo->query("SELECT post_title, post_content, post_date, user_id FROM Posts WHERE post_id = {$postID}")->fetch(\PDO::FETCH_ASSOC);

        if(!$p)
            return null;

        // grab comments here.

        $post = new Post($p['post_title'], $p['post_content'], $p['user_id'], new \DateTime($p['post_date']), $postID);

        // add comments here.

        return $post;
    }

    /**
     * Add a new blog post.
     *
     * @param array $postData  The POST data sent from the new thread form.
     */
    public function addNewThread(array $postData)
    {
    	//$insertThreadQuery = $this->pdo->prepare("INSERT INTO ") // finish query. Update DB first...
    }
}