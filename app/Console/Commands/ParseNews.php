<?php

namespace App\Console\Commands;

use App\Exceptions\ParserAlreadyActiveException;
use App\Services\RssService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Throwable;

class ParseNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse RSS news feed';

    /**
     * @param RssService $rssService
     * @return int
     * @throws ParserAlreadyActiveException
     * @throws Throwable
     */
    public function handle(RssService $rssService): int
    {
        $rssService->parse();

        return SymfonyCommand::SUCCESS;
    }
}
