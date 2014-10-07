<?php
  namespace controller;

  require_once("src/view/Navigation.php");
  //require_once("src/controller/Login.php"); // TBA
  require_once("src/controller/Index.php");

  class Navigation {
    public function doControll() {
      $controller;

      try {
        switch (\view\Navigation::getAction()) {
          case \view\Navigation::$actionAddUser:
            $controller = new \controller\Register();
            return $controller->addUser();
            break;

          case \view\Navigation::$actionLogin:
            $controller = new \controller\Login();
            return $controller->logIn();
            break;

          default:
            $controller = new \controller\Index();
            return $controller->homePage();
            break;
        }
      } catch (\Exception $e) {
        // TODO Add some sort of error handeling
      }
    }
  }
