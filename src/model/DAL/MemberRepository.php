<?php
  namespace DAL;

  require_once("src/model/DAL/Repository.php");
  require_once("src/model/Member.php");

  class MemberRepository extends Repository {
    private static $nameRow = "name";
    private static $passwordRow = "password";

    public function __construct() {
      $this->dbTable = "users";
    }

    /**
      * Add a user to the db
      *
      * @param User $user - the user to save
      */
    public function addUser(User $user) {
      if ($this->getUser($user->getName())) {
        throw new \Exception('Användarnamn är taget.');
      }

      $db = $this->connection();

      $sql = "INSERT INTO $this->dbTable (" . self::$nameRow . ", " . self::$passwordRow . ") VALUES (?, ?)";
		  $params = array($user->getName(), $user->getPassword());

      $query = $db->prepare($sql);
		  $query->execute($params);
    }

    /**
      * Get a user from the db through username
      *
      * @param string $username - the username of the user to get
      * @return User/Boolval - user if success or false if not
      */
    public function getUser($username) {
      $db = $this->connection();

      $sql = "SELECT * FROM $this->dbTable WHERE " . self::$nameRow . " LIKE '%" . $username . "%'";
      $query = $db->prepare($sql);
		  $query->execute();

      if ($query->rowCount() > 0){
        foreach ($query->fetchAll() as $result) {
          $user = new \model\User($result[self::$nameRow], $result[self::$passwordRow]);
          return $user;
        }
      }

      return false;
    }
  }
