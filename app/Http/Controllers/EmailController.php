<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ComposeMail;
use Illuminate\Support\Facades\Storage;


class EmailController extends Controller
{
    // Show the form
    // Display inbox
    public function inbox()
    {
        return view('email.index');
    }

    // Display compose page
    public function compose()
    {
        return view('email.compose');
    }

    // Handle the form submission
    public function sendEmail(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email',
            'message' => 'required|string',
            'file_input' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,txt|max:10240', // Allowing attachments (10MB max)
        ]);

        // Prepare email data

        $message = (string) $request->input('message');

        $email = $request->input('email');

        // Handle the file attachment if provided
        $attachmentPath = null;

        if ($request->hasFile('file_input')) {
            $file = $request->file('file_input');
            $attachmentPath = time() . '_' . $file->getClientOriginalName();

            // Move the file to 'public/profile' directory
            $file->move(public_path('files'), $attachmentPath);
        }

        // Send the email
        Mail::to($email)
            ->send(new ComposeMail($message, $attachmentPath));

        // Redirect back with a success message
        return redirect()->route('email.inbox')
            ->with('success', 'Email sent successfully!');
    }

}
