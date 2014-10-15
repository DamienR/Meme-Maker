<?php
  namespace controller;

  require_once("src/model/MemeModel.php");
  require_once("src/view/Meme.php");

  class Meme {
    private $model;
    private $view;

    public function __construct() {
      $this->model = new \model\Meme();
      $this->view  = new \view\Meme();
    }

    public function createMeme() {
      if ($this->view->didUserSubmit()) {
        $this->model->generateMeme($this->view->getFormData());
      }

      return $this->view->createMeme();
    }
  }
