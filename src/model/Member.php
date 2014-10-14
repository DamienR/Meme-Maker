<?php
  namespace model;

  require_once("src/helper/CookieStorage.php");
  require_once("src/helper/FileStorage.php");
  require_once("src/helper/Misc.php");

  class Member {
    private $cookieStorage;
    private $fileStorage;
    private $misc;
    private static $username = "Admin";
    private static $password = "Password";

    private static $uniqueID        = "Login::UniqueID";
    public  static $sessionUsername = "Login::Username";
    private static $sessionPassword = "Login::Password";

    public function __construct() {
      $this->cookieStorage = new \helper\CookieStorage();
      $this->fileStorage = new \helper\FileStorage();
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

        return false;
      } else if ($this->cookieStorage->isCookieSet(self::$uniqueID)) {
        // Check if cookie is valid
        if ($this->cookieStorage->getCookieValue(self::$uniqueID) === $this->misc->setUniqueID() &&
          $this->cookieStorage->getCookieValue(self::$sessionUsername) === self::$username &&
          $this->cookieStorage->getCookieValue(self::$sessionPassword) === $this->misc->encryptString(self::$password)) {

          // Check if the uniqid cookie is valid
          if (!$this->cookieStorage->isCookieValid($this->cookieStorage->getCookieValue(self::$uniqueID))) {
            // Destroy all cookies
            $this->cookieStorage->destroy(self::$uniqueID);
            $this->cookieStorage->destroy(self::$sessionUsername);
            $this->cookieStorage->destroy(self::$sessionPassword);

            // Set an alert
            $this->misc->setAlert("Felaktig information i cookie.");
            return false;
          }

          // All valid and good? Then log em in
          $this->misc->setAlert("Inloggning lyckades via cookies.");
          return true;
        } else {
          // Destroy all cookies
          $this->cookieStorage->destroy(self::$uniqueID);
          $this->cookieStorage->destroy(self::$sessionUsername);
          $this->cookieStorage->destroy(self::$sessionPassword);

          // Set an alert
          $this->misc->setAlert("Felaktig information i cookie.");
          return false;
        }
      } else {
        return false;
      }
    }

    /**
      * Log in the user
      *
      * @param string $postUsername
      * @param string $postPassword
      * @param string $postRemember - Whether to remember the user or not
      * @return boolval
      */
    public function logIn($postUsername, $postPassword, $postRemember) {
      // Make the inputs safe to use in the code
      $this->misc->makeSafe($postUsername);
      $this->misc->makeSafe($postPassword);

      // Check if the correct username and password is provided
      if($postUsername === self::$username && $postPassword === self::$password) {
        $_SESSION[self::$uniqueID] = $this->misc->setUniqueID();
        $_SESSION[self::$sessionUsername] = $postUsername;

        // If $postRemember got a value the set a cookie
        if ($postRemember) {
          $this->cookieStorage->save(self::$uniqueID, $_SESSION[self::$uniqueID], true);
          $this->cookieStorage->save(self::$sessionUsername, $postUsername);
          $this->cookieStorage->save(self::$sessionPassword, $this->misc->encryptString($postPassword));

          $this->misc->setAlert("Inloggning lyckades och vi kommer ihåg dig nästa gång");
        } else {
          // Not, the just set an alert and go on
          $this->misc->setAlert("Inloggning lyckades");
        }

        return true;
      }

      // If the provided username/password is wrong, check what kind of error the user has made
      if (empty($postUsername)) {
        $this->misc->setAlert("Användarnamn saknas");
        return false;
      } else if (empty($postPassword)) {
        $this->misc->setAlert("Lösenord saknas");
        return false;
      } else if ($postUsername != self::$username XOR $postPassword != self::$password) {
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
      if (isset($_SESSION[self::$uniqueID]) OR
        $this->cookieStorage->isCookieSet(self::$uniqueID)) {
        unset($_SESSION[self::$uniqueID]);

        if ($this->cookieStorage->isCookieSet(self::$uniqueID)) {
          // Destroy all cookies
          $this->cookieStorage->destroy(self::$uniqueID);
          $this->cookieStorage->destroy(self::$sessionUsername);
          $this->cookieStorage->destroy(self::$sessionPassword);

          // Remove the cookie file
          $this->fileStorage->removeFile($this->cookieStorage->getCookieValue(self::$uniqueID));
        }

        // Set alert message
        $this->misc->setAlert("Du har nu loggat ut.");

        return true;
      }
    }
  }
