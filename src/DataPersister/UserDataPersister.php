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
     * @throws \Exception
     */
    public function persist($data)
    {
        // Checking if all the input are filled
        if($data->getPassword() != null && $data->getFirstname() != null && $data->getLastname() != null && $data->getGender() != null) {
            // Checking the Email format
            if(filter_var($data->getEmail(), FILTER_VALIDATE_EMAIL)) {
                if($data->getPassword()) {
                    $data->setPassword($this->passwordEncoder->encodePassword($data, $data->getPassword()));
                }

                $data->setRoles(['ROLE_USER']);
                $data->setRegisteredAt(new \DateTime());

                $this->entityManager->persist($data);
                $this->entityManager->flush();
            } else {
                throw new \Exception('Merci de renseigner une adresse e-mail valide', 400);
            }
        } else {
            throw new \Exception('Merci de remplir tous les champs!', 400);
        }
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