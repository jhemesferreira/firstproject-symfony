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
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/admin/property")
 */
class AdminPropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository; 

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em, ValidatorInterface $validator)
    {
		$this->repository = $repository;
		$this->em = $em;
		$this->validator = $validator;
    }

    /**
     * @Route("/", name="admin.property.index")
     * 
    */
    public function index(): Response
    {
        $properties = $this->repository->findAll();
        
        return $this->render('Admin/property/index.html.twig',[
			'properties'=>$properties,
			'current_menu' => 'property'
        ]);
	}
	
	/**
	 * @Route("/property/new", name="admin.property.new")
	 */
	public function new(Request $request): Response
	{
		$property = new Property();

		// $errors = $this->validator->validate($property);
		
		$form = $this->createForm(PropertyType::class, $property);
		$form->handleRequest($request);

		

		

		if($form->isSubmitted() && $form->isValid()){
			$this->em->persist($property);
			$this->em->flush();
			$this->addFlash('success', 'Le bien a été créé avec succès');
			return $this->redirectToRoute('admin.property.index');
		}

		return $this->render('Admin/property/new.html.twig', [
			'property'	=> $property,
			'form'		=> $form->createView()
		]);

	}

    /**
     * @Route("/property/{id}", name="admin.property.edit", methods="GET|POST")
     */
    public function edit(Property $property, Request $request): Response
    {
		$form = $this->createForm(PropertyType::class, $property);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			$this->em->flush();
			$this->addFlash('success', 'Le bien a été modifié avec succès');
			return $this->redirectToRoute('admin.property.index');
		}
        return $this->render('Admin/property/edit.html.twig', [
            'property'=>$property,
            'form'=>$form->createView()
        ]);
	}

	
	/**
	 * @Route("/property/{id}", name="admin.property.delete", methods="DELETE")
	 */
	public function delete(Property $property, Request $request): Response
	{
		$token = $request->get("_token");
		if($this->isCsrfTokenValid('delete' . $property->getId(), $token)){
			$this->em->remove($property);
			$this->em->flush();
			$this->addFlash('success', 'Le bien a été supprimé avec succès');
		}
		
		return $this->redirectToRoute('admin.property.index');
	}
}
