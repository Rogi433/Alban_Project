<?php
// src/Controller/DefaultController.php

namespace App\Controller;

use DefaultView;
use DefaultModel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;

class DefaultController{
    private $model;
    private $view;

    public function __construct(){
        $this->model = new DefaultModel();
        $this->view = new DefaultView();
    }

    /**
     * @Route("/hello/{name}", methods={"GET"})
     */
    public function hello($name){
        return new Response("Hello $name");
    }

    /**
     * @Route("/", name="Index")
     */
    public function index(){
        return new Response($this->view->output($this->model->information));
    }

    /**
     * @Route("/delete", name="Delete_Organisation", methods={"GET"})
     */
    public function delete(Request $request, LoggerInterface $logger){
        if($request->query->get('uname')){
            $status = $this->model->delete($request->query->get('name'), $request->query->get('uname'));
        }else{
            $status = $this->model->delete($request->query->get('name'));
        }

        if($status){
            $logger->info('Organization or User WAS deleted successfully!');
        }else{
            $logger->info('Organization or User WAS NOT found, thus NOT deleted!');
        }

        return $this->index();
    }

    /**
     * @Route("/modify", name="Modify_Organisations", methods={"GET"})
     */
    public function modify(Request $request, LoggerInterface $logger){
        if($request->query->get('name')){
            if($request->query->get('uname')){
                $users = array('name'=>$request->query->get('uname'), 'role'=>explode(" ", $request->query->get('urole')), 'password'=>$request->query->get('upass'));
            }else{
                $users = false;
            }

            $status = $this->model->modify_organisation($request->query->get('name'), $request->query->get('description'), $users);

            if($status){
                $logger->info('Organization' . $request->query->get('name') . 'updated!');
            }else{
                $logger->info('Organization added!');
            }
        }else{
            $logger->info('Organizations couldn\'t be updated. Missing name!');
        }

        return $this->index();
    }
}


