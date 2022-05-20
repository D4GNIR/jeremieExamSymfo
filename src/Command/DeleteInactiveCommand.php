<?php

namespace App\Command;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:deleteInactive',
    description: 'Delete inactive annonce',
)]
class DeleteInactiveCommand extends Command
{

    public function __construct(
        private ProductRepository $productRepository,
        private EntityManagerInterface $em
  
    ) 
    {
        parent::__construct();
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $productEntities = $this->productRepository->findAllInactive();
        $count = 0;

        foreach ($productEntities as $productEntity) {
            $count++;
            $this->em->remove($productEntity);
        }

        $this->em->flush();
        $output->writeln($count . ' annonces ont été supprimés.');
        return Command::SUCCESS;
    }
}
