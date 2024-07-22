<?php

namespace App\Telegram\Middleware;

use App\Http\Controllers\AdminController;
use SergiX44\Nutgram\Nutgram;

class CheckAdmin
{
    public function __invoke(Nutgram $bot, $next): void
    {
       $admin = AdminController::check_admin($bot->userId());
       if (!$admin) {
           return;
       }
        $next($bot);
    }
}
