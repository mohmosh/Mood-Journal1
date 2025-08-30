<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DonationController extends Controller
{
    public function redirectToIntaSend(Request $request)
    {
        $amount = intval($request->query('amount') * 100); // Convert ₦ to kobo

        if ($amount <= 0) {
            return redirect()->back()->with('error', 'Invalid amount.');
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('INTASEND_API_KEY')
        ])->post('https://api.intasend.com/v1/checkout', [
            'amount' => $amount,
            'currency' => 'KES',
            'customer_email' => Auth::user()->email,
            'callback_url' => route('webhook.donation'),
            'description' => "Donation from " . Auth::user()->name,
        ]);

        if ($response->successful()) {
            return redirect($response['checkout_url']);
        }

        return redirect()->back()->with('error', 'Unable to initiate donation.');
    }

    public function webhook(Request $request)
    {
        // Log donation details
        \Log::info('Donation Webhook:', $request->all());

        // Optional: Save donation to database
        // Donation::create([
        //     'user_id' => $userId,
        //     'amount' => $amount,
        //     'status' => 'success',
        // ]);

        // Here you can also trigger a notification to yourself
        // e.g., email, Slack, or dashboard alert

        return response()->json(['received' => true]);
    }

    public function stkPush(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:1',
        'phone' => 'required|string',
    ]);

    $amount = intval($request->amount * 100); // Convert to cents/kobo
    $phone  = $request->phone;

    // Call IntaSend STK Push API
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('INTASEND_API_KEY')
    ])->post('https://api.intasend.com/v1/mpesa/stk/push', [
        'amount' => $amount,
        'currency' => 'KES',
        'phone' => $phone,
        'callback_url' => route('webhook.donation'),
        'description' => "Donation from " . Auth::user()->name,
    ]);

    if ($response->successful()) {
        return redirect()->back()->with('success', 'STK push sent! Check your phone to complete payment.');
    }

    return redirect()->back()->with('error', 'Failed to initiate STK push.');
}

}
