<?php
  namespace controller;

  require_once("src/model/UserRepository.php");
  require_once("src/view/Register.php");
  require_once("src/helper/Misc.php");

  class Register {
    private $registerView;
    private $userRepository;
    private $misc;

    public function __construct() {
      $this->userRepository = new \model\UserRepository();
      $this->registerView   = new \view\Register();
      $this->misc = new \helper\Misc();
    }

    public function addUser() {
      if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
        try {
          $newUser = $this->registerView->getFormData();

          //$this->userRepository->addUser($newUser);

          $this->misc->setAlert("Registrering av ny användare lyckades.");
          //$_SESSION["register_username"] = $newUser->getName();

          \view\Navigation::redirectHome();
        } catch (\Exception $e) {
          $this->misc->setAlert($e->getMessage());
          return $this->registerView->getForm();
        }
      } else {
        return $this->registerView->getForm();
      }
    }
  }
