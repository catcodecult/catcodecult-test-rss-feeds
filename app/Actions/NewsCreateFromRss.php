<?php

namespace App\Actions;

use App\Models\News;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use SimplePie\Item;

class NewsCreateFromRss
{
    /**
     * @param string $namespace
     * @param Item $item
     * @return News|Model|Builder
     */
    public static function action(string $namespace, Item $item): News|Model|Builder
    {
        $existNews = News::query()->where('link', $item->get_link())->first();

        if ($existNews) {
            return $existNews;
        }

        return News::query()->create([
            'title' => $item->get_title(),
            'short_description' => $item->get_description(),
            'published_at' => $item->get_date('U'),
            'author' => $item->get_author()?->email,
            'image_path' => NewsGetRssImage::action($namespace, $item),
            'link' => $item->get_link()
        ]);
    }
}
