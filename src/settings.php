<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

	    // S3 Settings
	    's3' => [
	    	'endpoint'  => isset($_ENV['S3_ENDPOINT'])  ? $_ENV['S3_ENDPOINT']  : null,
	    	'region'    => isset($_ENV['S3_REGION'])    ? $_ENV['S3_REGION']    : null,
	    	'bucket'    => isset($_ENV['S3_BUCKET'])    ? $_ENV['S3_BUCKET']    : null,
	    	'prefix'    => isset($_ENV['S3_PREFIX'])    ? $_ENV['S3_PREFIX']    : '',
	    	'key'       => isset($_ENV['S3_KEY'])       ? $_ENV['S3_KEY']       : null,
	    	'secret'    => isset($_ENV['S3_SECRET'])    ? $_ENV['S3_SECRET']    : null,
	    ]
    ],
];
