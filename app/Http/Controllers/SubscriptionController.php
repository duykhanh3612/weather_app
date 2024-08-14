<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Jobs\SendDailyWeatherEmail;

class SubscriptionController extends Controller
{
    public function showSubscriptionForm()
    {
        return view('subscribe');
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'city' => 'required|string',
        ]);

        $email = $request->input('email');
        $city = $request->input('city');

        // Find or create a subscription
        $subscription = Subscription::firstOrCreate(
            ['email' => $email],
            ['city' => $city, 'is_subscribed' => false, 'unsubscribe_token' => Str::random(32)]
        );

        if ($subscription->is_subscribed) {
            return back()->with('error', 'Email has already been registered.');
        }

        // Update token if subscription exists but is not subscribed
        if (!$subscription->wasRecentlyCreated) {
            $subscription->update(['unsubscribe_token' => Str::random(32)]);
        }

        // Generate the verification URL
        $verifyUrl = URL::temporarySignedRoute(
            'verify.subscription',
            now()->addMinutes(60),
            ['email' => $email, 'token' => $subscription->unsubscribe_token]
        );

        // Dispatch email job
        Mail::to($email)->send(new \App\Mail\SubscriptionConfirmation($verifyUrl));

        return back()->with('message', 'Please check your email to confirm registration.');
    }

    public function unsubscribe($token)
    {
        $subscription = Subscription::where('unsubscribe_token', $token)->firstOrFail();
        $subscription->update(['is_subscribed' => false]);

        return back()->with('message', 'You have successfully unsubscribed.');
    }

    public function verifySubscription(Request $request, $email, $token)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        $subscription = Subscription::where('email', $email)
                                    ->where('unsubscribe_token', $token)
                                    ->firstOrFail();

        $subscription->update(['is_subscribed' => true]);

        // Dispatch job to send email
        SendDailyWeatherEmail::dispatch($subscription);

        return redirect()->route('weather.index')->with('message', 'Subscription confirmed successfully.');
    }
}
