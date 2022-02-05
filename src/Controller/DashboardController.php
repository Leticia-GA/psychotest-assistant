<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController 
{
    /**
     * @Route("/dashboard", name="dashboard")
     * @IsGranted("ROLE_USER")
     */
    public function index() 
    {
        return $this->render('dashboard/index.html.twig');
    }
}