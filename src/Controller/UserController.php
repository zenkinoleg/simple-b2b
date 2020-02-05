<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Domain\User\DTO\UserData;
use App\Domain\User\Action\CreateUserAction;
use App\Domain\User\Action\UpdateUserAction;
use App\Domain\User\Action\DeleteUserAction;
use App\Domain\User\Repository\UserRepository;
use App\Domain\User\Resource\UserResource;
use App\Domain\Support\ApiResponse;

class UserController extends AbstractController
{
    /** @const string */
    private const MESSAGE_NOT_FOUND = 'No such user exists';

    /**
     * @param  \App\Domain\User\Repository\UserRepository  $repository
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(UserRepository $repository): JsonResponse
    {
        $users = $repository->findAll();

        return ApiResponse::success(
            UserResource::collection($users)
        );
    }

    /**
     * @param  \App\Domain\User\Repository\UserRepository  $repository
     * @param  int  $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function show(UserRepository $repository, int $id): JsonResponse
    {
        /** @var \App\Domain\User\Entity\User $user */
        if (! $user = $repository->find($id)) {
            return ApiResponse::notFound(self::MESSAGE_NOT_FOUND);
        }

        return ApiResponse::success(
            UserResource::item($user)
        );
    }

    /**
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     * @param  \App\Domain\User\Action\CreateUserAction  $action
     *
     * @return mixed
     */
    public function create(Request $request, CreateUserAction $action): JsonResponse
    {
        /** @var \App\Domain\User\Entity\User $user */
        $user = $action->execute(
            UserData::fromRequest($request)
        );

        if ($errors = $user->getValidatorErrors()) {
            return ApiResponse::badRequest($errors);
        }

        return ApiResponse::created(
            UserResource::item($user)
        );
    }

    /**
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     * @param  \App\Domain\User\Action\UpdateUserAction  $action
     * @param  \App\Domain\User\Repository\UserRepository  $repository
     * @param  int  $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update(
        Request $request,
        UpdateUserAction $action,
        UserRepository $repository,
        int $id
    ): JsonResponse {
        /** @var \App\Domain\User\Entity\User $user */
        if (! $user = $repository->find($id)) {
            return ApiResponse::notFound(self::MESSAGE_NOT_FOUND);
        }

        $user = $action->execute(
            $user,
            UserData::fromRequest($request)
        );

        if ($errors = $user->getValidatorErrors()) {
            return ApiResponse::badRequest($errors);
        }

        return ApiResponse::created(
            UserResource::item($user)
        );
    }

    /**
     * @param  \App\Domain\User\Repository\UserRepository  $repository
     * @param  \App\Domain\User\Action\DeleteUserAction  $action
     * @param  int  $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function delete(UserRepository $repository, DeleteUserAction $action, int $id): JsonResponse
    {
        /** @var \App\Domain\User\Entity\User $user */
        if (! $user = $repository->find($id)) {
            return ApiResponse::notFound(self::MESSAGE_NOT_FOUND);
        }

        $user = $action->execute($user);

        return ApiResponse::deleted(
            UserResource::item($user)
        );
    }
}
