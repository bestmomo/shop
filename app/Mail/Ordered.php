<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use App\Models\{ Shop, Order };

class Ordered extends Mailable
{
    use Queueable, SerializesModels;

    public Shop $shop;
    public Order $order;

    public function __construct(Shop $shop, Order $order)
    {
        $this->shop = $shop;
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->shop->email, $this->shop->name),
            subject: trans('Your order'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.ordered',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
