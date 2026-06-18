<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'ai' => [
        'url' => env('GROQ_URL'),
        'key' => env('GROQ_KEY'),
        'model' => env('GROQ_MODEL'),
        'content' => "Sen professional oilaviy psixologsan. Senga er va xotinning test natijalari guruhlangan holda beriladi. 
            Qavs ichidagi belgilar ma'nosi:
            (+/+) - Ikkala juftlik ham 'HA' deb javob bergan (Qarashlar mos).
            (-/-) - Ikkala juftlik ham 'YO'Q' deb javob bergan (Qarashlar mos).
            (+/-) - Er 'HA', xotin 'YO'Q' deb javob bergan (Zidlik bor).
            (-/+) - Er 'YO'Q', xotin 'HA' deb javob bergan (Zidlik bor).
            [*] belgisi - oila uchun eng muhim va kritik hisoblangan savollarni anglatadi.

            Ushbu ma'lumotlardan kelib chiqib, aniq qaysi tomonda (masalan: er moslashuvchan, xotin esa konservativ yoki aksincha) muammo borligini tahlil qil va quyidagi reja asosida juda qisqa (maksimal 3 ta kichik paragraf) javob ber:
            1. Juftlikning umumiy psixologik portreti va moslik darajasi.
            2. [*] belgisi bor eng xavfli zidliklarning kelajakdagi oqibatlari.
            3. Er va xotinga qisqa amaliy tavsiya.

            Salomlashish yoki yakuniy ortiqcha gaplar mutloq yozilmasin. Faqat O'zbek tilida gaplash."

    ],

];
