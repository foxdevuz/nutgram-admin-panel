<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\User;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use SergiX44\Nutgram\Nutgram;

class AdsController extends Controller
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function sendAds()
    {
        $bot = new Nutgram(env("TELEGRAM_TOKEN"));
        $ads = $this->getAds();
        $users = $this->getAllUsers();
        if (count($ads) == 0 || $users->isEmpty()) {
            return response()->json(["message" => "No Ads or Users found"]);
        }
        foreach ($ads as $ad) {
            foreach ($users as $user) {
                $bot->copyMessage(
                    chat_id: $user->user_id,
                    from_chat_id: $ad->from_id,
                    message_id: $ad->message_id
                );
                // Sleep for 32 milliseconds to avoid hitting rate limits
                sleep(0.032);
            }
            $this->resetAds($ad["id"]);
        }
        return response()->json(["message" => "Ads sent successfully"]);
    }

    private function getAds() : array
    {
        return Ads::where(column: "is_allowed", operator: true)->get()->toArray();
    }

    private function getAllUsers()
    {
        return User::all();
    }

    public static function store(int $from_id, int $msg_id, string $admin_name, bool $is_allowed = true) : bool
    {
        try {
            Ads::create([
                "from_id" => $from_id,
                "message_id" => $msg_id,
                "admin_name" => $admin_name,
                "is_allowed" => $is_allowed
            ]);
            return true;
        }catch (Exception $e) {
            return false;
        }
    }

    private static function resetAds(int $id): void
    {
        Ads::find($id)->update(["is_allowed" => false]);
    }
}
