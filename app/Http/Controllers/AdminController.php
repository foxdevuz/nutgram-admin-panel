<?php

namespace App\Http\Controllers;

use App\Models\Admin;

class AdminController extends Controller
{
    public static function check_admin(int $id) : bool
    {
        return Admin::where('chat_id', $id)->exists();
    }
}
