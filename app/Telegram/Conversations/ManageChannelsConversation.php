<?php

namespace App\Telegram\Conversations;

use App\Models\Channel;
use App\Traits\admin\AdminHelpers;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

/*
 * THE CODE BELOW WIL BE UPDATED IN THE FUTURE
 * SINCE THS IS MORE MAJOR CHANGES, I WILL NOT UPDATE IT NOW
 * PLEASE WAIT FOR THE FUTURE UPDATES
 * THANK YOU
 *
 * OR UPDATE IT AND MAKE A PULL REQUEST
 * */


class ManageChannelsConversation extends Conversation
{
    use AdminHelpers;

    private const CACHE_KEY_PREFIX = 'channel_name_';

    /**
     * @throws InvalidArgumentException
     */
    public function start(Nutgram $bot): void
    {
        $bot->sendMessage(
            text: __("manage_channels.manage_channels_text"),
            reply_markup: $this->manageChannelsKeyboard()
        );
        $this->next('handleUserChoice');
    }

    /**
     * @throws InvalidArgumentException
     */
    public function handleUserChoice(Nutgram $bot): void
    {
        if ($this->checkIfActionCancelled($bot)) {
            $this->actionCancelled($bot);
            return;
        }

        $choice = $bot->message()->text;
        $actions = [
            __("manage_channels.add_channel") => 'addChannel',
            __("manage_channels.remove_channel") => 'removeChannel',
            __("manage_channels.show_channels") => 'showChannels',
        ];

        if (isset($actions[$choice])) {
            $this->{$actions[$choice]}($bot);
        } else {
            $bot->sendMessage(text: __("main.wtf"));
            $this->start($bot);
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    private function addChannel(Nutgram $bot): void
    {
        $bot->sendMessage(
            text: __("manage_channels.send_channel_name"),
            reply_markup: $this->back()
        );
        $this->next('processChannelName');
    }

    /**
     * @throws InvalidArgumentException
     */
    public function processChannelName(Nutgram $bot): void
    {
        if ($this->checkIfActionCancelled($bot)) {
            $this->actionCancelled($bot);
            return;
        }

        $channelName = $bot->message()->text;
        Cache::put($this->getCacheKey($bot), $channelName, now()->addMinutes(30));

        $bot->sendMessage(
            text: __("manage_channels.send_channel_id"),
            reply_markup: $this->back()
        );
        $this->next('processChannelId');
    }

    /**
     * @throws InvalidArgumentException
     */
    public function processChannelId(Nutgram $bot): void
    {
        if ($this->checkIfActionCancelled($bot)) {
            $this->actionCancelled($bot);
            return;
        }

        $channelId = $bot->message()->text;
        $channelName = Cache::pull($this->getCacheKey($bot));

        if (!$channelName) {
            $this->went_wrong($bot);
            return;
        }

        Channel::create([
            'chat_id' => $channelId,
            'name' => $channelName
        ]);

        $bot->sendMessage(
            text: __("manage_channels.channel_added"),
            reply_markup: $this->manageChannelsKeyboard()
        );
        $this->next("handleUserChoice");
    }

    /**
     * @throws InvalidArgumentException
     */
    private function removeChannel(Nutgram $bot): void
    {
        $channels = Channel::all();

        if ($channels->isEmpty()) {
            $this->sendEmptyChannelListMessage($bot);
            return;
        }

        $channelList = $this->formatChannelList($channels);
        $bot->sendMessage(text: $channelList, reply_markup: $this->back());

        $bot->sendMessage(
            text: __("manage_channels.send_channel_id_to_remove"),
            reply_markup: $this->back()
        );
        $this->next('processChannelRemoval');
    }

    /**
     * @throws InvalidArgumentException
     */
    public function processChannelRemoval(Nutgram $bot): void
    {
        if ($this->checkIfActionCancelled($bot)) {
            $this->actionCancelled($bot);
            return;
        }

        $channelId = $bot->message()->text;
        $channel = Channel::find($channelId);

        if ($channel) {
            $channel->delete();
            $message = __("manage_channels.channel_removed");
        } else {
            $message = __("manage_channels.channel_not_found");
        }

        $bot->sendMessage(
            text: $message,
            reply_markup: $this->manageChannelsKeyboard()
        );
        $this->next("handleUserChoice");
    }

    /**
     * @throws InvalidArgumentException
     */
    private function showChannels(Nutgram $bot): void
    {
        $channels = Channel::all();

        if ($channels->isEmpty()) {
            $this->sendEmptyChannelListMessage($bot);
        } else {
            $channelList = $this->formatChannelList($channels);
            $bot->sendMessage(
                text: $channelList,
                reply_markup: $this->manageChannelsKeyboard()
            );
        }
        $this->next("handleUserChoice");
    }

    private function formatChannelList($channels): string
    {
        $channelList = __("manage_channels.channel_list_header") . "\n";
        foreach ($channels as $channel) {
            $channelList .= "{$channel->name} (ID: {$channel->id})\n";
        }
        return $channelList;
    }

    /**
     * @throws InvalidArgumentException
     */
    private function sendEmptyChannelListMessage(Nutgram $bot): void
    {
        $bot->sendMessage(
            text: __("manage_channels.channel_list_empty"),
            reply_markup: $this->manageChannelsKeyboard()
        );
        $this->next("handleUserChoice");
    }

    private function getCacheKey(Nutgram $bot): string
    {
        return self::CACHE_KEY_PREFIX . $bot->chatId();
    }
}
