<?php

namespace App\Http\Controllers;

use App\CQ\Commands\Command\PostCategories\CreatePostCategoryCommand;
use App\CQ\Commands\Command\PostCategories\DeletePostCategoryCommand;
use App\CQ\Queries\Query\PostCategories\GetPostCategoriesCollectionQuery;
use App\CQ\Queries\Query\PostCategories\GetPostCategoryQuery;
use App\Http\Requests\CreatePostCategoryRequest;
use App\Http\Requests\DeletePostCategoryRequest;
use App\Interfaces\Responses\JsonResponseInterface;
use App\Models\PostCategories;
use App\Http\Responses\JSON\{GetResponse, DefaultErrorResponse, PatchResponse, PostResponse};
use Exception;
use Symfony\Component\HttpFoundation\Response;

class PostCategoriesController extends Controller
{
    public function getPostCategoryCollection(): JsonResponseInterface
    {
        try {
            return GetResponse::create(
                $this->dispatchNow(new GetPostCategoriesCollectionQuery())->toArray()
            );
        } catch ( Exception $e) {
            return DefaultErrorResponse::create(
                null,
                'No records found',
                [],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    public function getPostCategory( int $id ): JsonResponseInterface
    {
        try {
            return GetResponse::create(
                $this->dispatch(new GetPostCategoryQuery($id))->toArray()
            );
        } catch ( Exception $e) {
            return DefaultErrorResponse::create(
                null,
                'No record found',
                [],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    public function createPostCategory( CreatePostCategoryRequest $request ): JsonResponseInterface
    {
        try {
            $this->dispatch( new CreatePostCategoryCommand($request) );
            return PostResponse::create();
        } catch ( Exception $e ) {
            return DefaultErrorResponse::create( null, $e->getMessage() );
        }
    }

    public function deletePostCategory( DeletePostCategoryRequest $request ): JsonResponseInterface
    {
        try {
            $this->dispatch( new DeletePostCategoryCommand( $request ) );
            return PatchResponse::create();
        } catch ( Exception $e ) {
            return DefaultErrorResponse::create( null, $e->getMessage() );
        }
    }
}
