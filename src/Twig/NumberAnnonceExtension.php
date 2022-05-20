<?php

namespace App\Twig;

use App\Entity\User;
use App\Repository\ProductRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class NumberAnnonceExtension extends AbstractExtension
{

    private ProductRepository $productRepository;



    public function __construct(
        ProductRepository $productRepository,

    ) {
        $this->productRepository = $productRepository;

    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('count_annonce_by_user', [$this, 'countAnnonceByUser']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function countAnnonceByUser(int $user)
    {
        $ProductEntities = $this->productRepository->findAllProductByUser($user);


        return count($ProductEntities);
    }
}
