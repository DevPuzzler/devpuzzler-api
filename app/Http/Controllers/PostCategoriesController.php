<?php

namespace App\Http\Controllers;

use App\CQ\Queries\Query\PostCategories\GetPostCategoriesCollectionQuery;
use App\CQ\Queries\Query\PostCategories\GetPostCategoryQuery;
use App\Interfaces\Responses\JsonResponseInterface;
use App\Http\Responses\JSON\{GetResponse, DefaultErrorResponse};
use App\Tools\ValueObjects\Responses\{JsonResponseDataVO, JsonResponseErrorVO};
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

    public function getPostCategory($id): JsonResponseInterface
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
}
