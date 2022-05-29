<?php

namespace App\Twig;

use Symfony\Component\Security\Core\Security;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SecurityExtension extends AbstractExtension
{
    private Security $security; 

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('has_role', [$this, 'hasRole']),
            new TwigFunction('is_patient', [$this, 'isPatient'])
        ]; 
    }

    public function hasRole(array $rolesToVerify): bool
    {
        $user = $this->security->getUser();

        if(!$user) {
            return false; 
        }

        $userRoles = $user->getRoles();

        foreach($userRoles as $role) {
            if(in_array($role, $rolesToVerify)){
                return true;
            }
        }

        return false;
    }

    public function isPatient(): bool
    {
        $user = $this->security->getUser();

        if(!$user) {
            return false; 
        }

        $userRoles = $user->getRoles();
        
        foreach($userRoles as $role) {
            if($role == "ROLE_ADMIN" || $role == "ROLE_PSYC"){
                return false;
            }
        }

        return true;
    }
}