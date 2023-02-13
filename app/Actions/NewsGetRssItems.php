<?php

namespace App\Actions;

use Illuminate\Support\Collection;
use SimplePie\Item;
use SimplePie\SimplePie;

class NewsGetRssItems
{
    /**
     * @param string $rawXml
     * @return Collection<Item>
     */
    public static function action(string $rawXml): Collection
    {
        $simplePie = new SimplePie();
        $simplePie->set_raw_data($rawXml);
        $simplePie->enable_cache(false);
        $simplePie->init();
        $simplePie->handle_content_type();

        return collect($simplePie->get_items());
    }
}
