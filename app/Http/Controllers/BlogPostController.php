<?php

namespace App\Http\Controllers;

use App\CQ\Queries\Query\BlogPost\GetBlogPostCollectionQuery;
use App\CQ\Queries\Query\BlogPost\GetBlogPostQuery;
use App\Enums\CollectionRulesEnum;
use App\Http\Requests\BlogPost\BlogPostCollectionRequest;
use App\Http\Requests\GenericCollectionRequest;
use App\Http\Responses\JSON\DefaultErrorResponse;
use App\Http\Responses\JSON\GetResponse;
use App\Interfaces\CQ\Queries\Query\BlogPost\BlogPostCollectionInterface;
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

    public function getBlogPostCollection( BlogPostCollectionRequest $request ): JsonResponseInterface
    {
        try {
            return GetResponse::create(
                $this->dispatch(
                    new GetBlogPostCollectionQuery(
                        $request->validated(CollectionRulesEnum::LIMIT->value),
                        $request->validated(CollectionRulesEnum::ORDER_BY->value),
                        $request->validated(CollectionRulesEnum::SORT_ORDER->value),
                        $request->validated(BlogPostCollectionInterface::PARAM_INCLUDE_CATEGORY, false)
                    )
                )->toArray()
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
