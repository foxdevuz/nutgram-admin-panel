<?php

namespace App\Telegram\Middleware;

use SergiX44\Nutgram\Nutgram;

class LaravelTrans
{
    public function __construct(protected string $key) {
    }

    public function __invoke(Nutgram $bot, $next): void
    {
        if($bot->message()?->text !== trans($this->key)){
            return;
        }

        $next($bot);
    }
}
