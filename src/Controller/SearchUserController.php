<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SearchUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SearchUserController
 * @package App\Controller
 *
 * @Route("/recherche")
 */
class SearchUserController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function searchUser(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findBy([], ['lastname' => 'ASC']);

        $form =$this->createForm(SearchUserType::class, $user);

        $form->handleRequest($request);

        return $this->render('search_user/searchUser.html.twig',
        [
            'form' => $form->createView(),
            'users' => $user
        ]);
    }
}
