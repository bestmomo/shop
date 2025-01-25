<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use App\Models\{ Shop, Product };

class ProductAlert extends Mailable
{
    use Queueable, SerializesModels;

    public Shop $shop;
    public Product $product;

    public function __construct(Shop $shop, Product $product)
    {
        $this->shop = $shop;
        $this->product = $product;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->shop->email, $this->shop->name),
            subject: trans('Stock alert'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.productalert',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
