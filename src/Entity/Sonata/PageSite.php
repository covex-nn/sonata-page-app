<?php

namespace App\Entity\Sonata;

use Sonata\PageBundle\Entity\BaseSite;

class PageSite extends BaseSite
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
