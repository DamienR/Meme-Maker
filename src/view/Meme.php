<?php
  namespace view;

  require_once("src/helper/Misc.php");

  class Meme {
    private $misc;
    private static $fieldText = "memeText";
    private static $fieldImage = "memeImage";

    public function __construct() {
      $this->misc = new \helper\Misc();
    }

    public function didUserSubmit() {
      if (isset($_POST[self::$fieldText]))
        return true;

      return false;
    }

    public function createMeme() {
      $ret  = "<fieldset>";
      $ret .= "<legend>Skapa en meme</legend>";

      $ret .= "<span class='alert'>" . $this->misc->getAlert() . "</span>";

      $ret .= "<form action='?action=" . Navigation::$actionCreateMeme . "' method='post'>";
      $ret .= "<label for='" . self::$fieldText . "'>Text:</label>";
      $ret .= "<input type='text' name='" . self::$fieldText . "' id='" . self::$fieldText . "' value='' /><br />";

      $ret .= "<label for='" . self::$fieldImage . "'>Bild: (1, 2, 3)</label>";
      $ret .= "<input type='password' name='" . self::$fieldImage . "' id='" . self::$fieldImage . "' /><br />";

      $ret .= "<input type='submit' value='Skapa' />";
      $ret .= "</form>";
      $ret .= "</fieldset>";

      return $ret;
    }
  }
