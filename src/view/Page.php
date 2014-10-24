<?php
  namespace view;

  require_once("src/helper/Misc.php");

  class Page {
    private $misc;

    public function __construct() {
      $this->misc = new \helper\Misc();
    }

    public function startPage() {
	    $ret = "<div class='col-md-12 startPage'>";
	    
			if(\Model\MemberModel::userIsLoggedIn()) {
        $username = $_SESSION[\model\MemberModel::$sessionUsername];
        $ret .= "<h2>" . $username . " är inloggad</h2>";
        $ret .= "<a href='?" . Navigation::$action . "=" . Navigation::$actionLogout . "'>Logga ut</a><br>";
			} else {
				$ret .= "<div class='col-sm-4 col-md-4'><a href='?" . Navigation::$action . "=" . Navigation::$actionAddUser . "' class='callout'>Registrera</a></div>";
				$ret .= "<div class='col-sm-4 col-md-4'><a href='?" . Navigation::$action . "=" . Navigation::$actionLogin . "' class='callout'>Logga in</a></div>";				
			}

      $ret .= "<div class='col-sm-4 col-md-4'><a href='?" . Navigation::$action . "=" . Navigation::$actionCreateMeme . "' class='callout'>Skapa en meme</a></div>";
      
      $ret .= "<div class='col-sm-4 col-md-4 meme'><img src='http://placehold.it/500x500'></div>";
      
      $ret .= "<div class='col-sm-4 col-md-4 meme'><img src='http://placehold.it/500x500'></div>";
      
      $ret .= "<div class='col-sm-4 col-md-4 meme'><img src='http://placehold.it/500x500'></div>";
      
      $ret .= "<div class='col-sm-4 col-md-4 meme'><img src='http://placehold.it/500x500'></div>";
      
      $ret .= "<div class='col-sm-4 col-md-4 meme'><img src='http://placehold.it/500x500'></div>";
      
      $ret .= "<div class='col-sm-4 col-md-4 meme'><img src='http://placehold.it/500x500'></div>";
      
      $ret .= "</div>";

      return $ret;
    }
  }
