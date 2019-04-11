<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContactController
 * @package App\Controller
 *
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/{id}", requirements={"id": "\d+"})
     */
    public function index(Contact $contact)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $contacts = $repository->findBy([], ['nom' => 'ASC']);

        return $this->render('contact/index.html.twig', [
            'contact' => $contacts
        ]);
    }

}
