<?php

namespace app\models\DomainModel;

// make thread prefixes and thread title lengths configurable?

/**
 * This class encapsulates the business logic for a thread post. It is a subclass of
 * AbstractPost.
 *
 * @package  Blop/app/models/DomainModel
 * @author   Thomas Punt
 * @license  MIT
 */
class ThreadPost extends AbstractPost
{
    /**
     * @var string| $threadTitle    The title of the thread.
     * @var int|0   $threadViews    The number of views the thread has received.
     * @var array|  $threadReplies  All ReplyPost objects.
     */
    private $threadTitle = '',
            $threadViews = 0,
            $threadReplies = array();

    /**
     * Validates and sets the thread creator ID, the thread title, and the thread body if it's
     * present.
     *
     * The reason why the thread body is optionally populated is because in previews of threads,
     * it's typical to only see each thread's title, post date, and creator ID.
     *
     * @param  int    $threadCreatorID   The ID of the thread creator.
     * @param  string $threadTitle       The title of the thread.
     * @param  string $threadBody        The body of the thread.
     * @throws InvalidArgumentException  Thrown if any fields contain invalid data.
     */
    public function __construct($threadCreatorID, $threadTitle, $threadBody = '')
    {
        parent::__construct($threadCreatorID, $threadBody);

        $this->setThreadTitle($threadTitle);
    }

    /**
     * Validates and sets the thread title.
     *
     * @param  string $threadTitle       The title of the thread.
     * @throws InvalidArgumentException  Thrown if the thread title has an invalid length.
     */
    private function setThreadTitle($threadTitle)
    {
        $threadTitleLength = strlen($threadTitle);

        if($threadTitleLength < 5 || $threadTitleLength > 100)
            throw new \InvalidArgumentException('Invalid thread title length.');

        $this->threadTitle = $threadTitle;
    }

    /**
     * Passes the thread ID to the superclass (AbstractPost) to validate and set it to an instance variable.
     *
     * @param  int $threadID             The ID of the thread.
     * @throws InvalidArgumentException  Thrown from AbstractPost if the thread ID is invalid.
     * @return ThreadPost                The current instance.
     */
    public function setThreadID($threadID)
    {
        parent::setAbstractPostID($threadID);

        return $this;
    }

    /**
     * Passes the thread post date to the superclass (AbstractPost) to set it to an instance variable.
     *
     * The reason why this is an a thread's date is optionally set via a mutator method and not a
     * mandatory parameter to be set in the class's constructor is because when posting a new thread,
     * it will not have a post date since the post date is generated using SQL. If the post date was
     * generated via PHP, then this would be mandatory.
     *
     * @param int $abstractPostDate  The data of the abstract post was made.
     * @return ThreadPost    The current instance
     */
    public function setThreadDate($threadDate)
    {
        parent::setAbstractPostDate($threadDate);

        return $this;
    }

    /**
     * Validates and sets the thread view count to an instance variable.
     *
     * @param  int $views                The number of views the thread has received.
     * @throws InvalidArgumentException  Thrown from AbstractPost if the view count is invalid.
     * @return ThreadPost                The current instance.
     */
    public function setThreadViews($views)
    {
        if($views < 0) // redundant? View count will only come from the DB, which will always be an unsigned int
            throw new \InvalidArgumentException('The thread views value is invalid.');

        $this->threadViews = $views;

        return $this;
    }

    /**
     * Adds a ReplyPost object to the threadReplies instance variable.
     *
     * @param ReplyPost $post  A ReplyPost object containing all information about a post.
     */
    public function addReplyPost(ReplyPost $post)
    {
        array_push($this->threadReplies, $post);
    }

    use MagicGetter;
}