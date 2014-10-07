<?php
  namespace controller;

  require_once("src/view/Page.php");

  class Page {
    private $view;

    public function __construct() {
      $this->view = new \view\Page();
    }

    public function general() {
      return $this->view->startPage();
    }
  }
