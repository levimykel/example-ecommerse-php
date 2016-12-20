<?php

$prismic = $WPGLOBAL['prismic'];
$products = $WPGLOBAL['products'];

$title = SITE_TITLE;
$description = SITE_DESCRIPTION;

?>

<?php include 'partials/header.php'; ?>

<!--<pre><?php //var_dump($products); ?></pre>-->

<div class="product-list container">
  <?php 
    foreach ( $products as $product ) { 
      $image = $product->getImage('product.image');
      $imageURL = $image ? $image->getView('listing')->getUrl() : "";
      $title = $product->getStructuredText('product.title') ? $product->getStructuredText('product.title')->asText() : '';
      $price = $product->getNumber('product.price') ? "$" . $product->getNumber('product.price')->getValue() : '';
  ?>
    <div class="product-list-item">
      <a href="<?= $prismic->linkResolver->resolve($product) ?>">
        
        <img src="<?= $imageURL ?>" class="product-list-image"/>
        <h3 class="product-list-title"><?= $title ?></h3>
        <p class="product-list-price"><?= $price ?></p>
      </a>
    </div>
  <?php } ?>
</div>

<?php include 'partials/footer.php'; ?>
