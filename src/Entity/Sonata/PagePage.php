<?php

namespace App\Entity\Sonata;

use Sonata\PageBundle\Entity\BasePage;

class PagePage extends BasePage
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
