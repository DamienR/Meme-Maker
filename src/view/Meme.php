<?php
  namespace view;

  class Meme {
    private static $fieldTopText 		 = "memeTopText";
    private static $fieldBottomText  = "memeBottomText";
    private static $fieldImage 			 = "memeImage";
    private static $fieldImageUpload = "memeImageUpload";
    public  static $getLocation 		 = "id";
    
    public function getMemeID() {
  		if (isset($_GET[self::$getLocation])) {
  			return $_GET[self::$getLocation];
  		}

  		return NULL;
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
	    $ret  = "<div class='col-md-12 generateMeme'>";

      $ret .= "<form action='?action=" . Navigation::$actionCreateMeme . "' method='post' enctype='multipart/form-data'>";
      
			$ret .= "<div id='imagesContainer'>";
	      // Loop through the image array provided
	      foreach($imagesToChoose as $image) {
	        $ret .= "<div class='col-md-2 image'><input type='radio' name='" . self::$fieldImage . "' id='" . $image . "' value='" . $image . "'><label for='" . $image . "'><img src='" . $image . "'></label></div>";
	      }
      $ret .= "</div>";


      $ret .= "<label for='" . self::$fieldTopText . "'>Top text:</label>";
      $ret .= "<input type='text' name='" . self::$fieldTopText . "' id='" . self::$fieldTopText . "' value='' /><br />";

      $ret .= "<label for='" . self::$fieldBottomText . "'>Bottom text:</label>";
      $ret .= "<input type='text' name='" . self::$fieldBottomText . "' id='" . self::$fieldBottomText . "' value='' /><br />";

      $ret .= "<br><br><label for='" . self::$fieldImageUpload . "'>... OR upload Your own (optional) image file:</label>";
      $ret .= "<input type='file' name='" . self::$fieldImageUpload . "' id='" . self::$fieldImageUpload . "' /><br />";

      $ret .= "<br><input type='submit' value='Skapa' />";
      $ret .= "</form>";
      
      $ret .= "</div>";

      return $ret;
    }

    public function viewMeme(\model\Meme $meme) {
	    $ret  = "<div class='col-md-12 viewMeme'>";
		    $ret .= "<div class='col-md-6'>";
		      $ret .= "<img src='data:image/png;base64," . $meme->getBase64() . "'>";
	      $ret .= "</div>";
	      
	      $ret .= "<div class='col-md-6'>";
	      	$ret .= "<div class='textbox'>";
	      	
	      		$ret .= "<h2>" . $meme->getTopText() . "<br>" . $meme->getBottomText() . "</h2>";
	      		
	      		$ret .= "<button class='btn' id='lol'>LOL!</button>";
	      		
	      		$ret .= "<p id='link'><label><span class=''>Link</span><input class='' type='text' value='http://example.com/?view=test' readonly=''></label></p>";
	      	
	      		$ret .= "<a href='?" . Navigation::$action . "=" . Navigation::$actionCreateMeme . "' id='create'>Make your own</button>";	      	
	      	$ret .= "</div>";
	      $ret .= "</div>";
      $ret .= "</div>";

      return $ret;
    }
  }
