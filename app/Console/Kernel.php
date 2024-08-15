<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\SendDailyWeatherEmail;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            // Lấy tất cả các người dùng đã đăng ký và gửi email
            $subscriptions = \App\Models\Subscription::where('is_subscribed', true)->get();

            foreach ($subscriptions as $subscription) {
                SendDailyWeatherEmail::dispatch($subscription);
            }
        })->daily(); // Thiết lập chạy mỗi ngày
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
