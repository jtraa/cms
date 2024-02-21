<?php

return [
    /*
    |--------------------------------------------------------------------------
    | List of enabled features
    |--------------------------------------------------------------------------
    | The following features are available:
    | \Chiiya\FilamentAccessControl\Enumerators\Feature::ACCOUNT_EXPIRY
    | \Chiiya\FilamentAccessControl\Enumerators\Feature::TWO_FACTOR
    */
    'features' => [
        //        \Chiiya\FilamentAccessControl\Enumerators\Feature::ACCOUNT_EXPIRY,
        //        \Chiiya\FilamentAccessControl\Enumerators\Feature::TWO_FACTOR,
    ],

    /*
    |--------------------------------------------------------------------------
    | Allowed Domains
    |--------------------------------------------------------------------------
    | A list of domains that are allowed to access the admin panel.
    */
    'allowed_domains' => [
        'esg.works',
        'es-group.eu',
        'gevelsendaken.nl',
        'kettlitz.nl',
        'itraa.nl',
        'jelletraa@gmail.com',
        'jelletraa@hotmail.com',
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Rules
    |--------------------------------------------------------------------------
    | Rules for the password set during the passwort reset flow.
    */
    'password_rules' => ['min:8'],

    /*
    |--------------------------------------------------------------------------
    | Password Hint
    |--------------------------------------------------------------------------
    | Helper text displayed when setting a new password on the passwort-reset
    | page. Useful for hinting at complex password requirements.
    */
    'password_hint' => null,

    /*
    |--------------------------------------------------------------------------
    | Date Format
    |--------------------------------------------------------------------------
    | Display format for datepicker
    */
    'date_format' => 'd.m.Y',
];
