<?php

namespace app\controllers;

use app\models\Main;

class MainController extends AppController
{
    public function indexAction(){
        $model = new Main();
        $data = $model->getDepsToEmployees();
        $this->set($data);
    }
}