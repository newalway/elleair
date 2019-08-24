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
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use ProjectBundle\Entity\Jobs;
use ProjectBundle\Entity\ApplyJobs;
use Doctrine\ORM\EntityRepository;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;

// use Symfony\Component\HttpFoundation\File\Exception\FileException;
// use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\File;

class WorkExperienceType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('durationFromTo',TextType::class, array(
          'required'=>false,
          'label' => 'elleair.jobs_register.title.house_number',
          'attr'=>array('class'=>'form-control'),
          // 'constraints' => array(new NotBlank(array('message' => 'error.houseNumber')))
        ));

        $builder->add('workPlace',TextType::class, array(
          'required'=>false,
          'label' => 'elleair.jobs_register.title.house_number',
          'attr'=>array('class'=>'form-control'),
         // 'constraints' => array(new NotBlank(array('message' => 'error.houseNumber')))
        ));
        $builder->add('position',TextType::class, array(
          'required'=>false,
          'label' => 'elleair.jobs_register.title.house_number',
          'attr'=>array('class'=>'form-control'),
          // 'constraints' => array(new NotBlank(array('message' => 'error.houseNumber')))
        ));

    

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProjectBundle\Entity\WorkExperience'
        ));
    }
    public function getBlockPrefix()
{
    return 'WorkExperienceType';
}

}
