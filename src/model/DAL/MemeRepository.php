<?php
  namespace DAL;

  require_once("src/model/DAL/Repository.php");
  require_once("src/model/Meme.php");

  class MemeRepository extends Repository {
    private static $idRow 				= "id";
    private static $userIDRow 		= "userID";
    private static $likesRow   		= "likes";
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
    
    public function getMeme($id) {
  		$db = $this->connection();

  		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$idRow . " = ?";
  		$params = array($id);

  		$query = $db->prepare($sql);
  		$query->execute($params);

  		$result = $query->fetch();

  		if ($result) {
	  		$meme = new \model\Meme($result[self::$imageRow], $result[self::$topTextRow], $result[self::$bottomTextRow]);
	  		$meme->setID($result[self::$idRow]);
	  		$meme->setUserID($result[self::$userIDRow]);
	  		$meme->setLikes($result[self::$likesRow]);
	  		$meme->setBase64($result[self::$base64Row]);
	  		
  			return $meme;
  		}
  	}
  	
  	public function likeMeme(\model\Meme $meme) {
  		$db = $this -> connection();
			
  		$sql = "UPDATE $this->dbTable SET " . self::$likesRow . " =  " . self::$likesRow . " + 1 WHERE " . self::$idRow . " = ?";
  		$params = array($meme->getID());

  		$query = $db->prepare($sql);
  		$query->execute($params);
  	}
  	
  	public function deleteMeme(\model\Meme $meme) {
  		$db = $this -> connection();

  		$sql = "DELETE FROM $this->dbTable WHERE " . self::$idRow . " = ?";
  		$params = array($meme->getID());

  		$query = $db->prepare($sql);
  		$query->execute($params);
  	}
    
    public function getAllMemes() {
      $db = $this->connection();

      $sql = "SELECT * FROM $this->dbTable";

      $query = $db->prepare($sql);
      $query->execute();
     
      $memeList = array();
     
      foreach($query->fetchAll() as $meme){
	      $id 			  = $meme[self::$idRow];
	      $userID     = $meme[self::$userIDRow];
	      $likes      = $meme[self::$likesRow];
        $image 			= $meme[self::$imageRow];
        $topText 		= $meme[self::$topTextRow];
        $bottomText = $meme[self::$bottomTextRow];
        $base64 		= $meme[self::$base64Row];

        $meme = new \model\Meme($image, $topText, $bottomText);
        $meme->setID($id);
        $meme->setUserID($userID);
        $meme->setLikes($likes);
        $meme->setBase64($base64);

        $memeList[] = $meme;
      }

      return $memeList;
    }
    
    public function getMembersMemes($id) {
      $db = $this->connection();

      $sql = "SELECT * FROM $this->dbTable WHERE " . self::$userIDRow . " = ?";
      $params = array($id);

      $query = $db->prepare($sql);
      $query->execute($params);

      $memeList = array();
     
      foreach($query->fetchAll() as $meme){
	      $id 			  = $meme[self::$idRow];
	      $userID     = $meme[self::$userIDRow];
	      $likes      = $meme[self::$likesRow];
        $image 			= $meme[self::$imageRow];
        $topText 		= $meme[self::$topTextRow];
        $bottomText = $meme[self::$bottomTextRow];
        $base64 		= $meme[self::$base64Row];

        $meme = new \model\Meme($image, $topText, $bottomText);
        $meme->setID($id);
        $meme->setUserID($userID);
        $meme->setLikes($likes);
        $meme->setBase64($base64);

        $memeList[] = $meme;
      }

      return $memeList;
    }
  }
