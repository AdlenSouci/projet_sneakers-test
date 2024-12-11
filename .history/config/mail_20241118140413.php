<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | Laravel supports both SMTP and various other mail "transport" drivers.
    | You may specify which one you're using throughout your application here.
    | By default, Laravel is configured for SMTP.
    |
    */

    'default' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Here are each of the mailers setup for your application. You may add
    | additional mailers as required, and configure as necessary.
    |
    */

    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp.gmail.com'),  // Utilise Outlook SMTP host
            'port' => env('MAIL_PORT', 587),                   // Port pour Outlook
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),     // Utilisation de l'encryption TLS
            'username' => env('MAIL_USERNAME'),                // Ton adresse e-mail Outlook
            'password' => env('MAIL_PASSWORD'),                // Le mot de passe ou mot de passe d'application
            'timeout' => null,
            'auth_mode' => null,
        ],

        'ses' => [
            'transport' => 'ses',
        ],

        'mailgun' => [
            'transport' => 'mailgun',
        ],

        'postmark' => [
            'transport' => 'postmark',
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path' => '/usr/sbin/sendmail -bs',
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | You may wish for all e-mails sent by your application to be sent from
    | the same address. Here, you may specify a name and address that is
    | used globally for all e-mails that are sent by your application.
    |
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'adlenssouci03@gmail.com'),  // Adresse email par défaut pour l'envoi
        'name' => env('MAIL_FROM_NAME', 'Sorel Plastique'),                           // Nom affiché
    ],

    /*
    |--------------------------------------------------------------------------
    | Markdown Mail Settings
    |--------------------------------------------------------------------------
    |
    | If you are using Markdown based email rendering, you may configure your
    | theme and component paths here, allowing for customization of emails.
    | Or, you may simply stick with Laravel's defaults!
    |
    */

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];
