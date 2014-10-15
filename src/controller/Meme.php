<?php
  namespace controller;

  require_once("src/model/MemeModel.php");
  require_once("src/model/Meme.php");
  require_once("src/view/Meme.php");

  class Meme {
    private $model;
    private $view;

    public function __construct() {
      $this->model = new \model\MemeModel();
      $this->view  = new \view\Meme();
    }

    public function createMeme() {
      if ($this->view->didUserSubmit()) {
        $memeID = $this->model->generateMeme($this->view->getFormData());
        return $this->view->viewMeme($memeID);
      }

      return $this->view->createMeme();
    }
  }
