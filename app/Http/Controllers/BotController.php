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

class BotController extends Controller
{
    public function gestionar()
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

        $botman->receivesLocation(function ($botman, Location $location) {
            $lat = $location->getLatitude();
            $lon = $location->getLongitude();
            $botman->reply("Datos de tu posición:\n\nLatitud: <b>$lat</b>\nLongitud: <b>$lon</b>", ['parse_mode' => 'HTML']);
        });

        $botman->hears('/foto', function ($bot) {
            // Creamos un adjunto
            $attachment = new Image('https://picsum.photos/200/300/?random&' . time(), [
                'custom_payload' => true,
            ]);

            // Build message object
            $message = OutgoingMessage::create('Foto al azar desde Picsum.photos')
                ->withAttachment($attachment);

            $bot->reply($message);
        });

        $botman->hears('/labrador', function ($bot) {
            // Creamos un adjunto
            $attachment = new Image('https://laravel.freeddns.org/labrador.jpg', [
                'custom_payload' => true,
            ]);

            // Build message object
            $message = OutgoingMessage::create('Foto de un Labrador Retriever')
                ->withAttachment($attachment);

            $bot->reply($message);
        });


        $botman->hears('/musica', function ($bot) {
            // Mandamos un mensaje
            $bot->reply("Recibirá su canción en breve...");

            // Creamos un adjunto
            $attachment = new Audio('https://laravel.freeddns.org/Sia_-_Eye_To_Eye.mp3', [
                'custom_payload' => true,
            ]);

            // Build message object
            $message = OutgoingMessage::create('Eye to Eye by Sia')
                ->withAttachment($attachment);

            $bot->reply($message);
        });


        $botman->hears('/mashumano', function ($bot) {
            $bot->typesAndWaits(3);
            $bot->reply("Se mostró status de escribiendo... y aquí la respuesta.");
        });


        // Con el método sendSticker de la API de Telegram hacemos respuestas a un nivel más bajo.
        $botman->hears('/sticker', function ($bot) {
            // https://tlgrm.es/stickers

            $bot->sendRequest('sendSticker', [
                'sticker' => "https://tlgrm.es/_/stickers/4da/ce2/4dace2b4-ecbb-397a-b670-39ad54717826/256/10.webp"
            ]);
        });


        $botman->listen();
    }
}
