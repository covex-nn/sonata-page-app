<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SonataMediaMedia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class SonataMediaMediaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SonataMediaMedia::class);
    }

    public function save(SonataMediaMedia $media)
    {
        $em = $this->getEntityManager();

        $em->persist($media);
        $em->flush();
    }
}
