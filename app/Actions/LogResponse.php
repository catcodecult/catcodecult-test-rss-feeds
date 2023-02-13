<?php

namespace App\Actions;

use App\Models\Log;
use Illuminate\Http\Client\Response;

class LogResponse
{
    /**
     * @param Response $response
     * @return void
     */
    public static function action(Response $response): void
    {
        Log::query()->create([
            'request_method' => 'GET',
            'request_url' => $response->effectiveUri(),
            'response_code' => $response->status(),
            'response_body' => $response->body(),
            'request_time' => $response->transferStats->getHandlerStat('total_time_us') / 1000
        ]);
    }
}
