<?php

use GuzzleHttp\Client;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
   $client = new Client();
   $url = env("APP_URL");
   $client->request(method: "GET", uri: sprintf("%s/sendAds", $url));
})->everyTwoSeconds();

