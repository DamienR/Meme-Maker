<?php
  namespace DAL;

  require_once("src/model/DAL/Repository.php");
  require_once("src/model/Meme.php");

  class MemeRepository extends Repository {
    private static $userIDRow 		= "userID";
	  private static $imageRow 			= "image";
    private static $topTextRow	  = "topText";
    private static $bottomTextRow = "bottomText";
    private static $base64Row 		= "base64";

    public function __construct() {
      $this->dbTable = "memes";
    }

    /**
      * Add a meme to the db
      *
      * @param Meme $meme - the meme to save
      * @param int $userID
      */
    public function addMeme(\model\Meme $meme, $userID) {	    	    
      $db = $this->connection();

      $sql = "INSERT INTO $this->dbTable (" . self::$userIDRow . ", " . self::$imageRow . ", " . self::$topTextRow . ", " . self::$bottomTextRow . ", " . self::$base64Row . ") VALUES (?, ?, ?, ?, ?)";
		  $params = array($userID, $meme->getImage(), $meme->getTopText(), $meme->getBottomText(), $meme->getBase64());

      $query = $db->prepare($sql);
		  $query->execute($params);
    }
  }
