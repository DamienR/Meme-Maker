<?php
  namespace model;

  class Member {
	  private $id;
    private $name;
    private $password;
    private $passwordHash;

    public function __construct($name, $password, $id = null) {	    
      $this->setName($name);
      $this->setPassword($password);
      
			if ($id != null) {
		    $this->id = $id;
	    }
    }
        
    public function getID() {
	    return $this->id;
    }

    public function getName() {
      return $this->name;
    }

    /**
      * Setter for username
      *
      * @param string $name - the name to save
      */
    public function setName($name) {
      $length = mb_strlen($name);

      if ($length < 3) {
        throw new \Exception("Användarnamnet har för få tecken. Minst 3 tecken.");
      } else if ($length > 20) {
        throw new \Exception("Användarnamn för långt.");
      }

      $username = preg_replace('/[^a-z0-9\-_\.]/i', '', $name, -1, $hasInvalid);

      if ($hasInvalid)
        throw new \Exception("Användarnamnet innehåller ogiltiga tecken.");

      $this->name = $name;
    }

    public function getPassword() {
      return $this->password;
    }

    /**
      * Setter for the password
      *
      * @param string $password - The password to save
      */
    public function setPassword($password) {
      $length = mb_strlen($password);

      if ($length < 6)
        throw new \Exception("Lösenorden har för få tecken. Minst 6 tecken.");

      // TODO Encrypt password
      // TODO Check exception

      $this->password = $password;
    }
  }
