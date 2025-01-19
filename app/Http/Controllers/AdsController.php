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
        $bot = new Nutgram(config("services.telegram.token"));

        $ads = Ads::where(column: "is_allowed", value: true)->first();
        if (!$ads) {
            return response()->json(["message" => "No Ads found"], 404);
        }
        $current_user_index = $ads->current_user_index;
        $user_index_limit = $current_user_index + 30;
        $users = User::where(
            column: "id",
            operator: ">=",
            value: $current_user_index
        )->where(
            column: "id",
            operator: "<=",
            value: $user_index_limit
        )->get();

        return response()->json(["message" => "Ads sent successfully"]);
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
