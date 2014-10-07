<?php
  namespace view;

  require_once("src/helper/Misc.php");

  class Register {
    private $misc;
    private static $name            = "name";
    private static $password        = "password";
    private static $password_repeat = "password_repeat";

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
  }
