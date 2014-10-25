<?php
  namespace view;

  require_once("src/helper/Misc.php");

  class Member {
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
        // Check if the form post is from register form
        if (isset($_POST[self::$password_repeat])) {
          if ($_POST[self::$password] !== $_POST[self::$password_repeat]) {
              throw new \Exception("Lösenorden matchar inte.");
          }
        }
        
  			return new \model\Member($_POST[self::$name], $_POST[self::$password]);
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
      
      $ret  = "<div class='col-md-12 viewMeme'>";
		    $ret .= "<div class='col-md-6'>";
					$ret .= "<form action='?action=" . Navigation::$actionAddUser . "' method='post' role='form'>";
					
					$ret .= "<div class='form-group'>";
						$ret .= "<label for='" . self::$name . "'>Your name:</label>";
						$ret .= "<input type='text' class='form-control' name='" . self::$name . "' id='" . self::$name . "' value='" . $name . "' />";
					$ret .= "</div>";

					$ret .= "<div class='form-group'>";
			      $ret .= "<label for='" . self::$password . "'>A secure password:</label>";
						$ret .= "<input type='password' class='form-control' name='" . self::$password . "' id='" . self::$password . "' />";
					$ret .= "</div>";
					
					$ret .= "<div class='form-group'>";
			      $ret .= "<label for='" . self::$password_repeat . "'>And that password one more time:</label>";
			      $ret .= "<input type='password' class='form-control' name='" . self::$password_repeat . "' id='" . self::$password_repeat . "' />";
					$ret .= "</div>";
		
		  		$ret .= "<input type='submit' value='Sign me up!' class='btn btn-default' />";
		  		$ret .= "</form>"; 		
	      $ret .= "</div>";
	      
	      $ret .= "<div class='col-md-6'>";
	      	$ret .= "<h3>Another member? Nice!</h3>";
	      	$ret .= "<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>";
	      $ret .= "</div>";
      $ret .= "</div>";
      

  		return $ret;
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
    <input type='text' name='" . self::$name . "' placeholder='Användarnamn' value='".$username."'>
    <input type='password' name='" . self::$password . "' placeholder='Lösenord' value=''>
    <input type='submit' value='Logga in' name='login'>
  </form>";

      return $ret;
    }

    /**
      * Checks if user submitted the form
      *
      * @return boolval
      */
    public function didMemberPressLogin() {
      if (isset($_POST[self::$name]))
        return true;

      return false;
    }

    /**
      * Checks if pressed log out
      *
      * @return boolval
      */
    public function didMemberPressLogout() {
      if (isset($_GET[self::$getLogout]))
        return true;

      return false;
    }
  }
