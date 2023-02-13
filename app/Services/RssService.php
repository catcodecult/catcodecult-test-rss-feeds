<?php

namespace App\Services;

use App\Actions\LogResponse;
use App\Actions\NewsCreateFromRss;
use App\Actions\NewsGetRssItems;
use App\Exceptions\ParserAlreadyActiveException;
use Illuminate\Support\Facades\Http;
use Psr\SimpleCache\InvalidArgumentException;
use Throwable;

class RssService
{
    /**
     * @param string $uri
     * @param string $namespace
     * @return bool
     * @throws InvalidArgumentException
     * @throws ParserAlreadyActiveException
     * @throws Throwable
     */
    public function parse(string $uri = 'http://static.feed.rbc.ru/rbc/logical/footer/news.rss', string $namespace = 'https://www.rbc.ru'): bool
    {
        // If parser already running, throw exception
        if ($this->isLocked()) {
            throw new ParserAlreadyActiveException('Parser already working, try later.');
        }

        // Lock to avoid another run
        $this->lock();

        try {
            $response = Http::get($uri);

            LogResponse::action($response);

            foreach (NewsGetRssItems::action($response->body()) as $item) {
                NewsCreateFromRss::action($namespace, $item);
            }

        } catch (Throwable $e) {
            // Unlock on request or parsing error
            $this->unlock();
            throw $e;
        }

        // Unlock on success
        $this->unlock();

        return true;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function isLocked(string $key = 'parser'): bool
    {
        return cache()->has($key);
    }

    /**
     * @param string $key
     * @return bool
     * @throws InvalidArgumentException
     */
    public function lock(string $key = 'parser'): bool
    {
        return cache()->set($key, true);
    }

    /**
     * @param string $key
     * @return bool
     * @throws InvalidArgumentException
     */
    public function unlock(string $key = 'parser'): bool
    {
        return cache()->delete($key);
    }
}
