<?php


namespace App\DataPersister;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserDataPersister implements \ApiPlatform\Core\DataPersister\DataPersisterInterface
{
    private $entityManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @inheritDoc
     */
    public function supports($data): bool
    {
        return $data instanceof User;
    }

    /**
     * @inheritDoc
     * @param User $data
     */
    public function persist($data)
    {
        if($data->getPassword()) {
            $data->setPassword($this->passwordEncoder->encodePassword($data, $data->getPassword()));
        }

        $data->setRoles(['ROLE_USER']);
        $data->setRegisteredAt(new \DateTime());

        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}