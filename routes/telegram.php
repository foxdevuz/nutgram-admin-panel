<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Telegram\Commands\AdminCommand;
use App\Telegram\Commands\StartCommand;
use App\Telegram\Conversations\AdsConversation;
use App\Telegram\Conversations\ManageAdminsConversation;
use App\Telegram\Conversations\ManageChannelsConversation;
use App\Telegram\Conversations\StatisticsConversation;
use App\Telegram\Middleware\CheckAdmin;
use App\Telegram\Middleware\CheckSubscription;
use App\Telegram\Middleware\LaravelTrans;

// Admin Panel section
$bot->onCommand("admin", AdminCommand::class)->middleware(CheckAdmin::class);
$bot->onMessage(StatisticsConversation::class)
    ->middleware(CheckAdmin::class)
    ->middleware(new LaravelTrans("admin_panel_keyboards.stats"));

$bot->onMessage(AdsConversation::class)
    ->middleware(CheckAdmin::class)
    ->middleware(new LaravelTrans("admin_panel_keyboards.send_ad"));

$bot->onMessage(ManageAdminsConversation::class)
    ->middleware(CheckAdmin::class)
    ->middleware(new LaravelTrans("admin_panel_keyboards.manage_admin"));

$bot->onMessage(ManageChannelsConversation::class)
    ->middleware(CheckAdmin::class)
    ->middleware(new LaravelTrans("admin_panel_keyboards.manage_channels"));

// Regular Users section
$bot->onCommand('start', StartCommand::class)->middleware(CheckSubscription::class);
