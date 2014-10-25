<?php
  namespace view;
  
  require_once("src/helper/Misc.php");

  class HTMLView {
	  private $misc;
	  
	  public function __construct() {
      $this->misc = new \helper\Misc();
    }
	  
    /**
      * Creates a HTML page. I blame the indentation
      * on webbrowser and PHP.
      *
      * @param string $title - The page title
      * @param string $body - The middle part of the page
      * @return string - The whole page
      */
    public function echoHTML($title = "Member", $body) {
      if ($body === NULL) {
        throw new \Exception("HTMLView::echoHTML does not allow body to be null.");
      }

      echo "<!doctype html>
<html lang='sv'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <title>" . $title . "</title>

  <link rel='stylesheet' href='css/style.css'>
</head>
<body>
  <div class='container'>
    <header class='row'>
      <div class='col-md-12'>
        <a href='" . \Settings::$ROOT_PATH . "' id='logo'><h1>Meme Maker!</h1></a>
      </div>
    </header>
    
    <span class='alert'>" . $this->misc->getAlert() . "</span>

    <div class='row'>
			" . $body . "
    </div>
    
    <footer class='row'>
			<div class='col-md-12'>
				<nav>
					<a href='" . \Settings::$ROOT_PATH . "'>Meme Maker!</a>
					<a href='#'>Tips &  Tricks</a>
					<a href='#'>Feedback</a>			
				</nav>
			</div>
    </footer>
  </div>
</body>
</html>";
    }
  }
