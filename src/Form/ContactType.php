<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username',TextType::class,[
                'attr'=>[
                    'class'=>'form-control form-control-user',
                    'minlength'=>'2',
                    'maxlength'=>'50',
                    'placeholder' => 'Entrez un nom',
                ],
                'label'=>'Nom',
                'label_attr'=>[
                    'class'=>'form-label mt-4'
                ],
                
            ])
            ->add('email',EmailType::class,[
                'attr'=>[
                    'class'=>'form-control form-control-user',
                    'minlength'=>'2',
                    'maxlength'=>'50',
                    'placeholder' => 'Entrez un email',
                ],
                'label'=>'Email',
                'label_attr'=>[
                    'class'=>'form-label mt-4'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'L\'adresse e-mail ne peut pas être vide.']),
                    new Email(['message' => 'L\'adresse e-mail "{{ value }}" n\'est pas valide.']),
                ],
            ])
            ->add('sujet',TextType::class,[
                'attr'=>[
                    'class'=>'form-control form-control-user',
                    'minlength'=>'2',
                    'maxlength'=>'100',
                    'placeholder' => 'Entrez un nom',
                ],
                'label'=>'Sujet',
                'label_attr'=>[
                    'class'=>'form-label mt-4'
                ],
                
            ])
            ->add('message',TextareaType::class,[
                'attr'=>[
                    'class'=>'form-control form-control-user',
                    'placeholder' => 'Entrez un nom',
                ],
                'label'=>'Message',
                'label_attr'=>[
                    'class'=>'form-label mt-4'
                ],
                
            ])
            ->add('submit',SubmitType::class,[
                'attr'=>[
                    'class'=>'btn btn-primary btn-user btn-block mt-4',
                    
                ],
                'label'=>'Envoyer',
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
