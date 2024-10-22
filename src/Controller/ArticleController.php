<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ArticleController extends AbstractController
{
    #[Route('/api/articles', name: 'get_articles', methods: ['GET'])]
    public function getArticles(EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupérer tous les articles
        $articles = $entityManager->getRepository(Article::class)->findAll();

        // Transformer les objets en tableau (ou utiliser le Serializer pour un format plus propre)
        $data = [];
        foreach ($articles as $article) {
            $data[] = [
                'id' => $article->getId(),
                'article_id' => $article->getArticleId(),
                'article_description' => $article->getArticleDescription(),
                'article_date' => $article->getArticleDate()->format('Y-m-d H:i:s'),
                'article_datemodif' => $article->getArticleDatemodif() ? $article->getArticleDatemodif()->format('Y-m-d H:i:s') : null,
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/api/article', name: 'create_article', methods: ['POST'])]
    public function createArticle(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Vérifier que les champs obligatoires sont présents
        if (empty($data['article_id']) || empty($data['article_description']) || empty($data['article_date'])) {
            return new JsonResponse(['error' => 'Invalid data'], Response::HTTP_BAD_REQUEST);
        }

        // Créer un nouvel article
        $article = new Article();
        $article->setArticleId($data['article_id']);
        $article->setArticleDescription($data['article_description']);
        $article->setArticleDate(new \DateTime($data['article_date']));  // Convertir la date

        // Si la date de modification est présente, la définir
        if (!empty($data['article_datemodif'])) {
            $article->setArticleDatemodif(new \DateTime($data['article_datemodif']));
        }

        // Persister et sauvegarder l'article
        $entityManager->persist($article);
        $entityManager->flush();

        // Retourner l'article nouvellement créé en JSON
        $response = [
            'id' => $article->getId(),
            'article_id' => $article->getArticleId(),
            'article_description' => $article->getArticleDescription(),
            'article_date' => $article->getArticleDate()->format('Y-m-d H:i:s'),
            'article_datemodif' => $article->getArticleDatemodif() ? $article->getArticleDatemodif()->format('Y-m-d H:i:s') : null,
        ];

        return new JsonResponse($response, Response::HTTP_CREATED);
    }
}
