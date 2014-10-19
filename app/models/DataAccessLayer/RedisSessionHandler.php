<?php

namespace app\models\DataAccessLayer;

/**
 * Handles thread-creation (i.e. new blog post) actions.
 *
 * @package  Blop/app/models/DataAccessLayer
 * @author   Thomas Punt
 * @license  MIT
 */
class RedisSessionHandler implements \SessionHandlerInterface
{
    /**
     * @var int|0      $ttl         The time-to-live of the session data.
     * @var Redis|null $redis       The Redis object.
     * @var string|    $sessPrefix  The session prefix to uniquely identify keys containing session data.
     */
    private $ttl = 0,
            $redis = null,
            $sessPrefix = '';

    /**
     * Sets the Redis object and the session key prefix.
     *
     * @param Redis $redis        The redis object.
     * @param string $sessPrefix  The session prefix to identify session-based keys.
     * @param int $ttl            The time-to-live for the session data.
     */
    public function __construct(\Redis $redis, $sessPrefix = 'PHPSESSID:', $ttl = 604800)
    {
        $this->redis = $redis;
        $this->sessPrefix = $sessPrefix;
        $this->ttl = $ttl;
    }

    /**
     * This method is not needed since the Redis object is configured outside of this class and
     * passed in using dependency injection (via constructor injection).
     *
     * @param string $path        The path to where the session data should be saved.
     * @param string $sessPrefix  The prefix to identify the session data.
     */
    public function open($path, $sessPrefix) {}

    /**
     * Close off the redis connection.
     */
    public function close()
    {
        $this->redis->close();
    }

    /**
     * Get's the corresponding value to the key (session ID) specified.
     *
     * @param  string $sessID  The session ID.
     * @return string          The session data.
     */
    public function read($sessID)
    {
        $sessionID = $this->sessPrefix . $sessID;
        $sessionData = $this->redis->get($sessionID);

        $this->redis->expire($sessionID, $this->ttl);

        return $sessionData;
    }

    /**
     * Writes the session data to the specified session ID, and sets the ttl.
     *
     * @param  string $sessID       The session ID.
     * @param  string $sessionData  The session data.
     */
    public function write($sessID, $sessionData)
    {
        $this->redis->setex($this->sessPrefix . $sessID, $this->ttl, $sessionData);
    }

    /**
     * Remove the specified session data according to the session ID provided.
     *
     * @param string $sessID  The session ID.
     */
    public function destroy($sessID)
    {
        $this->redis->del($this->sessPrefix . $sessID);
    }

    /**
     * This method is not needed since Redis has the ability to give a ttl to each value in its DB.
     *
     * @param int $maxLifetime  The ttl of the session data.
     */
    public function gc($maxLifetime) {}
}