<?php

namespace App\Livewire;

use Livewire\Component;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

class Dialer extends Component
{
    public $phone_number = '';
    public $call_button_message = 'Call';

    public function render()
    {
        return view('livewire.dialer');
    }

    public function addNumber($number)
    {
        // Ensure the phone number does not exceed 11 digits
        if (strlen($this->phone_number) < 11) {
            $this->phone_number .= $number;
        }
    }

    public function getFormattedPhoneNumber()
    {
        // Convert user input (e.g., 09563350760) to international format (+639563350760)
        if (strlen($this->phone_number) === 11 && str_starts_with($this->phone_number, '0')) {
            return '+63' . substr($this->phone_number, 1);
        }

        return $this->phone_number;
    }

    public function removeLastDigit()
    {
        $this->phone_number = substr($this->phone_number, 0, -1);
    }

    public function makePhoneCall()
    {
        $this->call_button_message = 'Dialing ...';

        try {
            // Create the Twilio client
            $client = new Client(
                getenv('TWILIO_ACCOUNT_SID'),
                getenv('TWILIO_AUTH_TOKEN')
            );

            try {
                // Initiate the call using the formatted phone number
                $call = $client->calls->create(
                    $this->getFormattedPhoneNumber(),  // Now using formatted number
                    getenv('TWILIO_PHONE_NUMBER'),  // Fixed env variable retrieval
                    [
                        "url" => "http://demo.twilio.com/docs/voice.xml"
                    ]
                );

                // If call is successful, update the button message
                $this->call_button_message = 'Call Connected!';
            } catch (\Exception $e) {
                session()->flash('error', 'Error: ' . $e->getMessage());
                $this->call_button_message = 'Call Failed';
            }
        } catch (\Twilio\Exceptions\ConfigurationException $e) {
            session()->flash('error', 'Configuration Error: ' . $e->getMessage());
            $this->call_button_message = 'Call Failed';
        }
    }

}
