<?php
  namespace model;

  class Member {
    private $name;
    private $password;
    private $passwordHash;

    public function __construct($name, $password) {
      $this->setName($name);
      $this->setPassword($password);
    }

    /**
      * Getter for username
      *
      * @return string - username
      */
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

    /**
      * Getter for the password
      *
      * @return string - the password
      */
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

    /**
      * A simple check if the password in the Member is
      * the same as in db.
      *
      * @param string $password - The password submitted
      * @return boolval
      */
    public function verifyPassword($password) {
      if ($password === $this->password)
        return true;

      return false;
    }
  }
