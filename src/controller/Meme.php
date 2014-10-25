<?php
  namespace controller;

  require_once("src/model/DAL/MemeRepository.php");
  require_once("src/model/MemeModel.php");
  require_once("src/model/Meme.php");
  require_once("src/view/Meme.php");

  class Meme {
	  private $memeRepository;
    private $model;
    private $view;

    public function __construct() {
	    $this->memeRepository = new \DAL\MemeRepository();
      $this->model = new \model\MemeModel();
      $this->view  = new \view\Meme();
    }

    public function createMeme() {
      if ($this->view->didUserSubmit()) {
        $meme = $this->view->getFormData();
        $this->model->makeMeme($meme);

				// Save the meme to the db
        if(\Model\MemberModel::userIsLoggedIn()) {
	      	$userID = 1;
	      } else {
		      $userID = null;
	      }
        
        $this->memeRepository->addMeme($meme, $userID);

        return $this->view->viewMeme($meme);
      }

      $imagesToChoose = $this->model->getImagesToChoose();

      return $this->view->createMeme($imagesToChoose);
    }
    
    public function viewMeme() {
	    $id   = $this->view->getMemeID();
	    $meme = $this->memeRepository->getMeme($id);
	    
	    return $this->view->viewMeme($meme);
    }
  }
