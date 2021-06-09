<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewRecipeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $title, $ingredients, $preparation;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $ingredients, $preparation)
    {
        $this->title = $title;
        $this->ingredients = $ingredients;
        $this->preparation = $preparation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.recipe')
            ->subject("Nueva receta en Recetometro!!")
            ->with([
                "title" => $this->title,
                "ingredients" => $this->ingredients,
                "preparation" => $this->preparation,
            ]);
    }
}
