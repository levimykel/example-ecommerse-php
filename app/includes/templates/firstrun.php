<!DOCTYPE html(lang='en')>
<html>
  <head>
    <meta content="text/html; Charset=UTF-8" http-equiv="Content-Type" />
    <title>prismic.io Sample eCommerce Site in PHP</title>
    <meta name="description" content="This is the PHP sample eCommerce project for prismic.io">
    <link rel="stylesheet" href="/stylesheets/reset.css"/>
    <link rel="stylesheet" href="/stylesheets/common.css"/>
    <link rel="stylesheet" href="/stylesheets/style.css"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/images/punch.png" />
    <script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="/javascript/functions.js"></script>
  </head>
  <body>
    
    <header>
      <a href="/">
        <span class="logo-text">SiteLogo</span>
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
      <ul>
        <li><a href="/">Everything</a></li>
      </ul>
    </nav>
    
    <div class="container">
      <h1>You're almost there!</h1>
      <p>Update the prismic url in your config.php file to connect to your repository.</p>
    </div>

    <footer>
      <div class="footer-nav">
        <ul>
          <li> <a href="#">About Us</a></li>
          <li> <a href="#">Customer Service</a></li>
          <li> <a href="#">Privacy Policy</a></li>
        </ul>
      </div>
      <div class="copywrite">
        <p>© <?php echo date("Y"); ?> UNKNOW </p>
      </div>
    </footer>
  </body>
</html>