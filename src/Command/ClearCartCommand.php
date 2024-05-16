<?php

namespace App\Command;

use App\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ClearCartCommand extends Command
{
    protected static $defaultName = 'clearCart';
    protected static $defaultDescription = 'Add a short description for your command';

    private $entityManager;
    private $orderRepository;

    public function __construct(EntityManagerInterface $entityManager, CartRepository $cartRepository)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->orderRepository = $cartRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Removes carts that have been inactive for a defined period')
            ->addArgument(
                'minutes',
                InputArgument::OPTIONAL,
                'The number of minutes a cart can remain inactive',
                1
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $minutes = $input->getArgument('minutes');

        if ($minutes <= 0) {
            $io->error('The number of minutes should be greater than 0.');
            return Command::FAILURE;
        }
        $limitDate = new \DateTime("-$minutes minutes");
        $expiredCartsCount = 0;

        while($carts = $this->orderRepository->findCartsNotModifiedSince($limitDate)) {
            foreach ($carts as $cart) {
                $this->entityManager->remove($cart);
            }
            $this->entityManager->flush();
            $this->entityManager->clear();
            $expiredCartsCount += count($carts);
        }

        if ($expiredCartsCount) {
            $io->success("$expiredCartsCount cart(s) have been deleted.");
        } else {
            $io->info('No expired carts.');
        }

        return Command::SUCCESS;
    }
}
