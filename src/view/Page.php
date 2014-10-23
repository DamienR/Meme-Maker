<?php
  namespace view;

  require_once("src/helper/Misc.php");

  class Page {
    private $misc;

    public function __construct() {
      $this->misc = new \helper\Misc();
    }

    public function startPage() {
      $ret  = "<span class='alert'>" . $this->misc->getAlert() . "</span>";

      // TODO Make function to check if logged in... wait I think I
      //      already have that
      if (isset($_SESSION[\model\MemberModel::$sessionUsername])) {
        $username = $_SESSION[\model\MemberModel::$sessionUsername];
        $ret = "<h2>" . $username . " är inloggad</h2>";
      }

      $ret .= "<a href='?" . Navigation::$action . "=" . Navigation::$actionAddUser . "'>Registrera</a><br />";
      $ret .= "<a href='?" . Navigation::$action . "=" . Navigation::$actionLogin . "'>Logga in</a><br />";
      $ret .= "<a href='?" . Navigation::$action . "=" . Navigation::$actionCreateMeme . "'>Skapa en meme</a><br />";

      return $ret;
    }
  }
