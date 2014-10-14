<?php
  namespace view;

  require_once("src/helper/Misc.php");

  class Member {
    private $misc;
    private static $name            = "name";
    private static $password        = "password";
    private static $password_repeat = "password_repeat";
    private static $getLogin = "login";
    private static $getLogout = "logout";

    public function __construct() {
      $this->misc = new \helper\Misc();
    }

    /**
      * Gets the formdata that's posted
      *
      * @return User/null - depends if sucess or not
      */
    public function getFormData() {
  		if (isset($_POST[self::$name])) {
        if ($_POST[self::$password] !== $_POST[self::$password_repeat]) {
            throw new \Exception("Lösenorden matchar inte.");
        }

  			return new \model\User($_POST[self::$name], $_POST[self::$password]);
  		}

  		return null;
  	}

    /**
      * Get the form for the registration
      *
      * @return string (HTML) - the form
      */
    public function getForm() {
      $name = isset($_POST[self::$name]) ? preg_replace('/[^a-z0-9\-_\.]/i', '', $_POST[self::$name]) : '';

      $html  = "<h3>Ej Inloggad, Registrerar användare</h3>";
      $html .= "<fieldset>";
      $html .= "<legend>Registrera ny användare</legend>";

      $html .= "<span class='alert'>" . $this->misc->getAlert() . "</span>";

  		$html .= "<form action='?action=" . Navigation::$actionAddUser . "' method='post'>";
      $html .= "<label for='" . self::$name . "'>Namn:</label>";
  		$html .= "<input type='text' name='" . self::$name . "' id='" . self::$name . "' value='" . $name . "' /><br />";

      $html .= "<label for='" . self::$password . "'>Lösenord:</label>";
      $html .= "<input type='password' name='" . self::$password . "' id='" . self::$password . "' /><br />";

      $html .= "<label for='" . self::$password_repeat . "'>Repetera lösenord:</label>";
      $html .= "<input type='password' name='" . self::$password_repeat . "' id='" . self::$password_repeat . "' /><br />";

  		$html .= "<input type='submit' value='Registrera' />";
  		$html .= "</form>";
      $html .= "</fieldset>";

  		return $html;
    }

    /**
      * A view for users not logged in
      *
      * @return string - The page log in page
      */
    public function showLogin() {
      $username = empty($_POST['username']) ? '' : $_POST['username'];

      $ret = "<span class='alert'>" . $this->misc->getAlert() . "</span>";

      $ret .= "
  <form action='?action=" . Navigation::$actionLogin . "' method='post'>
    <input type='text' name='username' placeholder='Användarnamn' value='".$username."'>
    <input type='password' name='password' placeholder='Lösenord' value=''>
    <label for='remember'>Håll mig inloggad:</label>
    <input type='checkbox' id='remember' name='remember'>
    <input type='submit' value='Logga in' name='login'>
  </form>";

      return $ret;
    }

    /**
      * Checks if user submitted the form
      *
      * @return boolval
      */
    public function didUserPressLogin() {
      if (isset($_GET[self::$getLogin])) {
        if (isset($_POST['username'])) {
          if ($this->model->logIn($_POST['username'], $_POST['password'], isset($_POST['remember']))) {
            return true;
          }
        }
      }

      return false;
    }

    /**
      * Checks if pressed log out
      *
      * @return boolval
      */
    public function didUserPressLogout() {
      if (isset($_GET[self::$getLogout]))
        return true;

      return false;
    }
  }
