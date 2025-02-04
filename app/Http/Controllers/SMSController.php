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

    public function receiveSms(Request $request)
    {

        SmsMessage::create([
            'sender' => $request->input('From'), // Twilio sends the sender's number as "From"
            'message' => $request->input('Body') // The SMS text content
        ]);

        // Create a new MessagingResponse object
        $response = new MessagingResponse();

        // Return the TwiML response
        return response($response, 200)
            ->header('Content-Type', 'application/xml');
    }

    public function showInbox()
    {
        $messages = SmsMessage::latest()->paginate(10); // Paginate messages

        return view('sms.index', compact('messages'));
    }

}
