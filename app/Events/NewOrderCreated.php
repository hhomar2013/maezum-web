<?php
namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderCreated
{
    use Dispatchable, SerializesModels;

    public $message;
    public $sound;

    public function __construct($message, $sound = 'order.mp3')
    {
        $this->message = $message;
        $this->sound = $sound;
    }
}
