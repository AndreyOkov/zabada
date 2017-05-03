<?php


namespace app\controllers;

use app\models\Departments;


class DepartmentController extends AppController
{
    public function indexAction(){
        $model = new Departments();
        $departments = $model->getDepartments();
        $this->set(compact('departments'));
    }
    public function createAction(){
        $this->view ='_form';
        $type = 'create';
        $this->set(compact('type'));
    }
    public function updateAction($id){
        $this->view ='_form';
        $model = new Departments();
        if(isset($_GET['type'])){
            if($_GET['type']==='update'){
                $post_id = intval($_POST['id']);
                $name = $_POST['name'];
                $model->updateDepartments($post_id,$name);
            } else {
                $model->createDepartments($_POST['name']);
            }
            $this->redirect('/department/index');
        } else {
            $type = 'update';
            $formData = $model->getById($id);
            $this->set(compact('type' , 'formData'));
        }
    }
    
    public function deleteAction($id){
        $model = new Departments();
        $model->deleteDepartment($id);
        $this->redirect('/department/index');
    }

}