<?php

namespace App\Actions;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimplePie\Item;

class NewsGetRssImage
{
    public static function action(string $namespace, Item $item): string|null
    {
        // Get all image of current namespace item
        $namespaces = data_get($item->get_item_tags($namespace, 'image'), '0.child');

        if (!$namespaces) {
            return null;
        }

        // Get first of it
        $externalImagePath = data_get($namespaces[$namespace], 'url.0.data');

        if (!$externalImagePath) {
            return null;
        }

        $image = file_get_contents($externalImagePath);
        $filename = 'rss-images/' . Str::uuid() . '.' . pathinfo($externalImagePath, PATHINFO_EXTENSION);
        Storage::disk('public')->put($filename, $image);

        return $filename;
    }
}
