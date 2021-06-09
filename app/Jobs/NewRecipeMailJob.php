<?php

namespace App\Jobs;

use App\Mail\NewRecipeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class NewRecipeMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $title, $ingredients, $preparation, $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($title, $ingredients, $preparation, $email)
    {
        $this->title = $title;
        $this->ingredients = $ingredients;
        $this->preparation = $preparation;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new NewRecipeMail($this->title, $this->ingredients, $this->preparation));
    }
}
