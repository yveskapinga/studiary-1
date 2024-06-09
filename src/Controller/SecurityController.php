<?php

// Déclaration de l'espace de noms de ce contrôleur.
namespace App\Controller;

// Importation des classes utilisées dans ce contrôleur.
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

// Déclaration de la classe SecurityController qui étend AbstractController pour fournir des fonctionnalités spécifiques à la sécurité.
class SecurityController extends AbstractController
{
    // Déclaration de la fonction login. Cette fonction est appelée lorsqu'un utilisateur tente de se connecter.
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Si l'utilisateur est déjà connecté, il est redirigé vers la page d'accueil.
        if ($this->getUser()) {
            return $this->redirectToRoute('index');
        }

        // Récupération de l'erreur de connexion, s'il y en a une.
        $error = $authenticationUtils->getLastAuthenticationError();
        // Récupération du dernier nom d'utilisateur entré par l'utilisateur.
        $lastUsername = $authenticationUtils->getLastUsername();

        // Affichage de la page de connexion avec le dernier nom d'utilisateur et l'erreur en paramètres.
        return $this->render('pages/login.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    // Déclaration de la fonction logout. Cette fonction est appelée lorsqu'un utilisateur tente de se déconnecter.
    public function logout()
    {
        // Lancement d'une LogicException parce que cette méthode peut être vide - elle sera interceptée par la clé de déconnexion sur votre pare-feu.
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
