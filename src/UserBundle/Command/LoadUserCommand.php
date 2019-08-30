<?php

namespace UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UserBundle\Entity\User;

class LoadUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('user:load')
            ->setDescription('Create new user')
            ->addArgument('username', InputArgument::REQUIRED)
            ->addArgument('mdp', InputArgument::REQUIRED)
            ->addArgument('role', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $role = $input->getArgument('role');
        $username = $input->getArgument('username');
        $mdp = $input->getArgument('mdp');

        $user = new User();
        $user->setUsername($username);
        $encoded = $this->getContainer()->get('security.password_encoder')->encodePassword($user, $mdp);
        $user->setPassword($encoded);

        switch ($role){
            case 'admin' :
                $user->setRoles(array('ROLE_ADMIN'));
                break;
            case 'cuisine' :
                $user->setRoles(array('ROLE_CUISINE'));
                break;
            case 'buvette' :
                $user->setRoles(array('ROLE_BUVETTE'));
                break;
            case 'accueil' :
                $user->setRoles(array('ROLE_ACCUEIL'));
                break;
            default :
                $user->setRoles(array('ROLE_USER'));
                break;
        }

        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();

        $output->writeln('new user create');
        $output->writeln('username : ' . $username);
        $output->writeln('mdp : ' . $mdp);
        $output->writeln('role : ' . $role);
    }

}