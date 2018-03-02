<?php

namespace App\Entity\Sonata;

use Sonata\PageBundle\Entity\BaseBlock;

class PageBlock extends BaseBlock
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
