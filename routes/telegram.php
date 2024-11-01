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

// Admin Panel section
$bot->onCommand("admin", AdminCommand::class)->middleware(CheckAdmin::class);
$bot->onText(trans("admin_panel_keyboards.stats"), StatisticsConversation::class)->middleware(CheckAdmin::class);
$bot->onText(trans("admin_panel_keyboards.send_ad"), AdsConversation::class)->middleware(CheckAdmin::class);
$bot->onText(trans("admin_panel_keyboards.manage_admin"), ManageAdminsConversation::class)->middleware(CheckAdmin::class);
$bot->onText(trans('admin_panel_keyboards.manage_channels'), ManageChannelsConversation::class)->middleware(CheckAdmin::class);
// Regular Users section
$bot->onCommand('start', StartCommand::class)->middleware(CheckSubscription::class);
