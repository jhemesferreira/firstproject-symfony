<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PropertyController extends AbstractController
{
  /**
   * @var PropertyRepository
   */
  private $repository;

  /**
   * @var EntityManagerInterface
   */
  private $em;

  public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
  {
    $this->repository = $repository;
    $this->em = $em;
  }

  /**
   * 
   * @Route("/biens", name="property.index")
   * @return Response
   */
  public function index(PaginatorInterface $paginator, Request $request): Response
  {

	$search = new PropertySearch();
	$form = $this->createForm(PropertySearchType::class, $search);
	$form->handleRequest(($request));

    $properties = $paginator->paginate(
      $this->repository->findAllVisibleQuery($search), 
      $request->query->getInt('page', 1), 10);


    return $this->render('pages/property/index.html.twig', [
      'current_menu' => 'property',
	  'properties'   => $properties,
	  'form'         => $form->createView()
    ]);
  }
  /**
   * @Route("/bien/{id}-{slug}", name="property.show")
   */
  public function show(Property $property, $slug): Response
  {
    if ($property->getSlug() !== $slug) {
      return $this->redirectToRoute('property.index');
    }

    return $this->render('pages/property/show.html.twig', [
      'property' => $property
    ]);
  }
}
