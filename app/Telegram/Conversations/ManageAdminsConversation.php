<?php

namespace App\Telegram\Conversations;

use App\Traits\admin\AdminHelpers;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use function Laravel\Prompts\text;

class ManageAdminsConversation extends Conversation
{
    use AdminHelpers;

    /**
     * @throws InvalidArgumentException
     */
    public function start(Nutgram $bot): void
    {
        $bot->sendMessage(
            text: trans("manage_admins.msg"),
            reply_markup: $this->manageAdminsKeyboard()
        );
        $this->next('secondStep');
    }

    /**
     * @throws InvalidArgumentException
     */
    public function secondStep(Nutgram $bot): void
    {
        $this->checkIfActionCancelled($bot);
        $text = $bot->message()?->text;
        switch ($text) {
            case trans("manage_admins.add"):
                $this->addAdmin($bot);
                break;
            case trans("manage_admins.remove"):
                $this->removeAdmin($bot);
                break;
            case trans("manage_admins.show"):
                $this->showAdmins($bot);
                break;
            default:
                $bot->sendMessage(
                    text: trans("main.wtf")
                );
                $this->start($bot);
                break;
        }
    }


    // private methods
    ## add admin conversation steps
    /**
     * @throws InvalidArgumentException
     */
    private function addAdmin(Nutgram $bot) : void
    {
        $bot->sendMessage(
            text: trans("manage_admins.add_admin"),
            reply_markup: $this->back()
        );

        $this->next('addAdminName');
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function addAdminName(Nutgram $bot) : void
    {
        if ($this->checkIfActionCancelled($bot)){
            $this->actionCancelled($bot);
            return;
        }
        $username = $bot->message()?->text;
        cache()->set("admin_add_username:" . $bot->chatId(), $username);
        $bot->sendMessage(
            text: trans("manage_admins.admin_id_add"),
            reply_markup: $this->back()
        );
        $this->next('addAdminCompleteStep');
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function addAdminCompleteStep(Nutgram $bot) : void
    {
        if ($this->checkIfActionCancelled($bot)){
            $this->actionCancelled($bot);
            return;
        }
        $admin_id = (int)$bot->message()?->text;
        try {
            $username = cache()->get("admin_add_username:" . $bot->chatId());
            $this->createAdmin($admin_id, $username);
            $bot->sendMessage(
                text: trans("manage_admins.admin_added"),
                reply_markup: $this->manageAdminsKeyboard()
            );
            $this->next("secondStep");
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
            $this->went_wrong($bot);
        }

    }

    ## remove admin conversation steps

    /**
     * @throws InvalidArgumentException
     */
    protected function removeAdmin(Nutgram $bot): void
    {
        if ($this->checkIfActionCancelled($bot)){
            $this->actionCancelled($bot);
            return;
        }
        $bot->sendMessage(
            text: $this->getAdminsList(),
            reply_markup: $this->back()
        );
        $bot->sendMessage(
            text: trans("manage_admins.admin_id_remove"),
            reply_markup: $this->back()
        );
        $this->next('removeAdminId');
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function removeAdminId(Nutgram $bot) :void
    {
        if ($this->checkIfActionCancelled($bot)){
            $this->actionCancelled($bot);
            return;
        }
        $admin_id = (int)$bot->message()?->text;
        $this->deleteAdmin($admin_id);
        $bot->sendMessage(
            text: trans("manage_admins.admin_removed"),
            reply_markup: $this->manageAdminsKeyboard()
        );
        $this->next('secondStep');
    }

    ## show admins conversation steps

    /**
     * @throws InvalidArgumentException
     */
    protected function showAdmins(Nutgram $bot): void
    {
        $bot->sendMessage(
            text: trans("manage_admins.here_is_admins") . "\n" . $this->getAdminsList(),
            parse_mode: ParseMode::MARKDOWN_LEGACY,
            reply_markup: $this->manageAdminsKeyboard()
        );
        $this->next('secondStep');
    }
}
