<?php

namespace App\Http\Controllers;

use App\CQ\Queries\Query\BlogPost\GetBlogPostCollectionQuery;
use App\CQ\Queries\Query\BlogPost\GetBlogPostQuery;
use App\Http\Responses\JSON\DefaultErrorResponse;
use App\Http\Responses\JSON\GetResponse;
use App\Interfaces\Responses\JsonResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class BlogPostController extends Controller
{
    public function getBlogPost( int $id ): JsonResponseInterface
    {
        try {
            return GetResponse::create(
                $this->dispatch( new GetBlogPostQuery($id) )->toArray()
            );
        } catch ( \Exception $e ) {
            return DefaultErrorResponse::create(
                null,
                $e->getMessage(),
                [],
                $e->getCode()
            );
        }
    }

    public function getBlogPostCollection(): JsonResponseInterface
    {
        try {
            return GetResponse::create(
                $this->dispatch( new GetBlogPostCollectionQuery() )->toArray()
            );
        } catch ( \Exception $e ) {
            return DefaultErrorResponse::create(
                null,
                $e->getMessage(),
                [],
                0 !== $e->getCode() ? $e->getCode() : Response::HTTP_NOT_FOUND
            );
        }

    }
}
