<?php

namespace app\models\DomainModel;

// make post length limitations configurable?

/**
 * This class encapsulates the business logic that is common to threads (blog posts) and posts
 * (blog comments). It is therefore the superclass for ThreadPost and ReplyPost.
 *
 * @package  Blop/app/models/DomainModel
 * @author   Thomas Punt
 * @license  MIT
 */
abstract class AbstractPost
{
    /**
     * @var int|0   $abstractPostID         The abstract post ID.
     * @var string| $abstractPostBody       The abstract post body.
     * @var int|0   $abstractPostDate       The abstract post date.
     * @var int|0   $abstractPostCreatorID  The ID of the abstract post creator.
     */
    private $abstractPostID = 0,
            $abstractPostBody = '',
            $abstractPostDate = 0,
            $abstractPostCreatorID = 0;

    /**
     * Sets the creator's ID and optionally the abstract post body.
     *
     * The reason why the thread body is optionally populated is because in previews of threads,
     * it's typical to only see each thread's title, post date, and creator ID.
     *
     * @param  int    $abstractPostCreatorID  The user ID.
     * @param  string $abstractPostBody       The body of the abstract post.
     * @throws InvalidArgumentException       Thrown if any fields contain invalid data.
     */
    public function __construct($abstractPostCreatorID, $abstractPostBody = '')
    {
        $this->setAbstractPostCreatorID($abstractPostCreatorID);

        if($abstractPostBody)
            $this->setAbstractPostBody($abstractPostBody);
    }

    /**
     * Validates and sets the user ID for the abstract post.
     *
     * @param  int $uid                  The ID of the user.
     * @throws InvalidArgumentException  Thrown if the user ID is invalid.
     */
    protected function setAbstractPostCreatorID($uid)
    {
        if($uid < 1)
            throw new \InvalidArgumentException('The user ID is invalid.');

        $this->abstractPostCreatorID = $uid;
    }

    /**
     * Validates and sets the body for the abstract post.
     *
     * @param  string $abstractPostBody  The body of the abstract post.
     * @throws InvalidArgumentException  Thrown if the abstract post body has an invalid length.
     */
    protected function setAbstractPostBody($abstractPostBody)
    {
        $abstractPostLength = strlen($abstractPostBody);

        if($abstractPostLength < 10 || $abstractPostLength > 65535)
            throw new \InvalidArgumentException('The post body length is invalid.');

        $this->abstractPostBody = $abstractPostBody;

    }

    /**
     * Validates and sets the post ID for the abstract post.
     *
     * @param  int $abstractPostID       The ID of the abstract post.
     * @throws InvalidArgumentException  Thrown if the post ID is invalid.
     */
    protected function setAbstractPostID($abstractPostID)
    {
        if($abstractPostID < 1) // there should be no need for this. Post ID will only ever come from the DB?
            throw new \InvalidArgumentException('The post ID must be a natural number (except 0).');

        $this->abstractPostID = $abstractPostID;
    }

    /**
     * Sets the date for the abstract post.
     *
     * @param int $abstractPostDate  The data of the abstract post was made.
     */
    protected function setAbstractPostDate($abstractPostDate)
    {
        $this->abstractPostDate = $abstractPostDate;
    }

    use MagicGetter;
}