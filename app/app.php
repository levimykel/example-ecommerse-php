<?php

/*
 * This is the main file of the application, including routing and controllers.
 *
 * $app is a Slim application instance, see the framework documentation for more details:
 * https://www.slimframework.com/
 *
 * The order of the routes matter, as it will define the priority of routes. For that reason we
 * need to keep the more "generic" routes, such as the pages route, at the end of the file.
 *
 * If you decide to change the URLs, make sure to change PrismicLinkResolver in LinkResolver.php
 * as well to make sures links in your site are correctly generated.
 */

use Prismic\Api;
use Prismic\LinkResolver;
use Prismic\Predicates;

require_once 'includes/http.php';

/**
* Connect to the api and query the site layout with all routes
*/
$connect = function ($request, $response, $next) use ($app, $prismic) {
  
  global $WPGLOBAL;
  
  // Connect to the api and set as request variable
  $api = $prismic->get_api();
  $request = $request->withAttribute('api', $api);
  
  // Query the layout content and set as global variable
  $layoutContent = $api->getSingle('layout');
  if (!$layoutContent) 
    $layoutContent = null;
  $WPGLOBAL['layoutContent'] = $layoutContent;

  return $next($request, $response);
};


/**
* For the preview functionality of prismic.io
*/
$app->get('/preview', function ($request, $response) use ($app, $prismic) {
  $token = $request->getParam('token');
  $url = $prismic->get_api()->previewSession($token, $prismic->linkResolver, '/');
  setcookie(Prismic\PREVIEW_COOKIE, $token, time() + 1800, '/', null, false, false);
  return $response->withStatus(302)->withHeader('Location', $url);
});


$app->group('/', function () use ($app) {
  
  /**
  * Homepage Route
  */
  $app->get('', function ($request, $response) use ($app) {
    
    // Query all the products and order by their dates
    $products = $request->getAttribute('api')->query(
      Predicates::at('document.type', 'product'),
      array( 'orderings' => '[my.product.date desc]')
    )->getResults();
    
    // Render the listing page
    render($app, 'listing', array('products' => $products));
  });
  
  
  /**
  * Category Route
  */
  $app->get('category/{uid}', function ($request, $response, $args) use ($app) {
    
    // Retrieve the uid from the url
    $uid = $args['uid'];
    
    // Query the category by its UID
    $category = $request->getAttribute('api')->getByUID('category', $uid);
    
    // Render the 404 page if this category is not found
    if (!$category) {
      not_found($app);
      return;
    }
    
    // Define the category ID 
    $categoryID = $category->getId();
    
    // Query all the products linked to the given category ID and order by their dates
    $products = $request->getAttribute('api')->query([
      Predicates::at('document.type', 'product'),
      Predicates::at('my.product.categories.link', $categoryID)
      ], array( 'orderings' => '[my.product.date desc]')
    )->getResults();
    
    // Render the listing page
    render($app, 'listing', array('products' => $products));
  });
  
  
  /**
  * Product Route
  */
  $app->get('product/{uid}', function ($request, $response, $args) use ($app) {
    
    // Retrieve the uid from the route url
    $uid = $args['uid'];
    
    // Get the page url needed for snipcart
    $host = $request->getUri()->getBaseUrl();
    $pageUrl = $host . '/product/' . $uid;
    
    // Query the product by its UID
    $productContent = $request->getAttribute('api')->getByUID('product', $uid);
    
    // Render the 404 page if this product is not found
    if (!$productContent) {
      not_found($app);
      return;
    }
    
    // Collect all the related product IDs for this product
    $relatedProducts = $productContent->getGroup('product.relatedProducts');
    $relatedArray = $relatedProducts ? $relatedProducts->getArray() : array();
    $relatedIDs = array_map(function($relatedProduct) {
      $link = $relatedProduct->getLink('link');
      return $link ? $link->getId() : null;
    },
    $relatedArray);
    $relatedIDs = array_filter($relatedIDs);
    
    //Query the related products by their IDs
    $relatedProducts = $request->getAttribute('api')->getByIDs($relatedIDs);
    
    // Render the product page
    render($app, 'product', array(
      'productContent' => $productContent, 
      'relatedProducts' => $relatedProducts,
      'pageUrl' => $pageUrl
    ));
  });
  
  
  /**
  * Render 404 for any other route
  */
  $app->get('{url}', function ($request, $response, $args) use ($app) {
    not_found($app);
  });
  
})->add($connect); // Calls the connect function for all the routes