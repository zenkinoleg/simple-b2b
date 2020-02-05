<?php

namespace App\Controller;

use App\Domain\Support\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class IndexController extends AbstractController
{
    /**
     * About.
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(): JsonResponse
    {
        return ApiResponse::success([
            'Application' => 'Simple B2B Transactions Api v1.0',
            'About'       => 'Symfony framework based solution for a basic B2B implementation',
            'Features'    => [
                'Symfony 5',
                'Domain Driven Design',
                'SOLID principles',
            ],
            'Upcoming'    => [
                'Automated Unit Tests',
                'EntityId as Class to be more SOLID',
                'Database Seeders',
                'Soft-deletable Transactions',
                'Statuses',
            ],
        ]);
    }
}
