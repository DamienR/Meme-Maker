<?php
  namespace controller;

  require_once("src/model/DAL/MemeRepository.php");
  require_once("src/model/MemeModel.php");
  require_once("src/model/Meme.php");
  require_once("src/view/Meme.php");
  require_once("src/helper/Misc.php");
  
  class Meme {
	  private $memeRepository;
    private $model;
    private $view;
    private $misc;

    public function __construct() {
	    $this->memeRepository = new \DAL\MemeRepository();
      $this->model = new \model\MemeModel();
      $this->view  = new \view\Meme();
      $this->misc = new \helper\Misc();
    }

    public function createMeme() {
      if ($this->view->didUserSubmit()) {
        $meme = $this->view->getFormData();
        $this->model->makeMeme($meme);

				// Save the meme to the db
        if(\Model\MemberModel::userIsLoggedIn()) {
	      	$userID = $_SESSION[\model\MemberModel::$sessionUserID];
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
    
    public function likeMeme() {
	    $id   = $this->view->getMemeID();
	    $meme = $this->memeRepository->getMeme($id);
	    
	    $this->memeRepository->likeMeme($meme);
	    
	    \view\Navigation::redirectToMeme($meme->getID());
    }
    
    public function deleteMeme() {
	    $id   = $this->view->getMemeID();
	    $meme = $this->memeRepository->getMeme($id);
	    
	    if (\Model\MemeModel::canEditMeme($meme->getUserID())) {    
		    $this->memeRepository->deleteMeme($meme);
	    }
	    
	    \view\Navigation::redirectToMeme($meme->getID());
    }
    
    public function viewGallery() {
	    $id       = \View\Member::getMemberID();
	    $memeList = $this->memeRepository->getMembersMemes($id);
	    
	    return $this->view->viewGallery($memeList);
    }
    
    public function uploadImgur() {
	    $id   = $this->view->getMemeID();
	    $meme = $this->memeRepository->getMeme($id);
	    
	    $imgurURL = $this->model->uploadImgur($meme);
	    
	    $this->misc->setAlert("The upload is now at: <a href='" . $imgurURL . "' target='_blank'>" . $imgurURL . "</a>");
	    
	    \view\Navigation::redirectToMeme($meme->getID());
    }
  }
