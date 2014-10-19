<?php

namespace app\models\DomainModel;

/**
 * This class encapsulates the business logic for a reply post. It is a subclass of
 * AbstractPost.
 *
 * @package  Blop/app/models/DomainModel
 * @author   Thomas Punt
 * @license  MIT
 */
class ReplyPost extends AbstractPost
{
    /**
     * @var int|0  The ID of the thread.
     */
    private $threadID = 0;

    /**
     * Validates and sets the reply post properties.
     *
     * @param  int    $postCreatorID     The ID of the post creator.
     * @param  string $postBody          The body of the post.
     * @param  int    $threadID          The ID of the thread.
     * @throws InvalidArgumentException  Thrown if any fields contain invalid data.
     */
    public function __construct($postCreatorID, $postBody, $threadID)
    {
        parent::__construct($postCreatorID, $postBody);

        $this->setThreadID($threadID);
    }

    /**
     * Validates and sets the thread ID for the thread post.
     *
     * @param int $threadID              The ID of the thread.
     * @throws InvalidArgumentException  Thrown if the thread ID is invalid.
     */
    private function setThreadID($threadID) // do we need a thread ID for every Post object?
    {
        if($threadID < 1)
            throw new \InvalidArgumentException('The thread ID is invalid.');

        $this->threadID = $threadID;
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
     * Gets the thread ID that the reply post is attached to.
     *
     * @return int	The thread ID
     */
    public function getThreadID() // needed? Remove if setThreadID (& $threadID instance variable) is removed
    {
        return $this->threadID;
    }
}