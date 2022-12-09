<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Repository\AdminRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    #[IsGranted("ROLE_USER")]
    public function index(): Response
    {
        $admin=$this->getUser();
        return $this->render('home/index.html.twig', [
            'admin'=>$admin,
            'controller_name' => 'HomeController',
        ]);
    }

}
