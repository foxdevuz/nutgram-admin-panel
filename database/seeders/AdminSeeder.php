<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            "name"=>"Main Admin",
            "chat_id"=>env("ADMIN_ID"),
            "is_main"=>true,
            "can_send_ads"=>true,
            "can_add_admin"=>true,
            "can_del_admin"=>true,
            "can_add_channel"=>true,
            "can_del_channel"=>true
        ]);
    }
}
