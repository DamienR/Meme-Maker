<?php
  namespace model;

  class Meme {
	  private $id;
    private $topText;
    private $bottomText;
    private $image;
    private $base64;

    public function __construct($image, $topText, $bottomText) {
      // TODO Validation
      
      $this->image = $image;
      $this->topText = $topText;
      $this->bottomText = $bottomText;
    }

		public function setID($id) {
			$this->id = $id;
		}
		
		public function getID() {
			return $this->id;
		}

    public function getTopText() {
      return $this->topText;
    }

    public function getBottomText() {
      return $this->bottomText;
    }


    public function getImage() {
      return $this->image;
    }

    public function setBase64($data) {
      $this->base64 = $data;
    }

    public function getBase64() {
      return $this->base64;
    }
  }
