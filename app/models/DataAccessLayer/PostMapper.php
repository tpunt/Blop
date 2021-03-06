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
     * Gets the overview information of a group of posts corresponding to the range
     * of post ID's specified via pagination.
     *
     * @param  bool  $publishedOnly  Whether to retrieve posts that have been unpublished or not
     * @param  bool  $withExcerpt    Whether to retrieve and excerpt of the posts or not
     * @return array                 An array of Post objects containing individual post information
     */
    public function getPostsOverview($publishedOnly, $withExcerpt)
    {
        $posts = [];

        if (!$this->pagination)
            $this->newPagination(1);

        if (!$this->pagination->getValidity())
            return $posts;

        $from = $this->pagination->getFrom();
        $perPageNo = $this->pagination->getPerPageNo();
        $published = (int) $publishedOnly;

        $sql = "SELECT post_id, post_title, post_date, published, user_id".
                ($withExcerpt ? ', LEFT(post_content, 50) as excerpt' : '').
                " FROM Posts WHERE published >= {$published} LIMIT {$from}, {$perPageNo}";

        $postsQuery = $this->pdo->query($sql);

        while ($p = $postsQuery->fetch(\PDO::FETCH_ASSOC)) {
            $post = (
                new Post($p['post_id'])
            )->setPostTitle(
                $p['post_title']
            )->setPostCreatorID(
                $p['user_id']
            )->setPostDate(
                new \DateTime($p['post_date'])
            )->setPublishStatus(
                $p['published']
            );

            if (isset($p['excerpt']))
                $post->setPostBody($p['excerpt']);

            $posts[] = $post;
        }

        return $posts;
    }

    /**
     * Gets a post corresponding to the specified post ID.
     *
     * @param  int  $postID  The ID of the post to be returned
     * @param  bool $postID  Whether the post to get has been published or not
     * @return Post          A Post object containing the post information
     */
    public function getPostByID($postID, $publishedOnly)
    {
        $post = new Post($postID);
        $published = (int) $publishedOnly;

        $p = $this->pdo->query(
            "SELECT post_title, post_content, post_date, user_id
             FROM Posts
             WHERE post_id = {$post->getPostID()} AND published >= {$published}"
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
        )->setPublishStatus(
            $publishedOnly
        );

        // add comments here.

        return $post;
    }

    /**
     * Add a new blog post.
     *
     * @param array $postData  The POST data sent from the new thread form.
     */
    public function newPost(array $postData, $userID, $publish = false)
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
            )->setPublishStatus(
                $publish
            );
        } catch (\InvalidArgumentException $e) {
            $this->error = 'Title and/or content fields are empty.';
            return;
        }

    	$insertPostQuery = $this->pdo->prepare('INSERT INTO Posts VALUES (NULL, ?, ?, NOW(), 0, ?, ?)');
        $insertPostQuery->execute([
            $post->getPostTitle(),
            $post->getPostBody(),
            (int) $post->getPublishStatus(),
            $post->getPostCreatorID()
        ]);

        if ($publish) {
            header("Location: /post/{$this->pdo->lastInsertId()}");
            die;
        }
        
        header('Location: /admin/posts');
        die;
    }

    public function modifyPost(array $postData, $postID, $publish = false)
    {
        if (empty($postData) || !isset($postData['postTitle'], $postData['postBody']))
            throw new \InvalidArgumentException('HTTP POST data cannot be empty.');

        try {
            $post = (new Post($postID))->setPostTitle($postData['postTitle'])->setPostBody($postData['postBody']);
        } catch (\InvalidArgumentException $e) {
            $this->error = $e->getMessage();
            return;
        }

        $postUpdateQuery = $this->pdo->prepare(
            'UPDATE Posts SET post_title = ?, post_content = ?, published = ? WHERE post_id = ?'
        );
        $postUpdateQuery->execute([
            $post->getPostTitle(),
            $post->getPostBody(),
            (int) $publish, $post->getPostID()
        ]);

        if ($publish) {
            header("Location: /post/{$post->getPostID()}");
            die;
        }

        header('Location: /admin/posts');
        die;
    }

    public function deletePost($postID) // (array $postData, $postID)
    {
        // if (empty($postData) || !isset($postData['confirmDeletion']))
        //     throw new \InvalidArgumentException('HTTP POST data cannot be empty.');

        try {
            $post = new Post($postID);
        } catch (\InvalidArgumentException $e) {
            $this->error = $e->getMessage();
            return;
        }

        // if (!isset($postData['confirmation']) || $postData['confirmation'] !== 'on') {
        //     header("Location: /admin/post?postID={$post->getPostID()}");
        //     die;
        // }

        // change to update on post_deleted = true ?
        $this->pdo->exec("DELETE FROM Posts WHERE post_id = {$post->getPostID()}");

        header('Location: /admin/posts');
        die;
    }
}
