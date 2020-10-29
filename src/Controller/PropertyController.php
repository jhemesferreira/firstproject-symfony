<?php namespace App\Controller;

use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
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
      // dump($this->repository);
      // dump($this->repository->findOneBy(['floor'=>1]));
      $property = $this->repository->findAllVisible();
      dump($property);
      $property[0]->setSold(true);
      $this->em->flush();
      dump($property);
   
      return $this->render('pages/property/index.html.twig', [
          'current_menu' => 'property'
      ]);
    }

}