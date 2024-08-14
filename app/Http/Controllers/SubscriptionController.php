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
            // Validate email and city
            $request->validate([
                'email' => 'required|email',
                'city' => 'required|string',
            ]);
    
            $email = $request->input('email');
            $city = $request->input('city');
    
            // Check if the email is already registered
            $existingSubscription = Subscription::where('email', $email)->first();
    
            if ($existingSubscription) {
                // If the email already exists and is subscribed
                if ($existingSubscription->is_subscribed) {
                    session()->flash('error', 'Email has already been registered.');
                    return back();
                }
    
                // If the email exists but is not subscribed, generate a new token
                $token = Str::random(32);
                $existingSubscription->unsubscribe_token = $token;
                $existingSubscription->save();
            } else {
                // Create a new subscription
                $token = Str::random(32);
                $existingSubscription = Subscription::create([
                    'email' => $email,
                    'city' => $city,
                    'is_subscribed' => false,
                    'unsubscribe_token' => $token
                ]);
            }
    
            // Generate the verification URL
            $verifyUrl = URL::temporarySignedRoute(
                'verify.subscription',
                now()->addMinutes(60),
                ['email' => $email, 'token' => $token]
            );
    
            // Dispatch the email sending job to the queue
            dispatch(function () use ($email, $verifyUrl) {
                Mail::send('emails.confirmation', ['url' => $verifyUrl], function ($message) use ($email) {
                    $message->to($email)
                            ->subject('Confirm your registration.');
                });
            });
    
            // Save confirmation message into session
            session()->flash('message', 'Please check your email to confirm registration.');
    
            // Redirect back to the form
            return back();
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
