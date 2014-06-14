<?php

namespace Drakkar\TestBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateItemsCommand extends ContainerAwareCommand
{
    const PRICE_MIN = 10;
    const PRICE_MAX = 1000;
    const ITEMS_AMOUNT = 100;
    
    protected function configure()
    {
        $this
            ->setName('drakkar:items:create')
            ->setDescription('Crea items de ejemplo para probar la aplicación')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $i = 0;
        while ($i<self::ITEMS_AMOUNT) {
            $item = new \Drakkar\TestBundle\Entity\Item();
            $item->setTitle('Titulo de item '.$i);
            $item->setDescription('Descripcion de item '.$i);
            $item->setPrice(mt_rand (self::PRICE_MIN*10, self::PRICE_MAX*10) / 10);
            $em->persist($item);
            $em->flush();
            unset($item);
            $i++;
        }
        $output->writeln('Creados '.self::ITEMS_AMOUNT.' OK');
    }
}