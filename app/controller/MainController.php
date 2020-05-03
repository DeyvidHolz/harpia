<?php

class MainController
{

  public function index() {
    view('index', ['page_title' => 'Página Inicial - {app_name}']);
  }

}