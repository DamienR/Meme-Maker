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
      
      $ret .= "<div class='col-sm-6 col-md-6'>";
	      $ret .= "<div class='textbox'>";    
	    		$ret .= "<label>Choose a sweet image to the right and fill in the text below:</label>"; 
	    		
					$ret .= "<div class='form-group'>";
			      $ret .= "<input type='text' class='form-control' name='" . self::$fieldTopText . "' id='" . self::$fieldTopText . "' placeholder='TOP ROW' />";
		      $ret .= "</div>";
		
					$ret .= "<div class='form-group'>";
			      $ret .= "<input type='text' class='form-control' name='" . self::$fieldBottomText . "' id='" . self::$fieldBottomText . "' placeholder='BOTTOM ROW' />";
		      $ret .= "</div>";
		      
					$ret .= "<div class='form-group'>";
		  	    $ret .= "<label for='" . self::$fieldImageUpload . "'>... OR upload Your own image file:</label>";
						$ret .= "<input type='file' class='form-control' name='" . self::$fieldImageUpload . "' id='" . self::$fieldImageUpload . "' />";
		      $ret .= "</div>";
		
		      $ret .= "<input type='submit' value='Work your magic!' class='btn btn-default' />";
	      $ret .= "</div>";	      
      $ret .= "</div>";
     
      $ret .= "<div class='col-sm-6 col-md-6'>";
	      $ret .= "<div id='imagesContainer'>";
		      // Loop through the image array provided
		      foreach($imagesToChoose as $image) {
			      $ret .= "<div class='col-sm-6 col-md-4 image'><label><input type='radio' name='" . self::$fieldImage . "' id='" . $image . "' value='" . $image . "'><img src='" . $image . "'></label></div>";
		      }
	      $ret .= "</div>";
			$ret .= "</div>";

      
      $ret .= "</form>";
      
      $ret .= "</div>";

      return $ret;
    }
    
    public function viewGallery($memeList) {
	    $ret = "<div class='col-md-12 startPage'>";
	   	
	   	// Loop out the memes
			foreach (array_reverse($memeList) as $meme) {
	      $ret .= "<div class='col-sm-4 col-md-4 meme'><a href='?" . Navigation::$action . "=" . Navigation::$actionViewMeme . "&" . \view\Meme::$getLocation . "=" . $meme->getID() . "'>
	      <img src='data:image/png;base64," . $meme->getBase64() . "' /></div>";
			}
      
      $ret .= "</div>";

      return $ret; 
    }

    public function viewMeme(\model\Meme $meme) {
	    $linkToPage = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?" . Navigation::$action . "=" . Navigation::$actionViewMeme . "&" . \view\Meme::$getLocation . "=" . $meme->getID();
	    
	    $ret  = "<div class='col-md-12 viewMeme'>";
		    $ret .= "<div class='col-md-6'>";
		      $ret .= "<img src='data:image/png;base64," . $meme->getBase64() . "'>";
	      $ret .= "</div>";
	      
	      $ret .= "<div class='col-md-6'>";
	      	$ret .= "<div class='textbox'>";
	      	
	      		$ret .= "<h2>" . $meme->getTopText() . "<br>" . $meme->getBottomText() . "</h2>";
	      		
	      		$ret .= "<button class='btn' id='lol'>LOL!</button>";
	      		$ret .= "<span id='lols'>:) 22</span>";
	      		
	      		$ret .= "<p id='link'><label><span class=''>Link</span><input class='' type='text' value='" . $linkToPage . "' readonly=''></label></p>";
	      			      		
	      		$ret .= "<div id='share'>";
	      			$ret .= "<a class='btn' href='https://www.facebook.com/sharer/sharer.php?u=" . $linkToPage . "' onclick=\"window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=570,height=280');return false;\">Facebook</a>";
	      			$ret .= "<a class='btn' href='https://twitter.com/home?status=" . $meme->getTopText() . $meme->getBottomText() . " - " . $linkToPage . "' onclick=\"window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=570,height=280');return false;\">Twitter</a>";
	      			$ret .= "<a class='btn' href='?" . Navigation::$action . "=" . Navigation::$actionUploadImgur . "&" . \view\Meme::$getLocation . "=" . $meme->getID() . "'>IMGUR</a>";
	      		$ret .= "</div>";
	      		
	      		$ret .= "<a href='?" . Navigation::$action . "=" . Navigation::$actionCreateMeme . "' id='create'>Make your own Meme</button>";	      	
	      	$ret .= "</div>";
	      $ret .= "</div>";
      $ret .= "</div>";

      return $ret;
    }
  }
