<?php

namespace app\models\DataAccessLayer;

use app\models\DomainModel\Post;
use app\models\DomainModel\Pagination;

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
     * @var PDO|null        $pdo         The PDO object
     * @var Pagination|null $pagination  The Pagination domain model object
     * @var string|         $error       The error string if something goes wrong
     */
    private $pdo = null,
            $pagination = null,
            $error = '';

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
            $posts[] = (
                new Post($p['post_id'])
            )->setPostTitle(
                $p['post_title']
            )->setPostBody(
                $p['excerpt']
            )->setPostCreatorID(
                $p['user_id']
            )->setPostDate(
                new \DateTime($p['post_date'])
            );

        return $posts;
    }

    /**
     * Gets the overview information of a group of posts corresponding to the range
     * of post ID's specified via pagination.
     *
     * @return array  An array of Post objects containing individual post information.
     */
    public function getPostsOverview()
    {
        $posts = [];

        if (!$this->pagination)
            $this->newPagination(1);

        if (!$this->pagination->getValidity())
            return $posts;

        $from = $this->pagination->getFrom();
        $perPageNo = $this->pagination->getPerPageNo();

        $postsQuery = $this->pdo->query("SELECT post_id, post_title, post_date, user_id
                                         FROM Posts LIMIT {$from}, {$perPageNo}");

        while ($p = $postsQuery->fetch(\PDO::FETCH_ASSOC))
            $posts[] = (
                new Post($p['post_id'])
            )->setPostTitle(
                $p['post_title']
            )->setPostCreatorID(
                $p['user_id']
            )->setPostDate(
                new \DateTime($p['post_date'])
            );

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
        $post = new Post($postID);

        $p = $this->pdo->query(
            "SELECT post_title, post_content, post_date, user_id FROM Posts WHERE post_id = {$post->getPostID()}"
        )->fetch(\PDO::FETCH_ASSOC);

        if(!$p)
            return null;

        // grab comments here.

        $post->setPostTitle(
            $p['post_title']
        )->setPostBody(
            $p['post_content']
        )->setPostCreatorID(
            $p['user_id']
        )->setPostDate(
            new \DateTime($p['post_date'])
        );

        // add comments here.

        return $post;
    }

    /**
     * Add a new blog post.
     *
     * @param array $postData  The POST data sent from the new thread form.
     */
    public function newPost(array $postData, $userID)
    {
        if (empty($postData) || !isset($postData['postTitle'], $postData['postBody']))
            throw new \InvalidArgumentException('HTTP POST data cannot be empty.');

        try {
            $post = (
                new Post
            )->setPostTitle(
                $postData['postTitle']
            )->setPostBody(
                $postData['postBody']
            )->setPostCreatorID(
                $userID
            );
        } catch (\InvalidArgumentException $e) {
            $this->error = 'Title and/or content fields are empty.';
            return;
        }

    	$insertPostQuery = $this->pdo->prepare('INSERT INTO Posts VALUES (NULL, ?, ?, NOW(), 0, ?)');
        $insertPostQuery->execute([$post->getPostTitle(), $post->getPostBody(), $post->getPostCreatorID()]);

        return $this->pdo->lastInsertId();
    }

    public function modifyPost(array $postData, $postID)
    {
        if (empty($postData) || !isset($postData['postTitle'], $postData['postBody']))
            throw new \InvalidArgumentException('HTTP POST data cannot be empty.');

        try {
            $post = (new Post($postID))->setPostTitle($postData['postTitle'])->setPostBody($postData['postBody']);
        } catch (\InvalidArgumentException $e) {
            $this->error = $e->getMessage();
            return;
        }

        $postUpdateQuery = $this->pdo->prepare('UPDATE Posts SET post_title = ?, post_content = ? WHERE post_id = ?');
        $postUpdateQuery->execute([$post->getPostTitle(), $post->getPostBody(), $post->getPostID()]);

        header("Location: /post/{$post->getPostID()}");
        die;
    }

    public function deletePost(array $postData, $postID)
    {
        if (empty($postData) || !isset($postData['confirmDeletion']))
            throw new \InvalidArgumentException('HTTP POST data cannot be empty.');

        try {
            $post = new Post($postID);
        } catch (\InvalidArgumentException $e) {
            $this->error = $e->getMessage();
            return;
        }

        if (!isset($postData['confirmation']) || $postData['confirmation'] !== 'on') {
            header("Location: /admin/post?postID={$post->getPostID()}");
            die;
        }

        // change to update on post_deleted = true ?
        $this->pdo->exec("DELETE FROM Posts WHERE post_id = {$post->getPostID()}");

        header('Location: /admin/posts');
        die;
    }
}
