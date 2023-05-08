<?php

namespace App;

use App\Entity\User;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Security;

class Helper
{

    public function __construct(private LoggerInterface $logger,private Security $security){
    }

    public function getUser(): User{
       $user =  $this->security->getUser();
       $this->logger->info($user->getUserIdentifier());
       return $user;
    }
}