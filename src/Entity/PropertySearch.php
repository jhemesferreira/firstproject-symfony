<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch{

	/**
	 * @var int|null
	 * @Assert\Range(min=10, max=1000)
	 */
	private $maxPrice; 

	/**
	 * @var int|null
	 */
	private $minSurface; 

	/**
	 * @var ArrayCollection
	 */
	private $options; 

	public function __construct()
	{
		$this->options = new ArrayCollection();
	}

	public function getMaxPrice(): ?int
	{
		return $this->maxPrice;
	}

	public function setMaxPrice(int $maxPrice): PropertySearch 
	{
		$this->maxPrice = $maxPrice;
		return $this;
	}

	public function getMinSurface(): ?int
	{
		return $this->minSurface;
	}

	public function setMinSurface(int $minSurface)
	{
		$this->minSurface = $minSurface;
		return $this;
	}

	public function getOptions(): ?ArrayCollection
	{
		return $this->options;
	}

	public function setOptions(ArrayCollection $options)
	{
		$this->options = $options;
		return $this;
	}
}
