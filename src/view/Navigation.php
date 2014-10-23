<?php
  namespace view;

  class Navigation {
    public  static $action           = "action";
    public  static $actionAddUser    = "register";
    public  static $actionLogin      = "login";
    public  static $actionIndex      = "index";
    public  static $actionCreateMeme = "generate-meme";

    /**
      * Gets the action that the user wants
      */
    public static function getAction() {
      if (isset($_GET[self::$action]))
        return $_GET[self::$action];

      return self::$actionIndex;
    }

    /**
      * Redirects the user home (home set in settings file)
      */
    public static function redirectHome() {
      header('Location: ' . \Settings::$ROOT_PATH);
    }
  }
