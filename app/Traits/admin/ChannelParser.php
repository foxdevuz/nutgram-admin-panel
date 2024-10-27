<?php

namespace App\Traits\admin;

trait ChannelParser
{
    protected function parseChannelName(string $input) : string
    {
        if (str_contains($input, '+')) {
            // private channel / groups
            if (!str_starts_with($input, 'https://')) {
                return 'https://t.me/' . ltrim(str_replace(['t.me/', 'https://t.me/'], '', $input), '/');
            }
            return $input;
        }
        // public channel/groups
        $username = trim(str_replace(
            ['https://', 't.me/', '@'],
            '',
            $input
        ));

        return 'https://t.me/' . $username;
    }
}
