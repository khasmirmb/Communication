import './bootstrap';
import 'flowbite';
import jQuery from 'jquery';

import { Device } from '@twilio/voice-sdk';

var token;
var identity;
var device;
let activeCall;


getAcessToken();

async function getAcessToken(){
    console.log("Requesting an acess token for twilio..");

    try {
        const data = await (await fetch("/token")).json();

        console.log('I got the token');

        token = data.token;

        identity = data.identityl;

        initializeDevice();

    } catch (error){
        console.log(error);
    }
}

function initializeDevice(){
    console.log("Initializing Device..");

    device = new Device(token, {
        logLevel: 1,
        codecPreferences: ['opus', 'pcmu'],
        maxCallSignalingTimeoutMs: 30000
    });

    registerEventPhoneListener();

    device.register();

    console.log("Device is done registering..");
}

async function registerEventPhoneListener() {

    device.on("incoming", handleIncomingCall);
}

async function handleIncomingCall(call){

    var call = call;

    console.log("Inbound phone call" + call.parameters.From);

    // Show incoming call modal
    document.getElementById('call-modal').classList.remove('hidden');

    // Handle Accept Call
    document.getElementById('accept-call').onclick = function() {
        console.log("Accepting the call...");

        // Hide the incoming call modal
        document.getElementById('call-modal').classList.add('hidden');

        // Show the call in progress modal
        document.getElementById('call-in-progress').classList.remove('hidden');

        // Accept the call using Twilio's Client SDK
        call.accept();
    };

    // Handle Decline Call
    document.getElementById('decline-call').onclick = function() {
        console.log("Declining the call...");

        // Reject the call
        call.reject();

        // Hide the incoming call modal
        document.getElementById('call-modal').classList.add('hidden');
    };

    // End call functionality
    document.getElementById('end-call').onclick = function() {
        console.log("Ending the call...");;

        hangupPhoneCall(call);
    };

    function hangupPhoneCall(call){

        call.disconnect();

        // Assuming the call object is accessible here
        if (device.activeCall) {
            device.activeCall.disconnect();
        }

        document.getElementById('call-in-progress').classList.add('hidden')
    }

}
