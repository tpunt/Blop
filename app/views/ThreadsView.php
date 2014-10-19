<?php

namespace app\views;
use app\controllers\ThreadsController as ThreadsController;
use app\models\DataAccessLayer\ThreadPostMapper as ThreadPostMapper;

class ThreadsView
{
    private $threadPostMapper = null;
    private $tplEngine = null;

    public function __construct(\Twig_Environment $tplEngine, ThreadPostMapper $threadPostMapper)
    {
        $this->tplEngine = $tplEngine;
        $this->threadPostMapper = $threadPostMapper;
    }

    public function render()
    {
        $threads = $this->threadPostMapper->getThreads();
        $view = '';

        foreach($threads as $thread)
            $view .= "Thread ID: {$thread->getAbstractPostID()} - Thread Author: {$thread->getAbstractPostCreatorID()} - Thread Content: {$thread->getAbstractPostBody()}<br />";

        return $view;
    }
}