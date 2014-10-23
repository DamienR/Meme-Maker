<?php
  namespace view;

  require_once("src/helper/Misc.php");

  class Meme {
    private $misc;
    private static $fieldTopText = "memeTopText";
    private static $fieldBottomText = "memeBottomText";
    private static $fieldImage = "memeImage";
    private static $fieldImageUpload = "memeImageUpload";

    public function __construct() {
      $this->misc = new \helper\Misc();
    }

    public function didUserSubmit() {
      if (isset($_POST[self::$fieldTopText]))
        return true;

      return false;
    }

    public function getFormData() {
      // TODO Image upload size validation

      if(file_exists($_FILES[self::$fieldImageUpload]['tmp_name']) || is_uploaded_file($_FILES[self::$fieldImageUpload]['tmp_name'])) {
    		$_POST[self::$fieldImage] = $_FILES[self::$fieldImageUpload]['tmp_name'];
    	}

  		return new \model\Meme($_POST[self::$fieldImage], $_POST[self::$fieldTopText], $_POST[self::$fieldBottomText]);
  	}

    public function createMeme($imagesToChoose) {
      $ret  = "<fieldset>";
      $ret .= "<legend>Skapa en meme</legend>";

      $ret .= "<span class='alert'>" . $this->misc->getAlert() . "</span>";

      $ret .= "<form action='?action=" . Navigation::$actionCreateMeme . "' method='post' enctype='multipart/form-data'>";
      $ret .= "<label for='" . self::$fieldTopText . "'>Top text:</label>";
      $ret .= "<input type='text' name='" . self::$fieldTopText . "' id='" . self::$fieldTopText . "' value='' /><br />";

      $ret .= "<label for='" . self::$fieldBottomText . "'>Bottom text:</label>";
      $ret .= "<input type='text' name='" . self::$fieldBottomText . "' id='" . self::$fieldBottomText . "' value='' /><br />";

      // Loop through the image array provided
      foreach($imagesToChoose as $image) {
        $ret .= "<input type='radio' name='" . self::$fieldImage . "' id='" . $image . "' value='" . $image . "'><label for='" . $image . "'><img src='" . $image . "'></label>";
      }

      $ret .= "<br><br><label for='" . self::$fieldImageUpload . "'>... OR upload Your own (optional) image file:</label>";
      $ret .= "<input type='file' name='" . self::$fieldImageUpload . "' id='" . self::$fieldImageUpload . "' /><br />";

      $ret .= "<br><input type='submit' value='Skapa' />";
      $ret .= "</form>";
      $ret .= "</fieldset>";

      return $ret;
    }

    public function viewMeme(\model\Meme $meme) {
      $ret = "<img alt='Embedded Image' src='data:image/png;base64," . $meme->getBase64() . "' />";

      // TODO Add share links

      return $ret;
    }
  }