<?php

/*
A comment is going to be a standalone object, tied to a post by populating that posts
'comments' array attribute. Therefore, Comment could be merged into AbstractPost, and
AbstractPost could be turned into a non-abstract class.

Implications of this?

COMMENTS CAN HAVE OTHER PARTS TO THEM FOR BLOGS (e.g. Chosen user name, website address?, etc)
So maybe keeping a comments class separate is best...

> Comments will always have:
--> Post body

> Comments sometimes have:
--> Post IDs (generated within the database upon insertion)
--> Post creator IDs (people may comment who don't have an account)
--> Post dates (generated on post insertion by NOW() in SQL INSERT statement)
*/

namespace app\models\DomainModel;

/**
 * This class encapsulates the business logic for a comment. It is a subclass of
 * AbstractPost.
 *
 * @package  Blop/app/models/DomainModel
 * @author   Thomas Punt
 * @license  MIT
 */
class Comment extends AbstractPost
{
    /**
     * @var int|0  The ID of the post.
     */
    private $postID = 0;

    /**
     * Validates and sets the reply post properties.
     *
     * @param  int    $postCreatorID     The ID of the post creator.
     * @param  string $postBody          The body of the post.
     * @param  int    $postID            The ID of the post.
     * @throws InvalidArgumentException  Thrown if any fields contain invalid data.
     */
    public function __construct($postBody, $postID = null, \DateTime $postDate = null, $postCreatorID = null)
    {
        parent::__construct($postBody);

        if(isset($postID))
            $this->setPostID($postID);
    }

    /**
     * Validates and sets the post ID for the post post.
     *
     * @param int $postID              The ID of the post.
     * @throws InvalidArgumentException  Thrown if the post ID is invalid.
     */
    private function setPostID($postID) // do we need a post ID for every Post object?
    {
        if($postID < 1)
            throw new \InvalidArgumentException('The post ID is invalid.');

        $this->postID = $postID;
    }

    /**
     * Passes the post ID to the superclass (AbstractPost) to validate and set it to an instance variable.
     *
     * @param  int $postID               The ID of the post.
     * @throws InvalidArgumentException  Thrown from AbstractPost if the post ID is invalid.
     * @return ReplyPost	             The current instance.
     */
    public function setPostID($postID)
    {
        parent::setAbstractPostID($postID);

        return $this;
    }

    /**
     * Passes the post date to the superclass (AbstractPost) to set it to an instance variable.
     *
     * @param  int $postDate  The date the post was made.
     * @return ReplyPost	  The current instance
     */
    public function setPostDate($postDate)
    {
        parent::setAbstractPostDate($postDate);

        return $this;
    }

    /**
     * Gets the post ID that the reply post is attached to.
     *
     * @return int	The post ID
     */
    public function getPostID() // needed? Remove if setpostID (& $postID instance variable) is removed
    {
        return $this->postID;
    }
}