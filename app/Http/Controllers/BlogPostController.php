<?php

namespace App\Http\Controllers;

use App\CQ\Commands\Command\BlogPost\DeleteBlogPostCommand;
use App\CQ\Commands\Command\BlogPost\UpsertBlogPostCommand;
use App\CQ\Queries\Query\BlogPost\GetBlogPostCollectionQuery;
use App\CQ\Queries\Query\BlogPost\GetBlogPostQuery;
use App\Enums\CollectionRulesEnum;
use App\Http\Requests\BlogPost\BlogPostCollectionRequest;
use App\Http\Requests\BlogPost\DeleteBlogPostRequest;
use App\Http\Requests\BlogPost\UpsertBlogPostRequest;
use App\Http\Responses\JSON\DefaultErrorResponse;
use App\Http\Responses\JSON\DeleteResponse;
use App\Http\Responses\JSON\GetResponse;
use App\Http\Responses\JSON\PostResponse;
use App\Interfaces\CQ\Queries\Query\BlogPost\BlogPostCollectionInterface;
use App\Interfaces\Responses\JsonResponseInterface;
use App\Models\BlogPost;
use Exception;

class BlogPostController extends Controller
{
    public function getBlogPost( int $id ): JsonResponseInterface
    {
        try {
            return GetResponse::create(
                $this->dispatch( new GetBlogPostQuery($id) )->toArray()
            );
        } catch ( Exception $e ) {
            return DefaultErrorResponse::createFromException($e);
        }
    }

    public function getBlogPostCollection( BlogPostCollectionRequest $request ): JsonResponseInterface
    {
        try {
            return GetResponse::create(
                $this->dispatch(
                    new GetBlogPostCollectionQuery(
                        $request->validated( CollectionRulesEnum::LIMIT->value ),
                        $request->validated( CollectionRulesEnum::ORDER_BY->value ),
                        $request->validated( CollectionRulesEnum::SORT_ORDER->value ),
                        $request->validated( BlogPostCollectionInterface::PARAM_INCLUDE_CATEGORY, false )
                    )
                )->toArray()
            );
        } catch ( Exception $e ) {
            return DefaultErrorResponse::createFromException( $e );
        }
    }

    public function upsertBlogPost(UpsertBlogPostRequest $request): JsonResponseInterface
    {
        try {
            $blogPostId = $this->dispatch(
                new UpsertBlogPostCommand(
                    ...array_values( $request->validated() )
                )
            );

            return PostResponse::create( [BlogPost::COLUMN_ID => $blogPostId] );

        } catch ( Exception $e ) {
            return DefaultErrorResponse::createFromException( $e );
        }
    }

    public function deleteBlogPost( DeleteBlogPostRequest $request ): JsonResponseInterface
    {
        try {
            $this->dispatch(
                new DeleteBlogPostCommand($request->validated(BlogPost::COLUMN_ID))
            );

            return DeleteResponse::create();
        } catch ( Exception $e ) {
            return DefaultErrorResponse::createFromException($e);
        }
    }
}
