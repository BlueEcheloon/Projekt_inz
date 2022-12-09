<?php

namespace App\Form;

use App\Entity\Device;
use App\Entity\Worker;
use App\Repository\WorkerRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeviceWorkerType extends AbstractType
{
//    private $workerRepository;
//    public function __construct(WorkerRepository $workerRepository)
//    {
//        $this->workerRepository = $workerRepository;
//    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user',EntityType::class,[
                'attr'=>['class'=>'selectpicker col-4', 'data-size'=>'5'],
                'class'=>Worker::class,
                'query_builder'=>function(WorkerRepository $workerRepository){
                return $workerRepository->createQueryBuilder('w')
                    ->leftJoin('w.device','d','d.user=w.id')
                    ->where('d is null');
                },
                'choice_label' => 'username',
                'required' => false,
                'placeholder' => 'Not Set',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Device::class,
            'workers' => Worker::class,
        ]);
    }
}
