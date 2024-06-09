<?php

// Déclaration de l'espace de noms de ce contrôleur.
namespace App\Controller\Admin;

// Importation des classes utilisées dans ce contrôleur.
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

// Déclaration de la classe AdminController qui étend EasyAdminController pour fournir des fonctionnalités spécifiques à l'admin.
class AdminController extends EasyAdminController
{
    /**
     * @var UserPasswordEncoderInterface
     */
    // Déclaration d'une propriété privée pour contenir une instance de UserPasswordEncoderInterface.
    private $passwordEncoder;

    // Déclaration du constructeur de la classe. Le constructeur est une fonction spéciale qui est automatiquement appelée lorsqu'un objet de cette classe est créé.
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        // Stockage de l'instance de UserPasswordEncoderInterface dans la propriété privée de cette classe.
        $this->passwordEncoder = $passwordEncoder;
    }

    // Déclaration de la fonction persistUserEntity. Cette fonction est appelée lorsqu'une entité utilisateur est persistée (sauvegardée dans la base de données).
    public function persistUserEntity($user)
    {
        // Mise à jour du mot de passe de l'entité utilisateur.
        $this->updatePassword($user);

        // Appel de la fonction persistEntity de la classe parent (EasyAdminController) avec l'entité utilisateur.
        parent::persistEntity($user);
    }

    // Déclaration de la fonction updatePassword. Cette fonction est utilisée pour mettre à jour le mot de passe d'une entité utilisateur.
    public function updatePassword(User $user)
    {
        // Si le mot de passe en clair de l'entité utilisateur n'est pas vide,
        if (!empty($user->getPlainPassword())) {
            // Le mot de passe de l'entité utilisateur est défini sur la version encodée du mot de passe en clair.
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
        }
    }
}
