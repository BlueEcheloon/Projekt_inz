<?php

namespace App\Form;

use App\Entity\Groups;
use App\Entity\Worker;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('surname')
            ->add('username')
            ->add('description')
            ->add('adGroup',EntityType::class,[
                'attr'=>['class'=>'selectpicker col-4', 'data-size'=>'5'],
                'class'=>Groups::class,
                'choice_label' => 'name',
                'required' => false,
                'placeholder' => 'Not Set',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Worker::class,
        ]);
    }
}
