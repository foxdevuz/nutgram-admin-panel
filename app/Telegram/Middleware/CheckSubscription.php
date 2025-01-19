<?php

namespace App\Telegram\Middleware;

use App\Traits\user\subs\CheckSubscriptionTrait;
use SergiX44\Nutgram\Nutgram;

class CheckSubscription
{
    use CheckSubscriptionTrait;
    public function __invoke(Nutgram $bot, $next): void
    {
        $subs = $this->checkSubscription($bot);
        if (!$subs){
            $bot->sendMessage(
                text: trans('subs.no_subs'),
                reply_markup: $this->susbButtons($bot)
            );
            return;
        }

        $next($bot);
    }
}
