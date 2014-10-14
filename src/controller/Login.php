<?php
  namespace controller;

  require_once("src/model/Member.php");
  require_once("src/view/Member.php");
  require_once("src/helper/Misc.php");

  class Member {
    private $model;
    private $view;
    private $misc;

    public function __construct() {
      $this->model = new \model\Member();
      $this->view = new \view\Member($this->model);
      $this->misc = new \helper\Misc();
    }


  }
