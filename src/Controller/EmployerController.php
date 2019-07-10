<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EmployerController extends AbstractController
{
    /**
     * @Route("/employer", name="employer")
     */
    public function index()
    {
        return $this->render('employer/index.html.twig', [
            'controller_name' => 'EmployerController',
        ]);
    }
/**
 * @Route("/",name="home")
 */

    public function home(){
        return $this->render('employer/home.html.twig');
    }
 
}
