<?php

namespace app\models\DomainModel;

// make post length limitations configurable?

/**
 * This class encapsulates the business logic that is common to threads (blog posts) and posts
 * (blog comments). It is therefore the superclass for Post and Comment.
 *
 * @package  Blop/app/models/DomainModel
 * @author   Thomas Punt
 * @license  MIT
 */
abstract class AbstractPost
{
    /**
     * @var int|0         $postID         The ID of the post.
     * @var string|       $postBody       The content of the post.
     * @var DateTime|null $postDate       The date of the post.
     * @var int|0         $postCreatorID  The ID of the post creator.
     */
    protected $postID = 0,
              $postBody = '',
              $postDate = null,
              $postCreatorID = 0;

    /**
     * Validates and Sets the post ID.
     *
     * @param  int $postID               The ID of the post
     * @throws InvalidArgumentException  Thrown the post ID is invalid.
     */
    public function __construct($postID)
    {
        $this->setPostID($postID);
    }

    /**
     * Validates and sets the user ID for the post.
     *
     * @param  int $uid                  The ID of the user.
     * @throws InvalidArgumentException  Thrown if the user ID is invalid.
     */
    protected function setPostCreatorID($uid)
    {
        if ((!is_int($uid) && !ctype_digit($uid)) || $uid < 1)
            throw new \InvalidArgumentException('The user ID is invalid.');

        $this->postCreatorID = $uid;
    }

    /**
     * Validates and sets the body for the post.
     *
     * @param  string $postBody          The body of the post.
     * @throws InvalidArgumentException  Thrown if the post body has an invalid length.
     */
    protected function setPostBody($postBody)
    {
        $postLength = strlen($postBody);

        if($postLength < 10 || $postLength > 65535)
            throw new \InvalidArgumentException('The post body length is invalid.');

        $this->postBody = $postBody;

    }

    /**
     * Validates and sets the post ID for the post.
     *
     * @param  int $postID               The ID of the post.
     * @throws InvalidArgumentException  Thrown if the post ID is invalid.
     */
    protected function setPostID($postID)
    {
        if ((!is_int($postID) && !ctype_digit($postID)) || $postID < 1)
            throw new \InvalidArgumentException('The post ID must be a natural number (except 0).');

        $this->postID = $postID;
    }

    /**
     * Sets the date for the post.
     *
     * @param DateTime $postDate  The data of the post was made.
     */
    protected function setPostDate(\DateTime $postDate)
    {
        $this->postDate = $postDate;
    }

    /**
     * Returns the post date formatted as a string.
     *
     * This getter method is required to represent the date of a post or comment in an format that
     * can be output in a template (since the DateTime object does not have a default __toString()
     * method).
     *
     * @return string  The abstract post date as a string that has been formatted.
     */
    public function getPostDate()
    {
        return $this->postDate->format('d-m-Y');
    }
}