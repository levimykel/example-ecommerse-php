<?php

if (!isset($title)) {
  $title = SITE_TITLE;
}
if (!isset($description)) {
  $description = SITE_DESCRIPTION;
}

$prismic = $WPGLOBAL['prismic'];
$layoutContent = $WPGLOBAL['layoutContent'];

$logo = $layoutContent ? $layoutContent->getImage('layout.logo') : null;
$logoURL = $logo ? $logo->getUrl() : "";

$mainNav = $layoutContent ? $layoutContent->getGroup('layout.mainNav') : null;
$mainNavGroup = $mainNav ? $mainNav->getArray() : []

?>

<!DOCTYPE html(lang='en')>
<html>
  <head>
    <meta content="text/html; Charset=UTF-8" http-equiv="Content-Type" />
    <title><?= $title ?></title>
    <meta name="description" content="<?= $description; ?>">
    <link rel="stylesheet" href="/stylesheets/reset.css"/>
    <link rel="stylesheet" href="/stylesheets/common.css"/>
    <link rel="stylesheet" href="/stylesheets/style.css"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/images/punch.png" />
    <script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
    
    <? /* Required for snipcart integration */ ?>
    <script id="snipcart" src="https://cdn.snipcart.com/scripts/2.0/snipcart.js" data-api-key="<?= SNIPCART_KEY ?>" data-autopop="false"></script>
    <link rel="stylesheet" href="https://cdn.snipcart.com/themes/2.0/base/snipcart.min.css" type="text/css"/>
    <link rel="stylesheet" href="/stylesheets/snipcart-style.css"/>
    
    <? /* Project specifc javascript */ ?>
    <script src="/javascript/functions.js"></script>
    
    <? /* Required for previews and experiments */ ?>
    <script>
      window.prismic = {
        endpoint: '<?= PRISMIC_URL ?>'
      };
    </script>
    <script src="//static.cdn.prismic.io/prismic.js"></script>
  </head>
  <body>
    
    <header>
      <a href="/">
        <?php if ($logo) { ?>
          <img src="<?= $logoURL ?>" class="logo"/>
        <?php } else { ?>
          <span class="logo-text">SiteLogo</span>
        <?php } ?>
      </a>
      <div class="utility-nav">
        <ul>
          <li><a href="#">Help</a>&nbsp|&nbsp</li>
          <li><a href="#">Contact Us</a>&nbsp|&nbsp</li>
          <li>
            <a href="#" class="snipcart-checkout">
              <div class="shopping-cart"></div>
              <div class="snipcart-summary cart-count">
                <span class="snipcart-total-items cart-count-number"></span>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </header>
    
    <nav class="main-nav">
      <?php
      $productTitleText = "This product";
      if (isset($productTitle) && $productTitle != null)
        $productTitleText = $productTitle->asText();
      ?>
      <div class="added-to-cart">
        <p><?= $productTitleText ?> has been added to your cart!</p>
      </div>
      <ul>
        <li><a href="/">Everything</a></li>
        <?php 
          foreach ( $mainNavGroup as $mainLink ) { 
            $mainURL = $mainLink->getLink('link') ? $mainLink->getLink('link')->getUrl($prismic->linkResolver) : null;
            $linkLabel = $mainLink->getText('label');
            if ($mainURL && $linkLabel) {
        ?>
          <li><a href="<?= $mainURL ?>"><?= $linkLabel ?></a></li>
        <?php }} ?>
      </ul>
    </nav>