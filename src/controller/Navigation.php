<?php
  namespace controller;

  require_once("src/view/Navigation.php");
  require_once("src/controller/Member.php");
  require_once("src/controller/Meme.php");
  require_once("src/controller/Page.php");

  class Navigation {
    public function doControll() {
      $controller;

      try {
        switch (\view\Navigation::getAction()) {
          // Member
          case \view\Navigation::$actionAddUser:
            $controller = new \controller\Member();
            return $controller->addMember();
            break;

          case \view\Navigation::$actionLogin:
            $controller = new \controller\Member();
            return $controller->logIn();
            break;

          // Memes
          case \view\Navigation::$actionCreateMeme:
            $controller = new \controller\Meme();
            return $controller->createMeme();
            break;

          // Pages
          default:
            $controller = new \controller\Page();
            return $controller->General();
            break;
        }
      } catch (\Exception $e) {
        // TODO Add some sort of error handeling
      }
    }
  }
