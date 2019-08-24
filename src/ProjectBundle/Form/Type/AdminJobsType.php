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
use Symfony\Component\HttpFoundation\RequestStack;

use ProjectBundle\Entity\JobLocation;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;





class AdminJobsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('translations', 'A2lix\TranslationFormBundle\Form\Type\TranslationsType', array(
            'fields' => array(
                'title' => array(
                    'field_type' => TextType::class,
                    'label' => '* Title',
                    'locale_options' => array(),
                    'constraints' => array(
                        new NotBlank(array('message' => 'Please enter title')))
                ),
                'description' => array(
                    'field_type' => CKEditorType::class,
                    'label' => ' Description (Responsibility)',
                    'locale_options' => array()
                ),
                'qualification' => array(
                    'field_type' => CKEditorType::class,
                    'label' => ' Qualification',
                    'locale_options' => array()
                ),
                'benefitWelfares' => array(
                    'field_type' => CKEditorType::class,
                    'label' => ' Benefit / Welfares',
                    'locale_options' => array()
                ),

            ),
            // 'exclude_fields' => array('shortDesc')
        ));
        $builder->add('public_date', DateType::class, array(
                        'required' => true,
                        'input'  => 'datetime',
                        'widget' => 'single_text',
                        'attr' => array('class' => 'form-control-static'),
                        'constraints' => array(
                            new NotBlank(array('message' => 'Enter a publish date')))
        ));

        $builder->add('jobPositionOpening', ChoiceType::class, array(
                    'choices' => array( 'Please choose job position opening.' => NULL,
                        '1 position' => 1,
                        '2 positions'=> 2,
                        '3 positions'=> 3,
                        '4 positions'=> 4,
                        '5 positions'=> 5,
                        '6 positions'=> 6,
                        '7 positions'=> 7,
                        '8 positions'=> 8,
                        '9 positions'=> 9,
                        '10 positions'=> 10,
                        'N/A'=> 11,
                    ),
                    // 'expanded' => true,
                    // 'multiple' => false,
                    'attr'=>array('class' => 'form-control'),
                    'constraints' => array(
                        new NotBlank(array('message' => '*** Please choose job position opening.')))
        ));

        $builder->add('jobLocation', EntityType::class, array(
            'attr'=>array('class' => ''),
            'label_attr' => array('class' => ''),
            'required' => true,
            'class' => JobLocation::class,
            'placeholder' => 'Choose an Location',

            'choice_label' => function ($job_location) {
                return $job_location->getTitle();
            },
            // used to render a select box, check boxes or radios
            'multiple' => false,
            'expanded' => false,
        ));


        $builder->add('status', ChoiceType::class, array(
                        'choices' => array('Publish' => '1', 'Unpublish' => '0'),
                        'expanded' => true,
                        'multiple' => false,
                        'constraints' => array(
                            new NotBlank(array('message' => 'Enter a status')))
        ));



        $builder->add('save_and_add', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
        $builder->add('save_and_edit', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
        $builder->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
    }

}
