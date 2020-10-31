<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository; 

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
		$this->repository = $repository;
		$this->em = $em;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     * 
    */
    public function index(): Response
    {
        $properties = $this->repository->findAll();
        
        return $this->render('Admin/property/index.html.twig',[
            'properties'=>$properties
        ]);
	}
	
	/**
	 * @Route("admin/property/create", name="admin.property.new")
	 */
	public function new(Request $request): Response
	{
		$property = new Property();

		$form = $this->createForm(PropertyType::class, $property);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			$this->em->persist($property);
			$this->em->flush();
			return $this->redirectToRoute('admin.property.index');
		}

		return $this->render('Admin/property/new.html.twig', [
			'property'	=> $property,
			'form'		=> $form->createView()
		]);

	}

    /**
     * @Route("/admin/property/{id}", name="admin.property.edit", methods="GET|POST")
     */
    public function edit(Property $property, Request $request): Response
    {
		$form = $this->createForm(PropertyType::class, $property);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			$this->em->flush();
			$this->addFlash('success', 'Bien modifié avec sucès');
			return $this->redirectToRoute('admin.property.index');
		}
        return $this->render('Admin/property/edit.html.twig', [
            'property'=>$property,
            'form'=>$form->createView()
        ]);
	}

	
	/**
	 * @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
	 */
	public function delete(Property $property, Request $request): Response
	{
		$token = $request->get("_token");
		if($this->isCsrfTokenValid('delete' . $property->getId(), $token)){
			$this->em->remove($property);
			$this->em->flush();
			// dump('Suppression');
			// return new Response('Suppression');
		}
		
		return $this->redirectToRoute('admin.property.index');
	}
}
