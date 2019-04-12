<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 *
 * @Route("/utilisateur")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/{id}", requirements={"id": "\d+"})
     */
    public function index(User $user)
    {
        $repository = $this->getDoctrine()->getRepository(Contact::class);
        $contacts = $repository->findBy([], ['nom' => 'ASC']);

        return $this->render('user/index.html.twig', [
            'contacts' => $contacts,
            'user' => $user
        ]);
    }


}
