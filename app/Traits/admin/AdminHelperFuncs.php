<?php

namespace App\Traits\admin;

use App\Models\Admin;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;

trait AdminHelperFuncs {
    protected function checkIfActionCancelled(Nutgram $bot): bool
    {
        $text = $bot->message()?->text ?? $bot->callbackQuery()?->data;
        if ($text == trans("main.cancel") || $text == "❌" || $text == "cancel" || $text == trans("main.back")) {
           return true;
        }
        return false;
    }

    protected function getAdminsList() : String
    {
        $admins = Admin::all();
        if ($admins->isEmpty()) {
            return trans("manage_admins.admin_list_empty");
        }
        $list = "";
        foreach ($admins as $admin) {
            $list .= $admin->name . " - " . $admin->chat_id . "\n";
        }
        return $list;
    }
    protected function went_wrong(Nutgram $bot) : void
     {
        $bot->sendMessage(
            text: trans("admin_panel.went_wrong"),
            parse_mode: ParseMode::MARKDOWN_LEGACY,
            reply_markup: $this->techSupport()
        );
    }
}
