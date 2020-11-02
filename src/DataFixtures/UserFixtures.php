<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture
{
	private $encoder;

	public function __construct(UserPasswordEncoderInterface $encoder)
	{
		$this->encoder = $encoder;
	}
	
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
		// $manager->persist($product);
		
		$user = new User();
		$user->setEmail('jhemes@gmail.com')
			 ->setPassword('password')
			 ->setRoles(['ROLE_ADMIN'])
			 ->setPassword($this->encoder->encodePassword($user, 'password')); //='password'
		$manager->persist($user);
        $manager->flush();
    }
}
