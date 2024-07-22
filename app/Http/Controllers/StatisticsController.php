<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;

/**
 * Handles statistical operations for User data.
 */
class StatisticsController extends Controller
{
    /**
     * Get the total count of users.
     *
     * @return int The total number of users.
     */
    public static function getAllUserCount() : int
    {
        return User::all()->count();
    }

    /**
     * Get the count of users who joined in the last month.
     *
     * @return int The number of users who joined in the last month.
     */
    public static function getLastMonth() : int
    {
        $month_ago = Carbon::now()->subMonth();
        return User::where("created_at", ">", $month_ago)->count();
    }

    /**
     * Get the count of users who joined in the last week.
     *
     * @return int The number of users who joined in the last week.
     */
    public static function getLastWeek() : int
    {
        $week_ago = Carbon::now()->subWeek();
        return User::where("created_at", ">", $week_ago)->count();
    }

    /**
     * Get the count of users who joined today.
     *
     * @return int The number of users who joined today.
     */
    public static function getToday() : int
    {
        $today = Carbon::today();
        return User::whereDate("created_at", $today)->count();
    }
}
