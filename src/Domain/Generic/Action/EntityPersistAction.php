<?php

namespace App\Domain\Generic\Action;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Domain\Generic\Entity\BaseEntity;

class EntityPersistAction
{
    /** @var \Symfony\Component\Validator\Validator\ValidatorInterface */
    private $validator;

    /** @var \Doctrine\Common\Persistence\ObjectManager */
    private $manager;

    /**
     * EntityPersistAction constructor.
     *
     * @param  \Symfony\Component\Validator\Validator\ValidatorInterface  $validator
     * @param  \Doctrine\ORM\EntityManagerInterface  $manager
     */
    public function __construct(ValidatorInterface $validator, EntityManagerInterface $manager)
    {
        $this->validator = $validator;
        $this->manager   = $manager;
    }

    /**
     * @param  \App\Domain\Generic\Entity\BaseEntity  $entity
     *
     * @return \App\Domain\Generic\Entity\BaseEntity
     */
    public function validateEntity(BaseEntity $entity) : BaseEntity
    {
        $validatorErrors = $this->validator->validate($entity);

        $errors = [];
        foreach ($validatorErrors as $violation) {
            $errors[] = $violation->getPropertyPath().': '.$violation->getMessage();
        }

        $entity->setValidatorErrors($errors);

        return $entity;
    }

    /**
     * @param  \App\Domain\Generic\Entity\BaseEntity  $entity
     *
     * @return \App\Domain\Generic\Entity\BaseEntity
     */
    public function persistEntity(BaseEntity $entity) : BaseEntity
    {
        if ($entity->getValidatorErrors()) {
            return $entity;
        }
        $this->manager->persist($entity);
        $this->manager->flush();

        return $entity;
    }

    /**
     * @param  \App\Domain\Generic\Entity\BaseEntity  $entity
     *
     * @return \App\Domain\Generic\Entity\BaseEntity
     */
    public function removeEntity(BaseEntity $entity) : BaseEntity
    {
        if (! $entity) {
            return $entity;
        }

        $this->manager->remove($entity);
        $this->manager->flush();

        return $entity;
    }
}
