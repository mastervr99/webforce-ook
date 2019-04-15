<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;




/**
 * Class SecurityController
 * @package App\Controller
 *
 *
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // encode le mot de passe à partir de la config "encoders"
                // de config/packages/security.yaml
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());

                $user->setPassword($password);

                $em = $this->getDoctrine()->getManager();

                $em->persist($user);
                $em->flush();

                $this->addFlash('success','Votre compte est créé');

                return $this->redirectToRoute('app_security_login');
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render('security/register.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/connexion")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {

//        TRAITEMENT DU FORM PAR SECURITY

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastAuthenticationError();

        if(!empty($error)) {
            $this->addFlash('error','Identifiants incorrects');

            return $this->redirectToRoute('app_security_login');

        }

        return $this->render('security/login.html.twig',
            [
                'last_username' => $lastUsername
            ]);
    }


    /**
     * @Route("/deconnexion")
     */
    public function logout()
    {
// CETTE METH PEUT RESTER VIDE IL FAUT JUSTE QUE SA ROUTE EXISTE PR LA PASSER DS LA SECTION LOGOUT DS SECURITY.YAML
    }




}
