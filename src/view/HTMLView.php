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
  <title>".$title."</title>
</head>
<body>
  ".$body."
</body>
</html>";
    }
  }
