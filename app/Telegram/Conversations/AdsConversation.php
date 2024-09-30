<?php

namespace App\Telegram\Conversations;

use App\Http\Controllers\AdsController;
use App\Models\User;
use App\Traits\admin\AdminHelpers;
use App\Traits\admin\SendAdsKeyboard;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;

class AdsConversation extends Conversation
{
    use AdminHelpers, SendAdsKeyboard;
    /**
     * @throws InvalidArgumentException
     */
    public function start(Nutgram $bot): void
    {
        $bot->sendMessage(
            text: trans("send_ads.start"),
            reply_markup: $this->back()
        );
        $this->next('getAds');
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getAds(Nutgram $bot): void
    {
        if ($this->checkIfActionCancelled($bot)) {
            $this->actionCancelled($bot);
            return;
        }
        $bot->copyMessage(
            chat_id: $bot->chatId(),
            from_chat_id: $bot->chatId(),
            message_id: $bot->messageId()
        );
        $bot->sendMessage(
            text: trans("send_ads.allow_to_send"),
            parse_mode: ParseMode::MARKDOWN_LEGACY,
            reply_markup: $this->permissionToSend()
        );
        $this->next("storeAds");
    }

    /**
     * @throws InvalidArgumentException
     */
    public function storeAds(Nutgram $bot) : void
    {
        $text = $bot->message()->text;
        if ($text == trans("main.cancel") || $text == "❌") {
            $this->actionCancelled($bot);
        } else if ($text == "✅") {
           $admin_name = $this->getAdminName($bot->chatId());
           AdsController::store($bot->chatId(), $bot->messageId(), $admin_name);
           $bot->sendMessage(
               text: trans("send_ads.sending_started"),
               reply_markup: $this->startKeyboards()
           );
           // check if there's a user in database if not send a message to the admin about there's no user and ads did not send to anyone
            if (User::all()->isEmpty()){
                $bot->sendMessage(
                    text: trans("send_ads.no_user_to_send"),
                    reply_markup: $this->startKeyboards()
                );
            }
        }
    }
}
