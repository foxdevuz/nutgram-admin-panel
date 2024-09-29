<?php

namespace App\Traits\admin;

use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

trait SendAdsKeyboard
{
    protected function permissionToSend() : ReplyKeyboardMarkup
    {
        return ReplyKeyboardMarkup::make(
            resize_keyboard: true,
            one_time_keyboard: true,
        )
            ->addRow(
                KeyboardButton::make("✅"),
                KeyboardButton::make("❌")
            )
            ->addRow(
                KeyboardButton::make(trans("main.cancel"))
            );
    }
}
