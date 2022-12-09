<?php

namespace App\Controller;

use App\Entity\Groups;
use App\Form\GroupsType;
use App\Repository\GroupsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/groups')]
#[IsGranted("ROLE_USER")]
class GroupsController extends AbstractController
{
    #[Route('/', name: 'app_groups_index', methods: ['GET'])]
    public function index(GroupsRepository $groupsRepository): Response
    {
        return $this->render('groups/index.html.twig', [
            'groups' => $groupsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_groups_new', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function new(Request $request, GroupsRepository $groupsRepository): Response
    {
        $group = new Groups();
        $form = $this->createForm(GroupsType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $groupsRepository->save($group, true);

            return $this->redirectToRoute('app_groups_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('groups/new.html.twig', [
            'group' => $group,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_groups_show', methods: ['GET'])]
    public function show(Groups $group): Response
    {
        return $this->render('groups/show.html.twig', [
            'group' => $group,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_groups_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function edit(Request $request, Groups $group, GroupsRepository $groupsRepository): Response
    {
        $form = $this->createForm(GroupsType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $groupsRepository->save($group, true);

            return $this->redirectToRoute('app_groups_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('groups/edit.html.twig', [
            'group' => $group,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_groups_delete', methods: ['POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function delete(Request $request, Groups $group, GroupsRepository $groupsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$group->getId(), $request->request->get('_token'))) {
            $groupsRepository->remove($group, true);
        }

        return $this->redirectToRoute('app_groups_index', [], Response::HTTP_SEE_OTHER);
    }
}
