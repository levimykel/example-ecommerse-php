<?php

$prismic = $WPGLOBAL['prismic'];
$productContent = $WPGLOBAL['productContent'];
$relatedProducts = $WPGLOBAL['relatedProducts'];
$pageUrl = $WPGLOBAL['pageUrl'];

$title = SITE_TITLE;
$description = SITE_DESCRIPTION;

$image = $productContent->getImage('product.image');
$imageURL = $image ? $image->getUrl() : "";

$productTitle = $productContent->getStructuredText('product.title');
$productTitleHtml = $productTitle ? $productTitle->asHtml($prismic->linkResolver) : "";
  
$price = $productContent->getNumber('product.price');
$priceDisplay = $price ? "$" . $price->getValue() : '';
  
$productDescription = $productContent->getStructuredText('product.description');
$productDescriptionHtml = $productDescription ? $productDescription->asHtml($prismic->linkResolver) : "";

//function debug_to_console( $data ) {
//  if ( is_array( $data ) )
//    $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
//  elseif ( is_object( $data ) )
//    $output = var_dump( $data );
//  else
//    $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
//  echo $output;
//}
//debug_to_console( $productTitleText );

?>

<?php include 'partials/header.php'; ?>

<!--<pre><?php //var_dump($products); ?></pre>-->

<div class="container product-details">
  <div class="product-image">
    <img src="<?= $imageURL ?>"/>
  </div>
  <div class="product-info">
    <?= $productTitleHtml ?>
    <p class="product-price">
      <?= $priceDisplay ?>
    </p>
    <div class="product-description">
      <?= $productDescriptionHtml ?>
    </div>
    
    <?php include 'partials/add-to-cart-button.php'; ?>
    
  </div>
</div>

<?php if ( $relatedProducts->getTotalResultsSize() > 0 ) { ?>
<div class="container recommended">
  <h2>Recommended</h2>
  <div class="recommended-wrapper">
    <?php 
    foreach ( $relatedProducts->getResults() as $relatedProduct ) { 
      $relatedImage = $relatedProduct->getImage('product.image');
      $relatedImageURL = $relatedImage ? $relatedImage->getView('listing')->getUrl() : "";
      $relatedTitle = $relatedProduct->getStructuredText('product.title');
      $relatedTitleHtml = $relatedTitle ? $relatedTitle->asText() : "";
      $relatedPrice = $relatedProduct->getNumber('product.price')->getValue();
      $relatedPriceDisplay = $relatedPrice ? "$" . $relatedPrice : '';
    ?>
    <div class="recommended-product">
      <a href="<?= $prismic->linkResolver->resolve($relatedProduct) ?>">
        <img src="<?= $relatedImageURL ?>" class="recommended-image"/>
        <p class="recommended-title"><?= $relatedTitleHtml ?></p>
        <p class="recommended-price"><?= $relatedPriceDisplay ?></p>
      </a>
    </div>
    <?php } ?>
  </div>
</div>
<?php } ?>

<?php include 'partials/footer.php'; ?>
