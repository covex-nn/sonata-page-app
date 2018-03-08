<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Sonata\MediaBundle\Entity\BaseGallery;
use Sonata\MediaBundle\Model\GalleryHasMediaInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="media__gallery")
 * @ORM\HasLifecycleCallbacks
 */
class SonataMediaGallery extends BaseGallery
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Groups(groups={"sonata_api_read","sonata_api_write","sonata_search"})
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SonataMediaGalleryHasMedia",mappedBy="gallery")
     *
     * @var GalleryHasMediaInterface[]
     */
    protected $galleryHasMedias;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist(): void
    {
        parent::prePersist();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate(): void
    {
        parent::preUpdate();
    }
}
