<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Service\ResponseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class CategoryController extends AbstractController
{
    public function __construct(
        private readonly ResponseService     $responseService,
        private readonly CategoryRepository  $categoryRepository,
        private readonly SerializerInterface $serializer,
        private readonly TranslatorInterface $translator,
    ) {
    }
    #[Route('/api/categories', name: 'app_category', methods: ['GET'])]
    public function getCategories(): JsonResponse
    {
        $categories['data']['list'] = $this->categoryRepository->findAll();

        $jsonCategories = $this->serializer->serialize($categories, 'json', ['groups' => 'getCategories']);
        $message = empty($categories['data']['list']) ? $this->translator->trans('category_empty') : '';

        return $this->responseService->createResponse(
            'success',
            Response::HTTP_OK,
            $message,
            json_decode($jsonCategories, true)
        );
    }
}
