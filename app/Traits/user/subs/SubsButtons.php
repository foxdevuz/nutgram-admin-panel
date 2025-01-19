<?php

namespace App\Traits\user\subs;

use App\Models\Channel;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

trait SubsButtons
{
    protected function susbButtons(Nutgram $bot) : InlineKeyboardMarkup
    {
        $subs =  InlineKeyboardMarkup::make();
        $channels = Channel::all();

        foreach ($channels as $channel){
            $chat_info = $bot->getChat(chat_id: $channel->chat_id);
            $subs->addRow(
                InlineKeyboardButton::make(
                    text: $channel->name,
                    url: $chat_info->invite_link
                )
            );
        }

        $subs->addRow(
          InlineKeyboardButton::make(
              text: __("subs.check"),
              callback_data: "check_subs:" . $bot->userId()
          )
        );

        return $subs;
    }
}
