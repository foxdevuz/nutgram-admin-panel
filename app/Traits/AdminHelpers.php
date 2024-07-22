<?php

namespace App\Traits;

use App\Models\Admin;
use SergiX44\Nutgram\Nutgram;
use function Laravel\Prompts\text;

trait AdminHelpers
{
    use AdminPanelReplyKeyboards;
    protected function getAdminName(int $id) : string|null
    {
        return Admin::where("chat_id", $id)->first()->name;
    }
    protected function getAdminChatID(string $name) : int|null
    {
        return Admin::where("name", $name)->first()->chat_id;
    }
    protected function actionCancelled(Nutgram $bot) : void
    {
        $bot->sendMessage(
            text: trans("main.action_cancelled"),
            reply_markup: $this->startKeyboards()
        );
    }
}
