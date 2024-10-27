<?php

namespace App\Traits\admin;

use App\Models\Admin;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;

trait AdminHelpers
{
    use AdminPanelReplyKeyboards, AdminHelperFuncs, AdminPanelInlineKeyboards;
    protected function getAdminName(int $id) : string|null
    {
        return Admin::where("chat_id", $id)->first()->name;
    }
    protected function getAdminChatID(string $name) : int|null
    {
        return Admin::where("name", $name)->first()->chat_id;
    }

    protected function createAdmin(int $chat_id, string $name) : void
    {
        Admin::create([
            "chat_id" => $chat_id,
            "name" => $name
        ]);
    }

    protected function deleteAdmin(int $chat_id) : void
    {
        Admin::where("chat_id", $chat_id)->delete();
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function actionCancelled(Nutgram $bot, $type = "cancel") : void
    {
        $text = match ($type) {
            "back" => trans("admin_panel.start_msg"),
            default => trans("main.action_cancelled"),
        };
        $bot->sendMessage(
            text: $text,
            parse_mode: ParseMode::MARKDOWN_LEGACY,
            reply_markup: $this->startKeyboards()
        );
        $this->end();
    }
}
