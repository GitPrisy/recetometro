<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;
use BotMan\BotMan\Messages\Attachments\File;
use BotMan\BotMan\Messages\Attachments\Audio;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Attachments\Location;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

use function React\Promise\reduce;
use function Symfony\Component\String\b;

class BotController extends Controller
{
    // public static function setup($text)
    // {
    //     $config = [
    //         // Your driver-specific configuration
    //         "telegram" => [
    //             "token" => env('TELEGRAM_TOKEN'),
    //             'parse_mode' => 'markdown',
    //         ]
    //     ];
    //     DriverManager::loadDriver(TelegramDriver::class);
    //     $botman = BotManFactory::create($config);

    //     $botman->say($text, '-1001476327384', TelegramDriver::class);   
    // }

    public function setup()
    {
        $config = [
            // Your driver-specific configuration
            "telegram" => [
                "token" => env('TELEGRAM_TOKEN')
            ]
        ];
        DriverManager::loadDriver(TelegramDriver::class);
        $botman = BotManFactory::create($config);

        $botman->hears('/start', function ($bot) {
            // $bot->reply('Bienvenidos/as a mi bot de Telegram con Laravel y Botman.io');
            $bot->reply('<b>Bienvenidos/as</b> a mi bot de Telegram con Laravel y Botman.io', ['parse_mode' => 'HTML']);
        });
    }

    public function recetobot(){
        if(session('recipe')){
            
            $recipe = session(('recipe'));
            
            $texto = '*¡¡NUEVA RECETA EN LA WEB!!*'.PHP_EOL.' '.PHP_EOL.''.$recipe->title.''.PHP_EOL.'Enlace directo: https://recetometro.es/receta/'.$recipe->slug;
            
            BotController::setup($texto);
        }
        

        return redirect('/receta/create');
    }
}
