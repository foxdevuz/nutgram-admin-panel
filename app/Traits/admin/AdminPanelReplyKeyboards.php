<?php

namespace App\Traits\admin;

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
            );
    }
    protected function back() : ReplyKeyboardMarkup
    {
        return ReplyKeyboardMarkup::make(
            resize_keyboard: true,
            one_time_keyboard: true
        )
            ->addRow(
                KeyboardButton::make(trans("main.cancel"))
            );
    }

    protected function manageAdminsKeyboard() : ReplyKeyboardMarkup
    {
        return ReplyKeyboardMarkup::make(
            resize_keyboard: true,
            one_time_keyboard: true
        )
            ->addRow(
                KeyboardButton::make(trans("manage_admins.add")),
                KeyboardButton::make(trans("manage_admins.remove"))
            )
            ->addRow(
                KeyboardButton::make(trans("manage_admins.show"))
            )
            ->addRow(
                KeyboardButton::make(trans("main.back"))
            );
    }

    protected function manageChannelsKeyboard() : ReplyKeyboardMarkup
    {
        return ReplyKeyboardMarkup::make(
            resize_keyboard: true,
            one_time_keyboard: true
        )
            ->addRow(
                KeyboardButton::make(trans("manage_channels.add_channel")),
                KeyboardButton::make(trans("manage_channels.remove_channel"))
            )
            ->addRow(
                KeyboardButton::make(trans("manage_channels.show_channels"))
            )
            ->addRow(
                KeyboardButton::make(trans("main.back"))
            );


    }
}
