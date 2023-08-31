<?php

declare(strict_types = 1);
namespace App\Backend\Service;

use App\Backend\Mapper\PostMapper;
use App\Common\Abstracts\AbstractService;

class PostService extends AbstractService
{
    /**
     * @var PostMapper
     */
    public $mapper;

    public function __construct(PostMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}