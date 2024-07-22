<?php
// statistics text
use App\Http\Controllers\StatisticsController;

$stat_text = "Hello Admin! Here are the statistics of your bot:\n\n";
$stat_text .= "Total users: ".StatisticsController::getAllUserCount()."\n";
$stat_text .= "Users who joined in the last month: ".StatisticsController::getLastMonth()."\n";
$stat_text .= "Users who joined in the last week: ".StatisticsController::getLastWeek()."\n";
$stat_text .= "Users who joined today: ".StatisticsController::getToday()."\n";

return [
    "start_msg"=>"👋 Hello Admin! Welcome to " . env("BOT_NAME") . "'s admin panel! Please choose the section you want to manage.",
    "admin_start_placeholder"=>"Please choose the section you want to manage.",
    "stat_text"=>$stat_text,
];
