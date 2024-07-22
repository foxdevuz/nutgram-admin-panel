<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Telegram\Commands\AdminCommand;
use App\Telegram\Commands\StartCommand;
use App\Telegram\Conversations\StatisticsConversation;
use App\Telegram\Middleware\CheckAdmin;

// Admin Panel section
$bot->onCommand("admin", AdminCommand::class)->middleware(CheckAdmin::class);
$bot->onText(trans("admin_panel_keyboards.stats"), StatisticsConversation::class)->middleware(CheckAdmin::class);
// Regular Users section
$bot->onCommand('start', StartCommand::class);
