<?php

namespace app\models\DomainModel;

/**
 * This class encapsulates the domain logic for a piece of content on a single web page.
 *
 * @package  Blop/app/models/DomainModel
 * @author   Thomas Punt
 * @license  MIT
 */
class WebPageContent
{
    /**
     * @var int|0  $contentID  The ID of the piece of content
     * @var array| $content    A piece of content on a web page
     */
    private $contentID = 0,
            $content = '';

    /**
     * Sets the web page title via a private validation function.
     *
     * @param  int    $contentID         The ID of the content
     * @param  string $content           The content
     * @throws InvalidArgumentException  Thrown if either the content ID is not a valid integer
     *                                   value or if the content length is too short
     */
    public function __construct($contentID, $content)
    {
        $this->setContentID($contentID);
        $this->setContent($content);
    }

    /**
     * Sets the ID of the content.
     *
     * @param  int $contentID            The associated ID to the content
     * @throws InvalidArgumentException  Thrown if the content ID is not a valid integer value
     */
    private function setContentID($contentID)
    {
        if ((!is_int($contentID) && !ctype_digit($contentID)) || $contentID < 1)
            throw new InvalidArgumentException('Invalid content ID');

        $this->contentID = $contentID;
    }

    /**
     * Validates and sets the content piece.
     *
     * @param  string $content           The piece of content
     * @throws InvalidArgumentException  Thrown if the content is too short
     */
    private function setContent($content)
    {
        if (strlen($content) < 25)
            throw new \InvalidArgumentException('The page content isn\'t long enough');

        $this->content = $content;
    }

    /**
     * Gets the ID of the content.
     *
     * @return int  The content ID
     */
    public function getContentID()
    {
        return $this->contentID;
    }

    /**
     * Gets the piece of content.
     *
     * @return string  The content
     */
    public function getContent()
    {
        return $this->content;
    }
}
