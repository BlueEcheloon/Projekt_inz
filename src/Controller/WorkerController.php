<?php

namespace App\Controller;

use App\Entity\Device;
use App\Entity\Worker;
use App\Form\WorkerType;
use App\Repository\DeviceRepository;
use App\Repository\WorkerRepository;
use App\Service\ReportUtil;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/worker')]
#[IsGranted("ROLE_USER")]
class WorkerController extends AbstractController
{
    #[Route('/', name: 'app_worker_index', methods: ['GET'])]
    public function index(WorkerRepository $workerRepository, ReportUtil $reportUtil): Response
    {
        $user = $this->getUser();
        if($this->isGranted('ROLE_MANAGER')){
            $admin_group=$user->getAdminGroup();
            $workers = $reportUtil->workerGroup($admin_group);
            return $this->render('worker/index.html.twig', [
                'workers' => $workers,
            ]);
        }else{
            return $this->render('worker/index.html.twig', [
                'workers' => $workerRepository->findAll(),
            ]);
        }
    }

    #[Route('/new', name: 'app_worker_new', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_EDIT_WORKER")]
    public function new(Request $request, WorkerRepository $workerRepository): Response
    {
        $worker = new Worker();
        $form = $this->createForm(WorkerType::class, $worker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $workerRepository->save($worker, true);
            $this->addFlash(
                'notice',
                'A new User has been added'
            );
            return $this->redirectToRoute('app_worker_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('worker/new.html.twig', [
            'worker' => $worker,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_worker_show', methods: ['GET'])]
    public function show(Worker $worker): Response
    {
        return $this->render('worker/show.html.twig', [
            'worker' => $worker,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_worker_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_EDIT_WORKER")]
    public function edit(Request $request, Worker $worker, WorkerRepository $workerRepository): Response
    {
        $form = $this->createForm(WorkerType::class, $worker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $workerRepository->save($worker, true);
            $this->addFlash(
                'notice',
                'User has been edited'
            );
            return $this->redirectToRoute('app_worker_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('worker/edit.html.twig', [
            'worker' => $worker,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_worker_delete', methods: ['POST'])]
    #[IsGranted("ROLE_EDIT_WORKER")]
    public function delete(Request $request, Worker $worker, WorkerRepository $workerRepository, DeviceRepository $deviceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$worker->getId(), $request->request->get('_token'))) {
            $device=$deviceRepository->findBy(['user'=>$worker->getId()]);
            $workerRepository->remove($worker, true);
            $this->addFlash(
                'notice',
                'User has been removed'
            );
        }

        return $this->redirectToRoute('app_worker_index', [], Response::HTTP_SEE_OTHER);
    }
}
