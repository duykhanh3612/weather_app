<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Models\Subscription;
use App\Services\WeatherService;

class SendDailyWeatherEmail implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    protected $subscription;

    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function handle()
    {
        \Log::info('Sending daily weather email for: ' . $this->subscription->email);
    
        $weatherService = app(WeatherService::class);
        $weather = $weatherService->getWeather($this->subscription->city);
    
        Mail::send('emails.daily_weather', ['weather' => $weather], function ($message) {
            $message->to($this->subscription->email)
                    ->subject('Dự báo thời tiết hàng ngày');
        });
    
        \Log::info('Daily weather email sent to: ' . $this->subscription->email);
    }
    
}
