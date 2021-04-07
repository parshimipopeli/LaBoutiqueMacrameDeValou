<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    /**
     * @Route("/compte/adresse", name="account_address")
     */
    public function index(): Response
    {

        return $this->render('account/address.html.twig');
    }

     /**
     * @Route("/compte/ajouter-une-adresse", name="account_address_add")
     */
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $address->setUser($this->getUser());

            $em->persist($address);
            $em->flush();
            return $this->redirectToRoute('account_address');
        }
        return $this->render('account/address_add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
