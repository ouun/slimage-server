<?php

use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Memory\MemoryAdapter;
use League\Flysystem\Filesystem;

use League\Glide\Responses\SlimResponseFactory;
use League\Glide\ServerFactory;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
	$container = $app->getContainer();

	$app->get('/', function (Request $request, Response $response) {
		$response->getBody()->write('Hello world! Let\'s do some image processing...');
		return $response;
	});

	$app->get('/img[/{params:.*}]', function (Request $request, Response $response, $args) {

		$s3 = $this->get('settings')['s3'];

		$client = new S3Client([
			'endpoint'  => $s3['endpoint'],
			'credentials' => [
				'key'    => $s3['key'],
				'secret' => $s3['secret'],
			],
			'region' => $s3['region'],
			'version' => 'latest',
		]);

		$server = ServerFactory::create([
			'source' => new Filesystem(new AwsS3Adapter($client, $s3['bucket'], $s3['prefix'])), // Get image from S3
			'cache' => new Filesystem(new MemoryAdapter()), // Do not cache output, we use CDNs instead
			'response' => new SlimResponseFactory(),
		]);

		return $server->getImageResponse($request->getAttribute('params'), $request->getQueryParams());
	});

};
