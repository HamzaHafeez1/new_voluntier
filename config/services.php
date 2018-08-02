<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

	'firebase' => [
		'service_account' => env('FIREBASE_SERVICE_ACCOUNT'),
		'private_key' => "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDRjPfNzZv/k2hf\n209vjcCMiDO1h6ptI+m7nM+sFVntqRG0p2xoFw7PDUG2nELbh3jQM9nJo80As2zU\nUogbC/dabYqoxI60QTNVv/o/1h9rQZuC/Ach4FcKi+XE5fCBtb16+E19MBpJ2UsD\n8GZPK2uQXVM/nfxlthjoy1Mf/vXFzvc4W2ycjwJ1BPjYuaAgJ6ArNJ5TrUobbmaL\nru2CacTV1MEdkmPEjXdtKrAGIVFRoesEB7llDvd5caNect6OvbNDVoUaPcESlnpp\nwdPiAc5vRhOZqcwOiNh5V32fNbwnXV6jnHd2Hc0fJOiIagVolYeELkL0G0KKrxXO\nb8+1FJyBAgMBAAECggEAQ3e0Jz5uXgyrW8WEH2IP3w9ROr6p2Abqj72uvXSIZjT7\nnuMSy7a0zWQyxqUr/3twIfS3x6yl6fZa8Ud7S93/70z6iljyq0WczhyH6Xq61fEj\nLTqQ307YJ2ygd1MjKtgFYCzG4ioVJLbB6MxDXHUZ5jqt/XsT0vmcroMcSd5wahWi\nAU2Wu8/4CeooLf3jtqKb1OaP4m85V2OffcSFAebp0ZVAlq87R8bqfNDqehIfkVu6\nEWQwQhbPTQsAC44vDLqI7jcR7IpKIQvguQAQ1Fy9WSC3A8rwPkdgn0kIGu2MvakQ\n3RfamlYXVPvHFmNYBJl/cbEeLLtSjVUyz8f1FgsMMwKBgQDy/V9l7UpzzoO1+gHY\neFoqGHiqynXpoR4ygo8Sidg+ApwHgd7/KpQ2n2EM1apPXQOqQMy25ojB5FFMQ7M6\nV3VqA8IAxbD/v2BOm/tdlDSdhEZCgs8rja79ycQ/img1TVvS+NgG7+p6bJsfCJec\nGVpn7WBamW7+OGudAulYvnG8XwKBgQDcxUAZw5lpw2I+WU8cb72ovnztEDsGfxHT\nbsBgQKd3J/czrFYjOdDZV4Wk081mn90Wb/A5RlgjRsifMETLHp27l+RYtPOOoCxp\n04EaafQ2Yp44zZlcNqEmBrI3x2oTSB9GmGVvLmhxWVuLJhj02FbTxXVyHQ75BpQa\nJOz9xERTHwKBgQDLfAdBsh9hL5X49K5K+y52hhu22uk3hudk4RSzL6BY/ZJwbv+x\nq5SG0Z1SRDPlVj1VfAJzQEdSJ8M1HJSgzNDUwOTcBLGe2kLqUZGE4jHVnwm/dQ/M\np0/d0/N2So/N40R8PkuaM5umfgDBUk60OD8PPSgtdsQOPG1SBTgoSwOv/QKBgQDc\npHrzBO0fqflXLPUHC5p2uqKqX01OqdLMCGVWDWgRi6zhRPz1ycO0ZGeaG2Cuj1ls\nIkXpSCewYf8CMkCe7KNiKGU8TuUYh3a78XmXR4ueiyNsy/bZFXQrSAf3/WJDkRJJ\nAOhnnO8fUdpPEK1ij5D/p9pASVB8jBmao4sD+JL8qwKBgAUb6F5t0KwQIz4vLF1x\nQa3PQmuO8Ct3otKYV4yr17aj0ubCwqVtvpBM+/ZNUsZY4cBBLpl7OP8peuTydMEP\nBFFHztLpq0udQqGxCY0PewNPodU46QrXlsttYza3gIUBIcufJO2i124dE1ZmCIQM\nJgDI/gUJFPmabKkQDB7ZRFqg\n-----END PRIVATE KEY-----\n", //env('FIREBASE_PRIVATE_KEY')
		'database_name' => env('FIREBASE_DATABASE_NAME'),
		'config_file' => env('FIREBASE_CONFIG_FILE')
	]
];
