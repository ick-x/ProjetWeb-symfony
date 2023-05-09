<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\CreateContactFormType;
use App\Helper;
use App\Repository\ContactRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\From;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    public function __construct(private Helper $helper){}

    #[Route('/contact', name: 'app_contact')]
    public function index(ContactRepository $repository): Response
    {

        $contactList = $repository->findByUser($this->getUser());

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'contact_list'=>$contactList
        ]);
    }
    #[Route('/contact/add', name: 'app_add_contact')]
    public function addContact(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CreateContactFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){
            $contact = new Contact();
            $contact->setContactAddress($form->get("contactAddress")->getData());
            $contact->setContactMail($form->get("contactMail")->getData());
            $contact->setContactPhone($form->get("contactPhone")->getData());
            $contact->setContactLastName($form->get("contactLastName")->getData());
            $contact->setContactName($form->get("contactName")->getData());
            $contact->setUser($this->getUser());

            $entityManager->persist($contact);
            $entityManager->flush();
            return $this->redirectToRoute('app_add_contact');
        }

        return $this->render("contact/add.html.twig",[
            "createContactForm"=>$form->createView()
        ]);
    }
}
