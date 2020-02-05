<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Domain\Account\DTO\AccountData;
use App\Domain\Account\Action\CreateAccountAction;
use App\Domain\Account\Action\UpdateAccountAction;
use App\Domain\Account\Action\DeleteAccountAction;
use App\Domain\Account\Repository\AccountRepository;
use App\Domain\Account\Resource\AccountResource;
use App\Domain\User\Repository\UserRepository;
use App\Domain\Support\ApiResponse;

class AccountController extends AbstractController
{
    /** @const string */
    private const MESSAGE_NOT_FOUND = 'Account doesn\'t exist';

    /**
     * @param  \App\Domain\Account\Repository\AccountRepository  $repository
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(AccountRepository $repository): JsonResponse
    {
        $accounts = $repository->findAll();

        return ApiResponse::success(
            AccountResource::collection($accounts)
        );
    }

    /**
     * @param  \App\Domain\Account\Repository\AccountRepository  $repository
     * @param  int  $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function show(AccountRepository $repository, int $id): JsonResponse
    {
        /** @var \App\Domain\Account\Entity\Account $account */
        if (! $account = $repository->find($id)) {
            return ApiResponse::notFound(self::MESSAGE_NOT_FOUND);
        }

        return ApiResponse::success(
            AccountResource::item($account)
        );
    }

    /**
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     * @param  \App\Domain\Account\Action\CreateAccountAction  $action
     * @param  \App\Domain\User\Repository\UserRepository  $userRepository
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(
        Request $request,
        CreateAccountAction $action,
        UserRepository $userRepository
    ): JsonResponse {
        $accountData = AccountData::fromRequest($request);

        /** @var \App\Domain\Account\Entity\Account $account */
        $account = $action->execute(
            $accountData,
            $userRepository->find(
                $accountData->getUserId()
            )
        );

        if ($errors = $account->getValidatorErrors()) {
            return ApiResponse::badRequest($errors);
        }

        return ApiResponse::created(
            AccountResource::item($account)
        );
    }

    /**
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     * @param  \App\Domain\Account\Action\UpdateAccountAction  $action
     * @param  \App\Domain\Account\Repository\AccountRepository  $accountRepository
     * @param  \App\Domain\User\Repository\UserRepository  $userRepository
     * @param  int  $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update(
        Request $request,
        UpdateAccountAction $action,
        AccountRepository $accountRepository,
        UserRepository $userRepository,
        int $id
    ): JsonResponse {
        /** @var \App\Domain\Account\Entity\Account $account */
        if (! $account = $accountRepository->find($id)) {
            return ApiResponse::notFound(self::MESSAGE_NOT_FOUND);
        }

        $accountData = AccountData::fromRequest($request);
        $account     = $action->execute(
            $accountData,
            $account,
            $userRepository->find(
                $accountData->getUserId()
            )
        );

        if ($errors = $account->getValidatorErrors()) {
            return ApiResponse::badRequest($errors);
        }

        return ApiResponse::created(
            AccountResource::item($account)
        );
    }

    /**
     * @param  \App\Domain\Account\Repository\AccountRepository  $repository
     * @param  \App\Domain\Account\Action\DeleteAccountAction  $action
     * @param  int  $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function delete(AccountRepository $repository, DeleteAccountAction $action, int $id): JsonResponse
    {
        // To be made soft-deletable, or/and re-implemented with Statuses
        return ApiResponse::badRequest([
            'DELETE is disabled for Accounts in this version.',
        ]);

        /** @var \App\Domain\Account\Entity\Account $account */
        if (! $account = $repository->find($id)) {
            return ApiResponse::notFound(self::MESSAGE_NOT_FOUND);
        }

        $account = $action->execute($account);

        return ApiResponse::deleted(
            AccountResource::item($account)
        );
    }
}
