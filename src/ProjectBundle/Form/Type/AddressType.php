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

class AddressType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('houseNumber',TextType::class, array(
          'required'=>false,
          'label' => 'elleair.jobs_register.title.house_number',
          'attr'=>array('class'=>'form-control','placeholder' => 'elleair.jobs_register.title.house_number'),
          'constraints' => array(new NotBlank(array('message' => 'error.houseNumber')))
        ));

        $builder->add('lane',TextType::class, array(
          'required'=>false,
          'label' => 'elleair.jobs_register.title.lane',
          'attr'=>array('class'=>'form-control','placeholder' => 'elleair.jobs_register.title.lane'),
          // 'constraints' => array(new NotBlank(array('message' => 'error.lane')))
        ));

        $builder->add('road',TextType::class, array(
          'required'=>false,
          'label' => 'elleair.jobs_register.title.road',
          'attr'=>array('class'=>'form-control','placeholder' => 'elleair.jobs_register.title.road'),
          // 'constraints' => array(new NotBlank(array('message' => 'error.road')))
        ));

        $builder->add('subDistrict',TextType::class, array(
          'required'=>false,
          'label' => 'elleair.jobs_register.title.sub_district',
          'attr'=>array('class'=>'form-control','placeholder' => 'elleair.jobs_register.title.sub_district'),
          'constraints' => array(new NotBlank(array('message' => 'error.sub_district')))
        ));

        $builder->add('district',TextType::class, array(
          'required'=>false,
          'label' => 'elleair.jobs_register.title.district',
          'attr'=>array('class'=>'form-control','placeholder' => 'elleair.jobs_register.title.district'),
          'constraints' => array(new NotBlank(array('message' => 'error.district')))
        ));

        $builder->add('province',TextType::class, array(
          'required'=>false,
          'label' => 'elleair.jobs_register.title.province',
          'attr'=>array('class'=>'form-control','placeholder' => 'elleair.jobs_register.title.province'),
          'constraints' => array(new NotBlank(array('message' => 'error.province')))
        ));

        $builder->add('postCode',TextType::class, array(
          'required'=>false,
          'label' => 'elleair.jobs_register.title.postal_code',
          'attr'=>array('class'=>'form-control','placeholder' => 'elleair.jobs_register.title.postal_code'),
          'constraints' => array(new NotBlank(array('message' => 'error.postcode')))
        ));

        $builder->add('addressType',HiddenType::class, array(
          'required'=>false,
          'attr'=>array('class'=>'form-control'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProjectBundle\Entity\Address'
        ));
    }
    public function getBlockPrefix()
{
    return 'AddressType';
}

}
