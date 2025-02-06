<?php

namespace App\Http\Controllers;

use App\Services\GmailService;
use Google\Service\Gmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class GmailController extends Controller
{
    // Redirect the user to Google's OAuth 2.0 consent screen
    public function redirectToGoogle(GmailService $googleService)
    {
        return redirect($googleService->getAuthUrl());
    }

    // Handle the callback from Google and store the access token
    public function handleGoogleCallback(Request $request, GmailService $googleService)
    {
        $code = $request->input('code'); // Get the code from the URL
        $accessToken = $googleService->fetchAccessToken($code); // Exchange code for access token

        // Store the access token in the session
        session(['google_access_token' => $accessToken['access_token']]);

        return redirect()->route('emails');
    }

    // Get the list of emails after authenticating
    public function showEmails(GmailService $googleService)
    {
        $accessToken = session('google_access_token');
        if (!$accessToken) {
            return redirect()->route('oauth.redirect');
        }

        // Set the access token to the Google Client
        $googleService->getGmailService()->getClient()->setAccessToken($accessToken);

        // Fetch the user's emails
        $messages = $googleService->getGmailService()->users_messages->listUsersMessages('me', [
            'maxResults' => 10, // Limit to 10 messages
            'labelIds' => ['INBOX'], // Specify label like 'INBOX'
            'q' => 'is:unread' // Fetch only unread messages
        ]);

        // Initialize email details array
        $emailDetails = [];

        // Loop through the messages and extract details
        foreach ($messages->getMessages() as $message) {
            // Fetch the email details using the message ID
            $email = $googleService->getGmailService()->users_messages->get('me', $message->getId());

            // Get the headers of the email
            $headers = $email->getPayload()->getHeaders();
            $subject = '';
            $sender = '';
            $date = '';
            $content = '';
            $plainTextContent = ''; // Initialize plain text content
            $attachments = [];  // Initialize the attachments array for each email

            // Extract the subject, sender, and date
            foreach ($headers as $header) {
                if ($header->getName() === 'Subject') {
                    $subject = $header->getValue();
                } elseif ($header->getName() === 'From') {
                    $sender = $header->getValue(); // Extract sender's email
                } elseif ($header->getName() === 'Date') {
                    $date = $header->getValue(); // Extract the date
                }
            }

            // Get the payload and extract the content (text or HTML)
            $payload = $email->getPayload();
            foreach ($payload->getParts() as $part) {
                if ($part->getMimeType() === 'text/plain') {
                    $plainTextContent = base64_decode(strtr($part->getBody()->getData(), ['-' => '+', '_' => '/']));
                } elseif ($part->getMimeType() === 'text/html') {
                    $content = base64_decode(strtr($part->getBody()->getData(), ['-' => '+', '_' => '/']));
                }
            }

            // You can also use the snippet for a preview (optional)
            $snippet = $email->getSnippet();

            // Check for attachments
            foreach ($payload->getParts() as $part) {
                $filename = $part->getFilename();
                if (isset($filename) && $filename !== '') {
                    // Get the attachment ID and fetch the content
                    $attachmentData = $part->getBody()->getAttachmentId();
                    if ($attachmentData) {
                        // Use the correct method to get the attachment
                        $attachmentContent = $googleService->getGmailService()->users_messages_attachments->get('me', $message->getId(), $attachmentData);

                        // Decode and save the attachment
                        $attachmentDecoded = base64_decode(strtr($attachmentContent->getData(), ['-' => '+', '_' => '/']));

                        // Save attachment to storage
                        $path = public_path('files/' . $filename);
                        file_put_contents($path, $attachmentDecoded);

                        // Add attachment details to the array
                        $attachments[] = [
                            'filename' => $filename,
                            'path' => $path,
                        ];
                    }
                }
            }

            // Store the extracted details and attachments
            $emailDetails[] = [
                'subject' => $subject,
                'sender' => $sender,
                'date' => $date,
                'snippet' => $snippet, // Add snippet for preview
                'content' => $content, // HTML content
                'plain_text_content' => $plainTextContent, // Plain text content
                'attachments' => $attachments, // Attachments array
            ];
        }

        return view('email.index', compact('emailDetails'));
    }


    public function downloadAttachment($path)
    {
        // Define the full file path (assuming the file is saved in the 'public/files' directory)
        $filePath = public_path('files/' . $path);

        // Check if the file exists
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            // If the file doesn't exist, return a 404 response
            return response()->json(['error' => 'File not found'], Response::HTTP_NOT_FOUND);
        }
    }

}
