<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        // Si l'utilisateur qui essaie de se connecter n'a pas vérifier son compte, 
        if (!$user->isIsVerified()) {
            // C'est mort !
            // Levons une exception (erreur) accompagné d'un message afin de lui expliquer le problème.
            throw new CustomUserMessageAccountStatusException('Veuillez confirmer votre compte par email avant de vous connecter.');
        }
    }
}
