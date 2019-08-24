<?php

namespace ProjectBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


use Doctrine\ORM\EntityRepository;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;

// use Symfony\Component\HttpFoundation\File\Exception\FileException;
// use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\File;

class AdminOptionJobAvailableType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder->add('optionValue',FileType::class, array(
            'attr' => array('class'=>'form-control'),
            'required' => false,
            'mapped' => false,
            'constraints' => array(
                // new NotBlank(array('message' => 'error.fileupload'))),
                 // new File(['maxSize' => '10k']))
                new File([
                      'maxSize' => '2048k',
                      'mimeTypes' => [
                          'application/pdf',
                          'application/x-pdf',
                          // 'image/png',
                          // 'image/jpeg',
                          // 'application/msword',
                          // 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                          // 'application/vnd.openxmlformats-officedocument.wordprocessingml.template'

                      ],
                      // 'uploadNoFileErrorMessage'=> 'No File Upload.',
                      'notFoundMessage' => 'The file could not be found.',
                      'mimeTypesMessage' => 'Please upload a .PDF  document.',
                      'maxSizeMessage' => 'Please upload a valid size not over 2048k.',

                  ]),
                new NotBlank(['message' => 'error.fileupload'])
              )
        ));

    }

}
