<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class AdminDashboard extends AbstractController{


	/**
	 * @Route("/",  name="admin.dashboard")
	 */
	public function index(): Response
	{
		return $this->render('Admin/index.html.twig', [
			'current_menu' => 'dashboard'
		]);
	}
}
