<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Email extends Model
{
    use HasFactory;

    protected $table = 'emails';

    protected $fillable = [
        'message_id', 'from_email', 'from_name', 'to_email', 'subject', 'body', 'html_body', 'attachments'
    ];

    protected $casts = [
        'attachments' => 'array',
    ];
}
