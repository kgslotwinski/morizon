<?php

namespace App\User\UI\Controller;

use App\Shared\Domain\Model\User;
use App\Shared\Domain\Repository\UserRepositoryInterface;
use App\User\Application\DTO\UserFilterDTO;
use App\User\Application\DTO\UserInputDTO;
use App\User\UI\Form\UserFilterType;
use App\User\UI\Form\UserInputType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
final class UserController extends AbstractController
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $filterDTO = new UserFilterDTO();
        $form = $this->createForm(UserFilterType::class, $filterDTO);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $filters = $filterDTO->toArray();
        }

        $users = $this->userRepository->fetchUsers($filters ?? []);
        return $this->render(
            'user/user_index.html.twig',
            [
                'users' => array_map(fn (User $user) => $user->toArray(), $users),
                'filters' => empty($filters) ? null : $filters,
            ]
        );
    }

    #[Route('/new', name: 'user_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $userInput = new UserInputDTO();
        $form = $this->createForm(UserInputType::class, $userInput);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userRepository->createUser($userInput->toArray());
            $this->addFlash('success', 'User created');
            return $this->redirectToRoute('user_index');
        } elseif ($form->isSubmitted()) {
            foreach ($form->getErrors(true) as $error) {
                if ($field = $error->getOrigin()?->getName()) {
                    $errors[$field] = $error->getMessage();
                }
            }
        }

        return $this->render(
            'user/user_new.html.twig',
            [
                'form' => $form,
                'errors' => empty($errors) ? null : $errors,
            ]
        );
    }

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        if (!$user = $this->userRepository->fetchUser($id)) {
            throw $this->createNotFoundException('User not found');
        }

        return $this->render(
            'user/user_show.html.twig',
            [
                'user' => $user->toArray(),
            ]
        );
    }

    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id): Response
    {
        if (!$user = $this->userRepository->fetchUser($id)) {
            throw $this->createNotFoundException('User not found');
        }

        $userInput = UserInputDTO::fromUser($user);
        $form = $this->createForm(UserInputType::class, $userInput);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userRepository->updateUser($id, $userInput->toArray());
            $this->addFlash('success', 'User updated');
            return $this->redirectToRoute('user_show', ['id' => $id]);
        } elseif ($form->isSubmitted()) {
            foreach ($form->getErrors(true) as $error) {
                if ($field = $error->getOrigin()?->getName()) {
                    $errors[$field] = $error->getMessage();
                }
            }
        }

        return $this->render(
            'user/user_edit.html.twig',
            [
                'user' => $user->toArray(),
                'form' => $form,
                'errors' => empty($errors) ? null : $errors,
            ]
        );
    }

    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, int $id): Response
    {
        if (!$this->userRepository->fetchUser($id)) {
            throw $this->createNotFoundException('User not found');
        }

        if ($this->isCsrfTokenValid('delete', $request->request->get('_token'))) {
            $this->userRepository->deleteUser($id);
            $this->addFlash('success', 'User deleted');
        }

        return $this->redirectToRoute('user_index');
    }
}