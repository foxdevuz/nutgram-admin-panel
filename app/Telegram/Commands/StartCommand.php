<?php

namespace App\Telegram\Commands;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Handlers\Type\Command;

class StartCommand extends Command
{
    protected string $command = 'start';

    protected ?string $description = 'A command class which responsible for giving response when user types /start';

    public function handle(Nutgram $bot): void
    {
        $bot->sendMessage(trans('main.start_message'));
    }
}
