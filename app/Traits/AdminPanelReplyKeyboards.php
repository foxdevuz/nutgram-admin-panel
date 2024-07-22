<?php

namespace App\Traits;

use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

trait AdminPanelReplyKeyboards
{
    protected function startKeyboards() : ReplyKeyboardMarkup
    {
        return ReplyKeyboardMarkup::make(
            resize_keyboard: true,
            one_time_keyboard: true,
            input_field_placeholder: trans('admin_panel.admin_start_placeholder')
        )
            ->addRow(
                KeyboardButton::make(text: trans('admin_panel_keyboards.stats')),
                KeyboardButton::make(text: trans('admin_panel_keyboards.send_ad'))
            )
            ->addRow(
                KeyboardButton::make(text: trans('admin_panel_keyboards.manage_admin')),
                KeyboardButton::make(text: trans('admin_panel_keyboards.manage_channels'))
            )
            ->addRow(
                KeyboardButton::make(trans("admin_panel_keyboards.ongoing_actions"))
            );
    }
}
