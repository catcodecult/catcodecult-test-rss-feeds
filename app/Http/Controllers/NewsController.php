<?php

namespace App\Http\Controllers;

use App\Http\Requests\News\GetNewsRequest;
use App\Queries\GetNews;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Info;
use OpenApi\Attributes\License;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Response;
use OpenApi\Attributes\Schema;

#[Info(
    version: '1.0.0',
    description: 'News API provided for testing reasons',
    title: 'News API',
    license: new License('MIT')
)]
class NewsController extends Controller
{
    /**
     * @param GetNewsRequest $request
     * @return JsonResponse
     */
    #[Get(path: '/api/news')]
    #[Response(response: 200, description: 'List of news')]
    #[Parameter(
        name: 'page',
        description: 'Page for display',
        in: 'query',
        schema: new Schema(
            type: 'integer',
            example: 1
        )
    )]
    #[Parameter(
        name: 'columns',
        description: 'Columns for display',
        in: 'query',
        schema: new Schema(
            type: 'string',
            example: 'id,title,published_at'
        )
    )]
    #[Parameter(
        name: 'order',
        description: 'News order, sorting by published_at',
        in: 'query',
        schema: new Schema(
            type: 'string',
            enum: ['asc', 'desc'],
            example: 'asc'
        )
    )]
    public function index(GetNewsRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $news = GetNews::query($validated);

        return response()->json($news);
    }
}
