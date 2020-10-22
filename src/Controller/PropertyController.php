<?php namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PropertyController extends AbstractController
{   
    private $repository;

    public function __construct(PropertyRepository $repository)
    {
      $this->repository = $repository;
    }

    /**
     * 
     * @Route("/acheter", name="property.index")
     * @return Response
     */
    public function index():Response
    {
      // *********faire un post 
      // $property = new Property();
      // $property->setTitle('Mon premier Bien')
      //   ->setDescription('Description')
      //   ->setSurface(2)
      //   ->setRooms(5)
      //   ->setBedrooms(2)
      //   ->setFloor(1)
      //   ->setPrice(252010)
      //   ->setHeat(1)
      //   ->setCity('Paris')
      //   ->setAddress('Adresse')
      //   ->setPostalCode('25000');
      //   $em=$this->getDoctrine()->getManager();
      //   $em->persist($property);
      //   $em->flush();

      // Get Données
      // $repository = $this->getDoctrine()->getRepository(Property::class);
      // dump($repository);

      // ou
      dump($this->repository);

      return $this->render('pages/property/index.html.twig', [
          'current_menu' => 'property'
      ]);
    }
}