<?php
  namespace view;

  class Page {
    public function startPage($memeList) {
	    $ret = "<div class='col-md-12 startPage'>";
	    
			if(\Model\MemberModel::userIsLoggedIn()) {
        $username = $_SESSION[\model\MemberModel::$sessionUsername];
        $ret .= "<div class='col-sm-4 col-md-4'><a href='#' class='callout'>Mitt galleri</a></div>";
        $ret .= "<div class='col-sm-4 col-md-4'><a href='?" . Navigation::$action . "=" . Navigation::$actionCreateMeme . "' class='callout'>Make a meme!</a></div>";
        $ret .= "<div class='col-sm-4 col-md-4'><a href='?" . Navigation::$action . "=" . Navigation::$actionLogout . "' class='callout'>Log out</a></div>";
			} else {
				$ret .= "<div class='col-sm-4 col-md-4'><a href='?" . Navigation::$action . "=" . Navigation::$actionAddUser . "' class='callout'>Register</a></div>";
				$ret .= "<div class='col-sm-4 col-md-4'><a href='?" . Navigation::$action . "=" . Navigation::$actionCreateMeme . "' class='callout prime'>Make a meme!</a></div>";
				$ret .= "<div class='col-sm-4 col-md-4'><a href='?" . Navigation::$action . "=" . Navigation::$actionLogin . "' class='callout'>Log in</a></div>";				
			}
			
			// Loop out the memes
			foreach ($memeList as $meme) {
				echo $meme->getBase64();
	      $ret .= "<div class='col-sm-4 col-md-4 meme'><a href='?" . Navigation::$action . "=" . Navigation::$actionViewMeme . "&" . \view\Meme::$getLocation . "=" . $meme->getID() . "'>
	      <img src='data:image/png;base64," . $meme->getBase64() . "' /></div>";
			}
      
      $ret .= "</div>";

      return $ret;
    }
  }
