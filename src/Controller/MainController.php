<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */
class MainController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var BookRepository;
     */
    private $bookRepository;

    /**
     * @var CategoryRepository;
     */
    private $categoryRepository;

    /**
     * @var SerializerInterface;
     */
    private $serializer;

    public function __construct(
        EntityManagerInterface $entityManager,
        BookRepository $bookRepository,
        CategoryRepository $categoryRepository,
        SerializerInterface $serializer
    )
    {
        $this->entityManager = $entityManager;
        $this->bookRepository = $bookRepository;
        $this->categoryRepository = $categoryRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/book/",
     *     name="get_book",
     *     methods={"GET"}
     *     )
     */
    public function getBooksAll()
    {

        try {

            $books = $this->bookRepository->findAll();
            $data = $this->serializer->serialize($books,'json');
            //$response = new JsonResponse(['message' => 'Привет!']);
            //$response->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

           return new JsonResponse([
                'success' => true,
                'data'    => $data,
            ], Response::HTTP_OK);

        } catch (\Exception $exception) {

            return new JsonResponse([
                'success' => false,
                'code'    => $exception->getCode(),
                'message' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);

        }

    }

    /**
     * @Route("/category/",
     *     name="get_category",
     *     methods={"GET"}
     *     )
     */
    public function getCategoryAll()
    {

            $category = $this->categoryRepository->findAll();
            $data = $this->serializer->serialize($category,'json');
            $response = new JsonResponse($data);
            //$response->setEncodingOptions(JSON_UNESCAPED_SLASHES);

            return $response;
    }
}
