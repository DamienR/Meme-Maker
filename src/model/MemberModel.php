<?php
  namespace model;

  require_once("src/model/DAL/MemberRepository.php");
  require_once("src/helper/Misc.php");

  class MemberModel {
    private $memberRepository;
    private $misc;
    private static $username = "Admin";
    private static $password = "Password";

    private static $uniqueID        = "Login::UniqueID";
    public  static $sessionUsername = "Login::Username";

    public function __construct() {
      $this->memberRepository = new \DAL\MemberRepository();
      $this->misc = new \helper\Misc();
    }

    /**
      * Checks if user is logged in.
      *
      * @return boolval - Either the user is logged in or not
      */
    public static function userIsLoggedIn() {
      if (isset($_SESSION[self::$uniqueID])) {
        // Check if session is valid
        //if ($_SESSION[self::$uniqueID] === $this->misc->setUniqueID()) {
          return true;
        //}
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
      // Get the database member
      $memberDB = $this->memberRepository->getMember($member->getName());

      // Can't find hen? Then false it!
      if (!$memberDB) {
        return false;
      }

      // Make the inputs safe to use in the code
      $username   = $this->misc->makeSafe($member->getName());
      $password   = $this->misc->makeSafe($member->getPassword());
      $usernameDB = $this->misc->makeSafe($memberDB->getName());
      $passwordDB = $this->misc->makeSafe($memberDB->getPassword());


      // Check if the correct password is provided
      if($passwordDB === $password) {
        $_SESSION[self::$uniqueID] = $this->misc->setUniqueID();
        $_SESSION[self::$sessionUsername] = $usernameDB;

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
        session_unset();
        session_destroy();

        // Set alert message
        $this->misc->setAlert("Du har nu loggat ut.");

        return true;
      }
    }
  }
