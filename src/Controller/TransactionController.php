<?php

namespace App\Controller;

use App\Domain\Account\Repository\AccountRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Domain\Transaction\DTO\TransactionData;
use App\Domain\Transaction\Action\CreateTransactionAction;
use App\Domain\Transaction\Resource\TransactionResource;
use App\Domain\Support\ApiResponse;

class TransactionController extends AbstractController
{
    /**
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     * @param  \App\Domain\Transaction\Action\CreateTransactionAction  $action
     * @param  \App\Domain\Account\Repository\AccountRepository  $accountRepository
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(
        Request $request,
        CreateTransactionAction $action,
        AccountRepository $accountRepository
    ): JsonResponse {
        $transactionData = TransactionData::fromRequest($request);

        /** @var \App\Domain\Transaction\Entity\Transaction $transaction */
        $transaction = $action->execute(
            $transactionData,
            $accountRepository->find(
                $transactionData->getAccountFrom()
            ),
            $accountRepository->find(
                $transactionData->getAccountTo()
            )
        );

        if ($errors = $transaction->getValidatorErrors()) {
            return ApiResponse::badRequest($errors);
        }

        return ApiResponse::created(
            TransactionResource::item($transaction)
        );
    }
}
