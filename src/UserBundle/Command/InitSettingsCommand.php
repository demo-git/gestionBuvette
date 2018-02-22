<?php

namespace UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UserBundle\Entity\Setting;

class InitSettingsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('settings:init')
            ->setDescription('Create new Setting object')
            ->addArgument('hoven', InputArgument::REQUIRED)
            ->addArgument('warning', InputArgument::REQUIRED)
            ->addArgument('danger', InputArgument::REQUIRED)
            ->addArgument('sauce', InputArgument::OPTIONAL)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $hoven = $input->getArgument('hoven');
        $warning = $input->getArgument('warning');
        $danger = $input->getArgument('danger');

        $em = $this->getContainer()->get('doctrine')->getManager();
        $settings = $em->getRepository(Setting::class)->find(1);

        if (!$settings) {
            $settings = new Setting();
            $settings->setDangerWait($danger);
            $settings->setHovenCapacity($hoven);
            $settings->setWarningWait($warning);
            if ($input->getArgument('sauce')) {
                $settings->setSauce($input->getArgument('sauce'));
            }

            $em->persist($settings);
            $em->flush();

            $output->writeln('new setting object create');
            $output->writeln('hoven capacity : ' . $hoven);
            $output->writeln('warn level : ' . $warning . 'm');
            $output->writeln('danger level : ' . $danger . 'm');
        } else {
            $output->writeln('Setting object cannot be create because it\'s already exist');
        }
    }
}