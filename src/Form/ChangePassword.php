<?php

namespace App\Form;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;
class ChangePassword
{
    /**
     * @SecurityAssert\UserPassword(
     *     message = "To nie jest Twoje aktualne hasło !"
     * )
     */
    public $oldPassword;

    /**
     * @Assert\Length(
     *     min = 6,
     *     minMessage = "Hasło musi mieć conajmniej 6 znaków !"
     * )
     */
    public $newPassword;
}