<?php

namespace App\Telegram\Conversations;

use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class StatisticsConversation extends Conversation
{
    /**
     * @throws InvalidArgumentException
     */
    public function start(Nutgram $bot): void
    {
        $bot->sendMessage(
            text: trans("admin_panel.stat_text")
        );
        $this->end();
    }
}
