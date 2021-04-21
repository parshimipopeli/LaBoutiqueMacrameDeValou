<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder): Response
    {
//        instanciation de la classe user
        $user = new User();
//        Création du formulaire RegistreType
        $form = $this->createForm(RegisterType::class, $user);

//        on demande au formulaire d'ecouter la requette entrante
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $password = $encoder->encodePassword($user, $user->getPassword());
            $user -> setPassword($password);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('home/index.html.twig');

        }


        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
