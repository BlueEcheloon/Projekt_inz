<?php

namespace App\Form;

use App\Entity\Specification;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('os_version')
            ->add('memory')
            ->add('processor')
            ->add('motherboard')
            ->add('graphics')
            ->add('harddisk')
            ->add('antivirus')
            ->add('serial_number')
            ->add('date_of_purchase')
            ->add('warranty_exp')
//            ->add('device')
            ->add('status',ChoiceType::class,[
                'choices'=>[
                    'Setting up'=>[
                        'In Box'=>'boxed',
                        'Ready for User'=>'ready',
                    ],
                    'Working'=>[
                        'In Use'=>'working',
                    ],
                    'Error'=>[
                        'Faulty'=>'faulty',
                        'In Service'=>'service',
                    ],
                    'Recycle'=>[
                        'Destroy'=>'destroy',
                    ]
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Specification::class,
        ]);
    }
}
