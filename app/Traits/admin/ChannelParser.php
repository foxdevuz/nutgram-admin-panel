<?php

namespace App\Traits\admin;

use InvalidArgumentException;
use SergiX44\Nutgram\Nutgram;

trait ChannelParser
{
    protected function parseChannelName(string $input, Nutgram $bot): false|string
    {
        // Check for private channel/group link pattern
        if (str_contains($input, '+')) {
            return false;
        }

        // Handle public channels
        $username = trim(str_replace(
            ['https://', 't.me/', '@'],
            '',
            $input
        ));

        return '@' . $username;
    }

    protected function getIdFromForwardedMessage(Nutgram $bot): ?int
    {
        return $bot->message()?->forward_from_chat?->id;
    }
}
