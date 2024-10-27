<?php

namespace App\Traits\user;

use App\Models\Channel;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ChatMemberStatus;

trait check_subscription
{
    protected function checkSubscription(Nutgram $bot): bool
    {
        $channels = Channel::all();
        $user_status = ['false'];
        foreach ($channels as $channel){
            $membership_status = $bot->getChatMember(
                chat_id: $channel->chat_id,
                user_id: $bot->user()->id
            );
            if ($membership_status->status == ChatMemberStatus::ADMINISTRATOR ||
                $membership_status->status == ChatMemberStatus::MEMBER ||
                $membership_status->status == ChatMemberStatus::CREATOR)
            {
                $user_status[0] = 'true';
            } else {
                // users have to subscribe to all channels since they are not subscribed to all channels they can't use the bot
                $user_status[0] = 'false';
                break;
            }
        }
        return $user_status[0];
    }
}
