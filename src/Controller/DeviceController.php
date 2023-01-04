<?php

namespace App\Controller;

use App\Entity\Device;
use App\Form\DeviceType;
use App\Form\DeviceWorkerType;
use App\Repository\CommentRepository;
use App\Repository\DeviceRepository;
use App\Repository\GroupsRepository;
use App\Repository\SpecificationRepository;
use App\Repository\WorkerRepository;
use App\Service\ReportUtil;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/device')]
#[IsGranted("ROLE_USER")]
class DeviceController extends AbstractController
{
    #[Route('/', name: 'app_device_index', methods: ['GET'])]
    public function index(DeviceRepository $deviceRepository, ReportUtil $reportUtil): Response
    {
        $user = $this->getUser();
        if($this->isGranted('ROLE_MANAGER')){
            $admin_group=$user->getAdminGroup();
            $devices = $reportUtil->workerDevices($admin_group);
            return $this->render('device/index.html.twig', [
                'devices' => $devices,
            ]);
        }else{
            return $this->render('device/index.html.twig', [
                'devices' => $deviceRepository->findAll(),
            ]);
        }
    }

    #[Route('/new', name: 'app_device_new', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function new(Request $request, DeviceRepository $deviceRepository): Response
    {
        $device = new Device();
        $form = $this->createForm(DeviceType::class, $device);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $deviceRepository->save($device, true);
            $id=$device->getId();
            $this->addFlash(
                'notice',
                'Device has been created'
            );
            return $this->redirectToRoute('app_specification_new', ['device_id'=>$id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('device/new.html.twig', [
            'device' => $device,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_device_show', methods: ['GET'])]
    public function show(Device $device, SpecificationRepository $specificationRepository, WorkerRepository $workerRepository, CommentRepository $commentRepository, GroupsRepository $groupsRepository): Response
    {
        if($specificationRepository->findByDevice($device)){
            $spec=$specificationRepository->findByDevice($device);
        }
        else{
            $spec=null;
        }
        $comments=$commentRepository->findByDevice($device);
        if ($device->getUser()!=null){
            $worker=$workerRepository->findBy(['id'=>$device->getUser()]);
            $group=$groupsRepository->findByWorker($worker[0]);
            if($spec!=null){
                return $this->render('device/show.html.twig', [
                    'device' => $device,
                    'specification' =>$spec[0],
                    'user' =>$worker[0],
                    'comments'=>$comments,
                    'group' => $group[0],
                ]);
            }else{
                return $this->render('device/show.html.twig', [
                    'device' => $device,
                    'specification' =>null,
                    'user' =>$worker[0],
                    'comments'=>$comments,
                    'group' => $group[0],
                ]);
            }
        }else{
            if($spec!=null){
                return $this->render('device/show.html.twig', [
                    'device' => $device,
                    'specification' =>$spec[0],
                    'comments'=>$comments,
                    'user'=>null,
                    'group' => null,
                ]);
            }else{
                return $this->render('device/show.html.twig', [
                    'device' => $device,
                    'specification' =>null,
                    'comments'=>$comments,
                    'user'=>null,
                    'group' => null,
                ]);
            }
        }
    }

    #[Route('/{id}/edit', name: 'app_device_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function edit(Request $request, Device $device, DeviceRepository $deviceRepository, $id): Response
    {
        $form = $this->createForm(DeviceType::class, $device);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $deviceRepository->save($device, true);
            $this->addFlash(
                'notice',
                'Device has been edited'
            );

            return $this->redirectToRoute('app_device_show', ['id'=>$id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('device/edit.html.twig', [
            'device' => $device,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit_worker', name: 'app_device_edit_worker', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function edit_worker(Request $request, Device $device, DeviceRepository $deviceRepository, $id): Response
    {
        $form = $this->createForm(DeviceWorkerType::class, $device);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($device->getUser()){
                $device->getSpecification()->setStatus('working');
                $this->addFlash(
                    'notice',
                    'User for this device has been changed'
                );
            }
            else{
                $device->getSpecification()->setStatus('ready');
                $this->addFlash(
                    'notice',
                    'User for this device has been removed'
                );
            }
            $deviceRepository->save($device, true);
            return $this->redirectToRoute('app_device_show', ['id'=>$id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('device/edit_worker.html.twig', [
            'device' => $device,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_device_delete', methods: ['POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function delete(Request $request, Device $device, DeviceRepository $deviceRepository, SpecificationRepository $specificationRepository, CommentRepository $commentRepository, WorkerRepository $workerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$device->getId(), $request->request->get('_token'))) {
            $comments=$commentRepository->findBy(['device'=>$device]);
            foreach ($comments as $comment){
                $commentRepository->remove($comment,true);
            }
            $spec=$specificationRepository->find($device);
            $specificationRepository->remove($spec,true);
            $deviceRepository->remove($device, true);
            $this->addFlash(
                'notice',
                'Device and related entities has been removed'
            );
        }

        return $this->redirectToRoute('app_device_index', [], Response::HTTP_SEE_OTHER);
    }
}
