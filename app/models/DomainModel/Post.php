<?php

namespace app\models\DomainModel;

// make post prefixes and post title lengths configurable?

/**
 * This class encapsulates the business logic for a post. It is a subclass of
 * AbstractPost.
 *
 * @package  Blop/app/models/DomainModel
 * @author   Thomas Punt
 * @license  MIT
 */
class Post extends AbstractPost
{
    /**
     * @var string| $postTitle    The title of the post.
     * @var int|0   $postViews    The number of views the post has received.
     * @var array|  $comments     All Comment objects.
     */
    private $postTitle = '',
            $postViews = 0,
            $comments = [];

    /**
     * Validates and sets the post ID.
     *
     * @param  int $postID               The ID of the post
     * @throws InvalidArgumentException  Thrown if the post ID is invalid
     */
    public function __construct($postID = null)
    {
        if ($postID !== null)
            parent::__construct($postID);
    }

    /**
     * Validates and sets the post creator ID.
     *
     * @param  string $postCreatorID     The creator ID of the post
     * @throws InvalidArgumentException  Thrown if the post creator ID is invalid
     * @return Post                      The current instance
     */
    public function setPostCreatorID($postCreatorID)
    {
        parent::setPostCreatorID($postCreatorID);

        return $this;
    }

    /**
     * Validates and sets the post title.
     *
     * @param  string $postTitle         The title of the post
     * @throws InvalidArgumentException  Thrown if the post title has an invalid length
     * @return Post                      The current instance
     */
    public function setPostTitle($postTitle)
    {
        $postTitleLength = strlen($postTitle);

        if($postTitleLength < 5 || $postTitleLength > 100)
            throw new \InvalidArgumentException('Invalid post title length.');

        $this->postTitle = $postTitle;

        return $this;
    }

    /**
     * Validates and sets the post body.
     *
     * @param  string $postBody          The body of the post
     * @throws InvalidArgumentException  Thrown if the post title has an invalid length
     * @return Post                      The current instance
     */
    public function setPostBody($postBody)
    {
        parent::setPostBody($postBody);

        return $this;
    }

    /**
     * Sets the date the post was made.
     *
     * @param  string $postBody          The body of the post
     * @throws InvalidArgumentException  Thrown if the post title has an invalid length
     * @return Post                      The current instance
     */
    public function setPostDate(\DateTime $postDate)
    {
        parent::setPostDate($postDate);

        return $this;
    }

    /**
     * Sets the post view count to an instance variable.
     *
     * This value should only ever come from the database, and so not validations are required.
     *
     * @param  int $views  The number of views the post has received.
     * @return Post        The current instance
     */
    public function setPostViews($views)
    {
        $this->postViews = $views;

        return $this;
    }

    /**
     * Adds a Comment object to the comments instance variable.
     *
     * @param Comment $comment  A Comment object containing all information about a comment
     */
    public function addReplyPost(Comment $comment)
    {
        $this->comments[] = $comment;
    }

    use MagicGetter;
}
