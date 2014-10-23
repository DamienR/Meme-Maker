<?php
  namespace model;

  require_once("src/helper/Misc.php");

  class MemberModel {
    private $fileStorage;
    private $misc;
    private static $username = "Admin";
    private static $password = "Password";

    private static $uniqueID        = "Login::UniqueID";
    public  static $sessionUsername = "Login::Username";

    public function __construct() {
      $this->misc = new \helper\Misc();
    }

    /**
      * Checks if user is logged in.
      *
      * @return boolval - Either the user is logged in or not
      */
    public function userIsLoggedIn() {
      if (isset($_SESSION[self::$uniqueID])) {
        // Check if session is valid
        if ($_SESSION[self::$uniqueID] === $this->misc->setUniqueID()) {
          return true;
        }
      }

      return false;
    }

    /**
      * Log in the user
      *
      * @param string $postUsername
      * @param string $postPassword
      * @param string $postRemember - Whether to remember the user or not
      * @return boolval
      */
    public function logIn(\Model\Member $member) {
      // Make the inputs safe to use in the code
      $username = $this->misc->makeSafe($member->getName());
      $password = $this->misc->makeSafe($member->getPassword());

      // Check if the correct username and password is provided
      if($username === self::$username && $password === self::$password) {
        $_SESSION[self::$uniqueID] = $this->misc->setUniqueID();
        $_SESSION[self::$sessionUsername] = $username;

        // Set an alert and go on
        $this->misc->setAlert("Inloggning lyckades");

        return true;
      }

      // If the provided username/password is wrong, check what kind of error the user has made
      if (empty($username)) {
        $this->misc->setAlert("Användarnamn saknas");
        return false;
      } else if (empty($password)) {
        $this->misc->setAlert("Lösenord saknas");
        return false;
      } else if ($username != self::$username XOR $password != self::$password) {
        $this->misc->setAlert("Felaktigt användarnamn och/eller lösenord");
        return false;
      } else {
        $this->misc->setAlert("Ett fel inträffade. Försök igen.");
        return false;
      }
    }

    /**
      * Log out the user
      *
      * @return boolval
      */
    public function logOut() {
      // Check if you really are logged in
      if (isset($_SESSION[self::$uniqueID])) {
        unset($_SESSION[self::$uniqueID]);

        // Set alert message
        $this->misc->setAlert("Du har nu loggat ut.");

        return true;
      }
    }
  }
