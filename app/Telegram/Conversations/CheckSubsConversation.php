<?php

namespace App\Telegram\Conversations;

use App\Telegram\Commands\StartCommand;
use App\Traits\user\subs\CheckSubscriptionTrait;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class CheckSubsConversation extends Conversation
{
    use CheckSubscriptionTrait;
    public function start(Nutgram $bot): void
    {
        $subs = $this->checkSubscription($bot);
        if (!$subs){
            $bot->answerCallbackQuery(
                text: __("subs.no_subs"),
                show_alert: true
            );
        } else {
            $bot->deleteMessage(
                chat_id: $bot->chatId(),
                message_id: $bot->messageId()
            );
            (new StartCommand())->handle($bot);
        }
    }
}
