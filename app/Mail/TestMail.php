<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
class TestMail extends Mailable
{
    use Queueable, SerializesModels;
    public $mailData;

    /**
     * Create a new message instance.
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
       
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->mailData['title'] ?? 'Test Mail',
        );
    }
    
    /**
     * Get the message content definition.
     */
    public function content(): Content
{
    return new Content(
        view: 'mails.test_mail', // Ensure this view exists
        with: ['mailData' => $this->mailData],
    );
}
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        if (!empty($this->mailData['files'])) {
            foreach ($this->mailData['files'] as $file) {
                if (is_string($file) && file_exists($file)) {
                    $attachments[] = Attachment::fromPath($file);
                } elseif (is_array($file) && isset($file['content']) && isset($file['name'])) {
                    $attachments[]=  Attachment::fromData(fn () =>$file['content'], $file['name'])
                    ->withMime('application/pdf');
                }




















                else {
                    \Log::error('File does not exist: ' . $file);
                }
            }
        }
    
        return $attachments;
    }
   
}
