<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            ->add('heat', ChoiceType::class, [
							'choices'  => $this->getChoices()
						])
            ->add('city', null, [
                'label' => 'Ville'
            ])
            ->add('address')
            ->add('postal_code')
            ->add('sold')
            // ->add('created_at')
        ;
	}
	

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'forms'
        ]);
	}

	private function getChoices()
	{
		$choices = Property::HEAT;
		$outputs = [];

		foreach($choices as $k => $v){
			$outputs[$v] = $k;
		}

		return $outputs;
	}

}
