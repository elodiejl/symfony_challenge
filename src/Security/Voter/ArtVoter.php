<?php

namespace App\Security\Voter;

use App\Entity\Art;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ArtVoter extends Voter
{
    const NEW = 'ART_NEW';
    const EDIT = 'ART_EDIT';
    const DELETE = 'ART_DELETE';

    private $security;

    protected function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::EDIT, self::NEW, self::DELETE])){
            return false;
        }
        if (!$subject instanceof Art){
            return false;
        }
        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) return false;


        if ($this->security->isGranted('ROLE_ADMIN')) return true;

        switch ($attribute){
            case self::NEW:
                return $this->canAdd();
                break;
            case self::DELETE:
                return $this->canDelete();
                break;
            case self::EDIT:
                return $this->canEdit();
                break;
        }

    }

    private function canAdd(){
        return $this->security->isGranted('ROLE_VENDOR');
    }

    private function canEdit(){
        return $this->security->isGranted('ROLE_VENDOR');
    }

    private function canDelete(){
        return $this->security->isGranted('ROLE_VENDOR');
    }
}

