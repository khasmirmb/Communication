<?php

namespace App\Http\Controllers;

use App\Models\Sms;
use App\Models\SmsMessage;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Twilio\TwiML\MessagingResponse;

class SMSController extends Controller
{
    public function showForm()
    {
        return view('sms.compose');
    }

    public function sendSMS(Request $request)
    {
        $validated = $request->validate([
            'to' => 'required|string',
            'message' => 'required|string',
        ]);

        $twilio = app(Client::class);

        try {
            $twilio->messages->create(
                $validated['to'],
                [
                    'from' => env('TWILIO_PHONE_NUMBER'),
                    'body' => $validated['message']
                ]
            );

            return back()->with('success', 'SMS sent successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
