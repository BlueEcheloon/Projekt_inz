<?php

namespace App\Controller;

use App\Entity\Device;
use App\Entity\Specification;
use App\Form\SpecificationType;
use App\Repository\DeviceRepository;
use App\Repository\SpecificationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/specification')]
#[IsGranted("ROLE_ADMIN")]
class SpecificationController extends AbstractController
{
    #[Route('/', name: 'app_specification_index', methods: ['GET'])]
    public function index(SpecificationRepository $specificationRepository): Response
    {
        return $this->render('specification/index.html.twig', [
            'specifications' => $specificationRepository->findAll(),
        ]);
    }

    #[Route('/new/{device_id}', name: 'app_specification_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SpecificationRepository $specificationRepository, $device_id, DeviceRepository $deviceRepository): Response
    {
        $specification = new Specification();
        $device = $deviceRepository->find($device_id);
        $specification->setDevice($device);
        $form = $this->createForm(SpecificationType::class, $specification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specificationRepository->save($specification, true);
            $this->addFlash(
                'notice',
                'Specification has been created for device'
            );
            return $this->redirectToRoute('app_device_show', ['id'=>$device_id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('specification/new.html.twig', [
            'specification' => $specification,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_specification_show', methods: ['GET'])]
    public function show(Specification $specification): Response
    {
        return $this->render('specification/show.html.twig', [
            'specification' => $specification,
        ]);
    }

    #[Route('/{id}/edit/{device_id}', name: 'app_specification_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Specification $specification, SpecificationRepository $specificationRepository,$device_id): Response
    {
        $form = $this->createForm(SpecificationType::class, $specification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specificationRepository->save($specification, true);
            $this->addFlash(
                'notice',
                'Specification has been edited'
            );
            return $this->redirectToRoute('app_device_show', ['id'=>$device_id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('specification/edit.html.twig', [
            'specification' => $specification,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_specification_delete', methods: ['POST'])]
    public function delete(Request $request, Specification $specification, SpecificationRepository $specificationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$specification->getId(), $request->request->get('_token'))) {
            $specificationRepository->remove($specification, true);
            $this->addFlash(
                'notice',
                'Specification has been removed'
            );
        }

        return $this->redirectToRoute('app_specification_index', [], Response::HTTP_SEE_OTHER);
    }
}
