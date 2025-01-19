<?php

namespace App\Telegram\Conversations;

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
            $bot->sendMessage(
                text: __("subs.no_subs"),
                reply_markup: $this->susbButtons($bot)
            );
        } else {
            #### Show Reply Keyboard button here if user needs it
            $bot->sendMessage(
                text: __("subs.all_good")
            );
        }
    }
}
