<?php

namespace app\views;

use app\controllers\NewThreadPostController;
use app\models\DataAccessLayer\ThreadPostMapper;

class NewThreadPostView
{
    private $threadPostMapper = null;

    public function __construct(ThreadPostMapper $threadPostMapper)
    {
        $this->threadPostMapper = $threadPostMapper;
    }

    public function render()
    {
        $view = '';

        return $view;
    }
}