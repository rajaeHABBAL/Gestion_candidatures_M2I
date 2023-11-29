<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $request, EntityManagerInterface $entity,MailerInterface $mailer): Response
    {
        $contact=new Contact();
        if($this->getUser()){
            $contact->setNom($this->getUser()->getUsername())
                    ->setEmail($this->getUser()->getEmail());
        }
        $form=$this->createForm(ContactType::class,$contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $contact=$form->getData();
            $entity->persist($contact);
            $entity->flush();
            $email = (new TemplatedEmail())
            ->from($contact->getEmail())
            ->to('adminApp@gmail.com')
            ->subject($contact->getSujet())
             // path of the Twig template to render
            ->htmlTemplate('emails/contact.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'contact' => $contact,
                
            ]);

            $mailer->send($email);
            $this->addFlash(
                'success',
                'votre demande à ete envoyer avec succés'
            );
            return $this->redirectToRoute('app_candidats');
        }
        return $this->render('contact/index.html.twig',[
            'form'=>$form->createView(),
        ]);
    }
}
