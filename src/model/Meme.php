<?php
  namespace model;

  class Meme {
    private $text;
    private $imageName;

    public function __construct($text, $imageName) {
      $this->text = $text;
      $this->imageName = $imageName;
    }

    public function getText() {
      return $this->text;
    }

    public function getImageName() {
      return $this->imageName;
    }
  }
