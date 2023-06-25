<?php

namespace App\MessageHandler;

use App\Message\ClearBadUserMessage;
use Doctrine\DBAL\Exception;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;


final class ClearBadUserMessageHandler implements MessageHandlerInterface
{
    #[AsMessageHandler]
    private $user;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager,
                                UserRepository $user)
    {
        $this->entityManager = $entityManager;
        $this->user = $user;
    }

    public function __invoke(ClearBadUserMessage $message)
    {
        $userData = $this->user->findOneBy(['email' => $message->getEmail()]);
        if ($userData->isVerified()) {
            return true;
        } else {
          try {
              $this->entityManager->remove($userData);
              $this->entityManager->flush();
          } catch (\Exception $exception) {
              return false;
          }
        }
    }


}
