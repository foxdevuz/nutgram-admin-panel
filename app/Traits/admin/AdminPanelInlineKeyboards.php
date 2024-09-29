<?php

namespace App\Traits\admin;

use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

trait AdminPanelInlineKeyboards
{
    protected function techSupport() : InlineKeyboardMarkup
    {
        return InlineKeyboardMarkup::make()
            ->addRow(
                InlineKeyboardButton::make(trans("admin_panel.dev"), url: "https://t.me/".env("DEV_TELEGRAM")),
            );
    }
}
