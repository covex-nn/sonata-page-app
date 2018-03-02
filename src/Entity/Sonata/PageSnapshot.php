<?php

namespace App\Entity\Sonata;

use Sonata\PageBundle\Entity\BaseSnapshot;

class PageSnapshot extends BaseSnapshot
{
    /**
     * @var int
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }
}
