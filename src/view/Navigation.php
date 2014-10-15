<?php
  namespace view;

  class Navigation {
    public  static $action           = "action";
    public  static $actionAddUser    = "register";
    public  static $actionLogin      = "login";
    public  static $actionIndex      = "index";
    public  static $actionCreateMeme = "generate-meme";

    public static function getAction() {
      if (isset($_GET[self::$action]))
        return $_GET[self::$action];

      return self::$actionIndex;
    }
  }
