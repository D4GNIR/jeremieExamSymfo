<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\AddProductType;
use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    private EntityManagerInterface $em;
    private ProductRepository $productRepository;



    public function __construct(
        EntityManagerInterface $em,
        ProductRepository $productRepository,
  
    ) {
        $this->em = $em;
        $this->productRepository = $productRepository;
    }

    #[Route('/annonce/product/create', name: 'app_product_create')]
    public function addProduct(Request $request): Response
    {
        $productEntity = new Product();
        $form = $this->createForm(AddProductType::class, $productEntity);
        $form->handleRequest($request);

        $productEntity->setCreatedBy($this->getUser());
        $productEntity->setCreatedAt(new DateTime('now'));

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($productEntity);
            $this->em->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('annonce/addProduct.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/annonce/product/edit/{id}', name: 'app_annonce_edit')]
    public function editAnnonce($id,Product $product, Request $request): Response
    {
        $product = $this->productRepository->findOneBy(['id'=>$id]);

        $form = $this->createForm(AddProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($product);
            $this->em->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('annonce/addProduct.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/annonce/product/delete/{id}', name: 'app_annonce_delete')]
    public function deleteAnnonce($id,Request $request): Response
    {
        $productDeleted = $this->productRepository->findOneBy(['id'=>$id]);

        $this->em->remove($productDeleted);
        $this->em->flush();

        return $this->redirectToRoute('app_home');
    }

}
