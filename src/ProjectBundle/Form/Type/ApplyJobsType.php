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

use ProjectBundle\Entity\Jobs;
use ProjectBundle\Entity\ApplyJobs;
use Doctrine\ORM\EntityRepository;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;

// use Symfony\Component\HttpFoundation\File\Exception\FileException;
// use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ApplyJobsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('firstName',TextType::class, array(
          'required'=>false,
          'label' => 'elleair.jobs_register.title.fname',
          'attr'=>array('class'=>'form-control','placeholder' => 'elleair.jobs_register.title.fname'),
          'constraints' => array(new NotBlank(array('message' => 'error.firstname')))
        ));

        $builder->add('lastName',TextType::class, array(
          'required'=>false,
          'label' => 'elleair.jobs_register.title.lname',
          'attr'=>array('class'=>'form-control','placeholder' => 'elleair.jobs_register.title.lname'),
          'constraints' => array(new NotBlank(array('message' => 'error.lastname')))
        ));

        // $builder->add('firstNameEN',TextType::class, array(
        //   'required'=>false,
        //   'attr'=>array('class'=>'form-control','placeholder' => 'member.personal.name'),
        //   'constraints' => array(new NotBlank(array('message' => 'error.name')))
        // ));
        //
        // $builder->add('lastNameEN',TextType::class, array(
        //   'required'=>false,
        //   'attr'=>array('class'=>'form-control','placeholder' => 'member.personal.lastname'),
        //   'constraints' => array(new NotBlank(array('message' => 'error.lastname')))
        // ));

        $builder->add('phone',TextType::class, array(
          'required'=>false,
          'label' => 'elleair.jobs_register.title.phone',
          'attr'=>array('class'=>'form-control','placeholder' => 'Ex. 098-8888888'),
          'constraints' => array(new NotBlank(array('message' => 'error.phone')))
        ));



        $builder->add('email',TextType::class, array(
          'required'=>false,
          'label' => 'elleair.jobs_register.title.email',
          'attr'=>array('class'=>'form-control','placeholder' => 'email@example.com'),
          'constraints' => array(new NotBlank(array('message' => 'error.email')),
                                 new Email(array('message' => 'error.email.wrong')))
        ));

        // $builder->add('message',TextareaType::class, array(
        //   'required'=>false,
        //   'attr'=>array(
        //     'class'=>'form-control',
        //     'rows'=>'5',
        //     'cols'=>'1',
        //     'placeholder' => 'contact.message'
        //   ),
        //   'constraints' => array(new NotBlank(array('message' => 'error.message')))
        // ));

        $builder->add('address', CollectionType::class,
        array(
                'entry_type'   => AddressType::class,
                'entry_options' => array(
                        'label' => ' ',
                ),
                'label'        => 'address',
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'required' => false,
                'attr' => array(
                        'class' => 'address-collection',
                )
            ));

        $builder->add('attachFile', CollectionType::class,
        array(
                'entry_type'   => AttachFileType::class,
                'entry_options' => array(
                        'label' => ' ',
                ),
                'label'        => 'AttachFile',
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'required' => false,
                'mapped' =>false,
                'attr' => array(
                        'class' => 'file-upload-collection',
                )
            ));

        $builder->add('languageSkill', CollectionType::class,
        array(
                'entry_type'   => LanguageSkillType::class,
                'entry_options' => array(
                        'label' => ' ',
                ),
                'label'        => 'LanguageSkillType',
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'required' => false,
                'attr' => array(
                        'class' => 'language-skill-collection',
                )
            ));

        $builder->add('educational', CollectionType::class,
        array(
                'entry_type'   => EducationalType::class,
                'entry_options' => array(
                        'label' => ' ',
                ),
                'label'        => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'required' => false,
                'attr' => array(
                        'class' => 'educational-collection table',
                )
            ));

        $builder->add('computerSkill', CollectionType::class,
        array(
                'entry_type'   => ComputerSkillType::class,
                'entry_options' => array(
                        'label' => ' ',
                ),
                'label'        => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'required' => false,
                'attr' => array(
                        'class' => 'computer-skill-collection',
                )
            ));

        $builder->add('otherSkill', CollectionType::class,
        array(
                'entry_type'   => OtherSkillType::class,
                'entry_options' => array(
                        'label' => ' ',
                ),
                'label'        => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'required' => false,
                'attr' => array(
                        'class' => 'other-skill-collection',
                )
            ));
        $builder->add('workExperience', CollectionType::class,
        array(
                'entry_type'   => WorkExperienceType::class,
                'entry_options' => array(
                        'label' => ' ',
                ),
                'label'        => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'required' => false,
                'attr' => array(
                        'class' => 'work-experience-collection table',
                )
            ));
        $builder->add('training', CollectionType::class,
        array(
                'entry_type'   => TrainingType::class,
                'entry_options' => array(
                        'label' => ' ',
                ),
                'label'        => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'required' => false,
                'attr' => array(
                        'class' => 'training-collection table',
                )
            ));
        $builder->add('jobs', EntityType::class, array(
            'attr'=>array('class'=>''),
            'label' => 'elleair.jobs_register.title.jobs',
            'label_attr' => array('class' => ''),
            'placeholder' => false,
            'required' => false,

            // query choices from this entity
            'class' => Jobs::class,
            'query_builder' => function (EntityRepository $er) use ($options) {
              return $er->findAllDataActiveById($options['attr']['job_id']);
            },
            'choice_label' => function ($jobs) {
              return $jobs->getTitle();
            },

            'multiple' => false,
            'expanded' => false,
            'constraints' => array(
                new NotBlank(array('message' => 'error.job.position'))),
        ));

        // $builder->add('jobs', EntityType::class, array(
        //     'attr'=>array('class'=>''),
        //     'label' => 'elleair.jobs_register.title.jobs',
        //     'label_attr' => array('class' => ''),
        //     'placeholder' => false,
        //     'required' => false,
        //
        //     // query choices from this entity
        //     'class' => Jobs::class,
        //     'query_builder' => function (EntityRepository $er)  {
        //       return $er->findAllDataActive();
        //     },
        //     'choice_label' => function ($jobs) {
        //       return $jobs->getTitle();
        //     },
        //
        //     'multiple' => false,
        //     'expanded' => false,
        //     'constraints' => array(
        //         new NotBlank(array('message' => 'error.job.position'))),
        // ));
    }

}
