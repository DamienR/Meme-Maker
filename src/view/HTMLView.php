<?php
  namespace view;

  class HTMLView {
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
    <div class='row'>
      <div class='col-md-12'>
        <a href='/' id='logo'><h1>Meme Maker!</h1></a>
      </div>
    </div>

    <div class='row'>
      <div class='col-md-12'>
        " . $body . "
      </div>
    </div>
  </div>
</body>
</html>";
    }
  }
