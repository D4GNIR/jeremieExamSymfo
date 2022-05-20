<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private ProductRepository $productRepository;
    private PaginatorInterface $paginator;
    private EntityManagerInterface $em;


    public function __construct(
        ProductRepository $productRepository,
        PaginatorInterface $paginator,
        EntityManagerInterface $em,
    ) {
        $this->productRepository = $productRepository;
        $this->paginator = $paginator;
        $this->em = $em;
    }

    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        $qb = $this->productRepository->getQbAll();

        $pagination = $this->paginator->paginate(
            $qb, //La query
            $request->query->getInt('page',1), //Le numero de page de depart
            9 //Le nombre de résultat pas page
        );

        return $this->render('home/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/JulesEnvoiMoiTonAdressePourLesEGLD/{id}', name: 'app_active')]
    public function tampon($id,Request $request): Response
    {
        $productEntity = $this->productRepository->findOneBy(['id'=>$id]);

        $productEntity->setIsActive(false);
        $this->em->persist($productEntity);
        $this->em->flush();

        return $this->redirectToRoute('app_home');
    }
}
