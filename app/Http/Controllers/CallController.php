<?php

namespace App\Http\Controllers;


use Twilio\Rest\Client;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VoiceGrant;
use Twilio\TwiML\VoiceResponse;
use Illuminate\Http\Request;
use Twilio\Jwt\ClientToken;


class CallController extends Controller
{

    // Show the dialpad form
    public function showDialpadForm()
    {
        return view('call.index');
    }

    public function generateToken(Request $request){

		// Create access token, which we will serialize and send to the client
		$acess_token = new AccessToken(
		    env("TWILIO_ACCOUNT_SID"),
		    env("TWILIO_API_KEY"),
		    env("TWILIO_API_SECRET"),
		    3600,
            'Justin',
            'us1'
		);

		// Create Voice grant
		$voiceGrant = new VoiceGrant();
		$voiceGrant->setOutgoingApplicationSid(env("TWILIO_TWIML_APP_SID"));

		$voiceGrant->setIncomingAllow(true);

		// Add grant to token
		$acess_token->addGrant($voiceGrant);

        $token = $acess_token->toJWT();

		return response()->json([
			'identity' => 'Justin',
            'token' => $token
		]);
    }

    public function receiveCall(Request $request)
    {
        $dialledNumber = $request->get('To') ?? null;

        $voiceResponse = new VoiceResponse();

        // setup dial response
        $dial = $voiceResponse->dial();

        // dial the client
        $dial->client('Justin');


        return(string)$voiceResponse;
    }


}
