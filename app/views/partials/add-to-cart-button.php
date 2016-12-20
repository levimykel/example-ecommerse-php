<?php
$itemID = $productContent->getUid();
$itemName = $productTitle ? $productTitle->asText() : "Unknown";
$itemPrice = $price ? $price->getValue() : null;
$itemImage = $image ? $image->getView('snipcart') : null;
$itemImageURL = $itemImage ? $itemImage->getUrl() : null;
$itemWeight = $productContent->getNumber('product.snipcartWeight');
$itemWeightValue = $itemWeight ? $itemWeight->getValue() : null;
$itemDescription = $productContent->getText('product.snipcartDescription');
$itemMaxQuantity = $productContent->getNumber('product.snipcartMaxQuantity');
$itemMaxQuantityProperty = $itemMaxQuantity ? 'data-item-max-quantity=' . $itemMaxQuantity->getValue() : null;

?>

<a href="#" class="button add-to-cart snipcart-add-item" data-item-id="<?= $itemID ?>", data-item-name="<?= $itemName ?>", data-item-price="<?= $itemPrice ?>", data-item-image="<?= $itemImageURL ?>", data-item-weight="<?= $itemWeightValue ?>", data-item-url="<?= $pageUrl ?>", data-item-description="<?= $itemDescription ?>", <?= $itemMaxQuantityProperty ?>>Add To Cart</a>