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
        $meme = $this->view->getFormData();
        $this->model->makeMeme($meme);

        // TODO Save the file to db

        return $this->view->viewMeme($meme);
      }

      return $this->view->createMeme();
    }
  }
