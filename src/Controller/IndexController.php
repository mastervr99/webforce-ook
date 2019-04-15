<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Entity\User;
use App\Form\ChatType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('index/index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("chat/{id}")
     */
    public function chat( Request $request, User $userRecoit)
    {
        /**
         * SUR LA PAGE CONTACT AJT UN BTN CHAT QUI REDIRIGE VERS UNE NVELLE PAGE CHAT
         *
         * RECUPERER DS L URL L ID DU USER_RECOIT
         *
         */
        $em = $this->getDoctrine()->getManager();

        $message= new Messages();
        $message->setDatePublication(new \DateTime());
        $message->setUserEnvoi($this->getUser());
        $message->setUserRecoit($userRecoit);

        $form = $this->createForm(ChatType::class);


        if ($form->isSubmitted()) {
            //PR LE METTRE EN BDD QD LE FORM EST SUBMIT
            $em->persist($message);
            $em->flush();

            //AFFICHER LE MESS AVEC ADDFLASH???
            $this->addFlash('', get);
        }

        return $this->render(
            'index/chat.html.twig',
            ['form' => $form->createView()]
        );

    }
}
