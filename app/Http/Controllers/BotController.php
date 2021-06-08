<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;

class BotController extends Controller
{
    public static function gestionar($text, $image)
    {
        $config = [
            "telegram" => [
                "token" => env('TELEGRAM_TOKEN'),
                'parse_mode' => 'markdown',
            ]
        ];
        DriverManager::loadDriver(TelegramDriver::class);
        $botman = BotManFactory::create($config);

        $botman->say($text, '-1001476327384', TelegramDriver::class);
        $botman->say($image, '-1001476327384', TelegramDriver::class);
    }

    public function recetobot(){
        if(session('recipe')){
            $recipe = session(('recipe'));
            
            $text = '
            🔥PREPAREN SUS COCINAS🔥 '.PHP_EOL.' '.PHP_EOL.'Nueva receta en la web: '.$recipe->title.' '.PHP_EOL.' '.PHP_EOL.''.$recipe->description.' '.PHP_EOL.' '.PHP_EOL.'🎛🍽 Puedes ver una vista completa en: 🍽🎛'.PHP_EOL.'https://recetometro.es/receta/'.$recipe->slug.'';

            $image = 'https://recetometro.es/images/'.$recipe->images[0]->image;
            
            $botman = BotController::gestionar($text, $image);
        }
        
        return redirect('/');
    }
}
