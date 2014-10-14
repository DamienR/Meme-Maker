<?php
  namespace view;

  class Page {
    public function startPage() {
      $ret  = "<a href='?" . Navigation::$action . "=" . Navigation::$actionAddUser . "'>Registrera</a><br />";
      $ret .= "<a href='?" . Navigation::$action . "=" . Navigation::$actionLogin . "'>Logga in</a><br />";

      return $ret;
    }
  }
