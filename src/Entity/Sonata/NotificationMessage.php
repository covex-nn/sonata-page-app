<?php

namespace App\Entity\Sonata;

use Sonata\NotificationBundle\Entity\BaseMessage;

class NotificationMessage extends BaseMessage
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
