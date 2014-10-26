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
	    // TODO Remove this
      if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
        try {
          $newMember = $this->view->getFormData();

          $this->MemberRepository->addMember($newMember);

          $this->misc->setAlert("Registrering av ny användare lyckades.");

          $this->model->logIn($newMember);

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
      if ($this->view->didMemberPressLogin()) {
        // Get the form data and log the user in
        $member = $this->view->getFormData();
        $this->model->logIn($member);

        // Redirect home
        \view\Navigation::redirectHome();
      }

      // Else show the login page
      return $this->view->showLogin();
    }

    public function logOut() {
      $this->model->logOut();

      \view\Navigation::redirectHome();
    }
  }
