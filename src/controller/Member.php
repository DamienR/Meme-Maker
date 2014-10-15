<?php
  namespace controller;

  require_once("src/model/DAL/MemberRepository.php");
  require_once("src/model/MemberModel.php");
  require_once("src/view/Member.php");
  require_once("src/helper/Misc.php");

  class Member {
    private $model;
    private $view;
    private $MemberRepository;
    private $misc;

    public function __construct() {
      $this->model = new \model\MemberModel();
      $this->MemberRepository = new \DAL\MemberRepository();
      $this->view   = new \view\Member();
      $this->misc = new \helper\Misc();
    }

    public function addMember() {
      if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
        try {
          $newUser = $this->view->getFormData();

          //$this->MemberRepository->addUser($newUser);

          $this->misc->setAlert("Registrering av ny användare lyckades.");
          //$_SESSION["Member_username"] = $newUser->getName();

          \view\Navigation::redirectHome();
        } catch (\Exception $e) {
          $this->misc->setAlert($e->getMessage());
          return $this->view->getForm();
        }
      } else {
        return $this->view->getForm();
      }
    }

    public function logIn() {
      // Check if user is logged in
      if ($this->model->userIsLoggedIn()) {
        // Check if user pressed log out
        if ($this->view->didUserPressLogout()) {
          // Then log out
          if ($this->model->logOut()) {
            // And then present the login page
            return $this->view->showLogin();
          }
        }

        // Logged in and did not press log out, the show the logout page
        return $this->view->showLogout();
      } else {
        // Check if the user did press log out
        if ($this->view->didUserPressLogout()) {
          // Then show the logout page
          return $this->view->showLogout();
        }

        // Else show the login page
        return $this->view->showLogin();
      }
    }
  }
