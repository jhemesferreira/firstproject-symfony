<?php namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private $repository;

    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * 
     * @Route("/", name="home")
     * @return Response
     */
    public function index():Response
    {
        $properties = $this->repository->findLatest();
        return $this->render('pages/home.html.twig', [
            'properties'=>$properties
        ]);
    }

     /**
     * 
     * @Route("/bien/{slug}-{id}", name="property.show", requirements={"slug" : "[a-z0-9\-]*"})
     */
    public function show(Property $property, string $slug): Response
    {
        if($property->getSlug() !== $slug){
            return $this->redirectToRoute('property.show', [
                'id'=> $property->getId(),
                'slug'=>$property->getSlug()
            ]);
        }
    //   $property = $this->repository->find($id);
      return $this->render('pages/property/show.html.twig', [
          'property'=>$property
      ]);
    }
}