<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/{id}")
     */
    public function index(Contact $contacts)
    {
        $repository = $this->getDoctrine()->getRepository(Contact::class);
        $contacts = $repository->findBy([], ['name' => 'ASC']);

        return $this->render('contact/index.html.twig', [
            'contact' => $contacts,
        ]);
    }

}
