<?php

namespace App\Twig;

use App\Entity\AssociatedTest;
use Twig\Extension\AbstractExtension;
use Twig\TwigTest;

class NotificationExtension extends AbstractExtension
{
    public function getTests()
    {
        return [
            new TwigTest('associated_test', [$this, 'isAssociatedTest']) 
        ]; 
    }

    public function isAssociatedTest($notification): bool {
        return $notification instanceof AssociatedTest;
    }
}