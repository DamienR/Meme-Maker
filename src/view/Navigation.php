<?php
  namespace view;

  class Navigation {
    private static $action        = "action";
    public  static $actionIndex   = "index";
    public  static $actionAddUser = "register";
    public  static $actionLogin   = "login";

    public static function getAction() {
      if (isset($_GET[self::$action]))
        return $_GET[self::$action];

      return self::$actionIndex;
    }
  }
