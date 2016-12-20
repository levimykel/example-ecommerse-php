<?php

require_once '../vendor/autoload.php';
require_once '../app/LinkResolver.php';
require_once '../app/includes/PrismicHelper.php';
require_once '../config.php';

// If the prismic API Endpoint needs to be updated, show a message to update it
if (PRISMIC_URL == 'https://your-repo-name.prismic.io/api') {
  include '../app/includes/templates/firstrun.php';
  exit();
}

// Initialize the Slim & prismic apps
$composer = json_decode(file_get_contents(__DIR__.'/../composer.json'));
$config = ['settings' => [
  'version'        => $composer->version,
  'prismic.url'    => PRISMIC_URL,
  'prismic.token'  => PRISMIC_TOKEN,
  'snipcart.key'  => SNIPCART_KEY,
  'site.title'     => SITE_TITLE,
  'site.description' => SITE_DESCRIPTION,
  'displayErrorDetails' => DISPLAY_ERROR_DETAILS,
]];
$app = new \Slim\App($config);
$prismic = new PrismicHelper($app);

global $WPGLOBAL;
$WPGLOBAL = array(
  'app' => $app,
  'prismic' => $prismic,
);

function validateOnboarding($app) {
  $API_ENDPOINT = $app->getContainer()->get('settings')['prismic.url'];
  $repoEndpoint = str_replace("/api", "", $API_ENDPOINT);
  $url = $repoEndpoint . '/app/settings/onboarding/run';
  $x = curl_init();
  curl_setopt($x, CURLOPT_URL,$url);
  curl_setopt($x, CURLOPT_POST,1);
  curl_setopt($x, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($x, CURLOPT_POSTFIELDS, array());
  curl_exec($x);
  curl_close ($x);
}

validateOnboarding($app);

// Launch the app
require_once __DIR__.'/../app/app.php';
$app->run();
