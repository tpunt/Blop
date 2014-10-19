<?php

namespace app\models\DataAccessLayer;

use app\models\DomainModel\ThreadPost as ThreadPost;

/**
 * This class handles the new and already created threads (blog posts).
 *
 * It both hydrates the ThreadPost domain object from the DB to be sent to the corresponding
 * view, and persists the ThreadPost object to the database.
 *
 * @package  Blop/app/models/DataAccessLayer
 * @author   Thomas Punt
 * @license  MIT
 */
class ThreadPostMapper
{
    /**
     * @var PDO|null $pdo  The PDO object.
     */
    private $pdo = null;

    /**
     * Assign the PDO object to an object instance.
     *
     * @param PDO $pdo  The PDO object.
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Gets a thread corresponding to the specified thread ID.
     *
     * @param int $threadID  The ID of the thread to be returned
     * @return ThreadPost    A ThreadPost object containing the thread information
     */
    public function getThread($threadID)
    {
        // validate PostID is int

        $threadQuery = $pdo->query("SELECT thread_title, thread_content, user_id FROM posts WHERE post_id = {$threadID}");
        $threadData = $postQuery->fetch(\PDO::FETCH_ASSOC);

        // what to do if no post is found? Throw exception? Use Null Object pattern?

        $thread = new ThreadPost($threadData['user_id'], $threadData['thread_title'], $threadData['thread_content']);
        $thread->setThreadID($threadID);

        return $thread;
    }

    /**
     * Gets a group of threads corresponding to the range of thread ID's specified.
     *
     * @param int $from  The thread ID to begin fetching threads from
     * @param int $to    The ending thread ID to fetch the threads to
     * @return array     An array of ThreadPost objects containing thread information
     */
    public function getThreads($from = 0, $to = 10) // pagination: 10 posts/page | only specify a $from and make posts/page configurable?
    {
        // validate $from & $to

        $threads = [];

        $threadsQuery = $this->pdo->query("SELECT post_id, content, user_id FROM posts WHERE post_id BETWEEN {$from} AND {$to}");

        // what to do if no threads are found?

        while($threadData = $threadsQuery->fetch(\PDO::FETCH_ASSOC)) {
        	$thread = new ThreadPost($threadData['user_id'], $threadData['content'], 'Default Title');  // hardcorded thread title for now. Update DB...
        	$thread->setThreadID($threadData['post_id']);

            array_push($threads, $thread);
        }

        return $threads;
    }

    /**
     * Add a new thread (blog post).
     *
     * @param array $postData  The POST data sent from the new thread form.
     */
    public function addNewThread(array $postData)
    {
    	//$insertThreadQuery = $this->pdo->prepare("INSERT INTO ") // finish query. Update DB first...
    }
}