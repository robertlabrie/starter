<?php
require __DIR__ . '/vendor/autoload.php';


$app = new Silex\Application();
$app['debug'] = true;
$app['root'] = '/starter';

$app['MongoClient'] = $app->share(function($app) {
	return new \MongoClient();
});

//the IoC
$app['ioc'] = $app-> share(function ($app) { return new \RobertIOC\RobertIOC($app); });
//serializer
$app['RobertSerializer\RobertSerializer'] = $app-> share(function ($app) { return new \RobertSerializer\RobertSerializer(); });


//guzzle
$app['GuzzleHttp\Client'] = $app->share(function($app) {
	return new GuzzleHttp\Client();
});


//twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

//service controller
$app->register(new Silex\Provider\ServiceControllerServiceProvider());

//service controller
$app->register(new Silex\Provider\SessionServiceProvider());


//controllers
/*
$app['controller.api'] = $app['ioc']->instantiate('Starter\Controllers\Api');
$app->post('/api/{team}/{key}',"controller.api:post");
*/

$app->get('/',function() use ($app) {
	return $app['twig']->render('index.html',array('body'=>'main'));	
});

return $app;
