<?php

namespace App\Telegram\Commands;

use App\Traits\AdminPanelReplyKeyboards;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;

class AdminCommand extends Command
{
    use AdminPanelReplyKeyboards;
    protected string $command = 'admin';

    protected ?string $description = 'A part of command class which responsible for /admin command'; // better than  "A lovely description"

    public function handle(Nutgram $bot): void
    {
        $bot->sendMessage(
            text: trans('admin_panel.start_msg'),
            parse_mode: ParseMode::MARKDOWN_LEGACY,
            reply_markup: $this->startKeyboards()
        );
    }
}
