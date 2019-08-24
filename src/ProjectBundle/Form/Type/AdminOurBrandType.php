<?php

namespace ProjectBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use ProjectBundle\Entity\OurClient;
use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class AdminOurBrandType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        // $builder->add('translations', 'A2lix\TranslationFormBundle\Form\Type\TranslationsType', array(
        //     'fields' => array(
        //         'title' => array(
        //             'field_type' => TextType::class,
        //             'label' => '* Title',
        //             'locale_options' => array(),
        //             'constraints' => array(
        //                 new NotBlank(array('message' => 'Please enter title')))
        //         ),
        //     ),
        //     'exclude_fields' => array('description')
        // ));

        $builder->add('translations', 'A2lix\TranslationFormBundle\Form\Type\TranslationsType', array(
            'fields' => array(
                'title' => array(
                    'field_type' => TextType::class,
                    'label' => '* Title',
                    'locale_options' => array(),
                    'constraints' => array(
                        new NotBlank(array('message' => 'Please enter title')))
                ),
                'shortDesc' => array(
                    'field_type' => TextType::class,
                    'label' => 'Short Description',
                    'locale_options' => array(),
                ),
                'description' => array(
                    'field_type' => CKEditorType::class,
                    'label' => 'Description',
                    'locale_options' => array(),
                ),
            )
        ));

        $builder->add('image', TextType::class, array(
                        'attr' => array('class' => 'form-control'),
                        'required' => false,
        ));

        $builder->add('imageBanner', TextType::class, array(
                        'attr' => array('class' => 'form-control'),
                        'required' => false,
        ));

        $builder->add('imageLogo', TextType::class, array(
                        'attr' => array('class' => 'form-control'),
                        'required' => false,
        ));
        
        // $builder->add('imageLabel', TextType::class, array(
        //                 'attr' => array('class' => 'form-control'),
        //                 'required' => false,
        // ));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.goon-thailand.com/en/api/product-cat-data');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        // If using JSON...
        $data = json_decode($response);
        if(!$data){
            $data = null;
        }

        $builder->add('category', ChoiceType::class, array(
            'attr'=>array('class' => ''),
            'label_attr' => array('class' => ''),
            'required' => true,
            'choices' => $data->data,
            'choice_value' => function ($value) {
               return $value->Id;
              },
             'choice_label' => function ($value)
             {
                 return $value->Title;
             },

            // used to render a select box, check boxes or radios
            'multiple' => true,
            'expanded' => true,
        ));

        // $builder->add('ourBrandVideos', CollectionType::class, [
        //     'entry_type'    => TextType::class,
        //     'allow_add'    => true,
        //     'allow_delete' => true,
        //     'prototype'    => true,
        //     'attr'         => [
        //         'class' => "youtube-collection",
        //     ],
        // ]);
// AdminOurBrandVideosType
        $builder->add('ourBrandVideos', CollectionType::class,
        array(
                'entry_type'   => AdminOurBrandVideosType::class,
                'entry_options' => array(
                        'label' => ' ',
                ),
                'label'        => 'Our Brand Video',
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'required' => false,
                'attr' => array(
                        'class' => 'youtube-collection',
                )
            ));


        $builder->add('status', ChoiceType::class, array(
                        'choices' => array('Publish' => '1', 'Unpublish' => '0'),
                        'expanded' => true,
                        'multiple' => false,
                        'attr' => array('class' => 'form-control-static'),
                        'constraints' => array(
                            new NotBlank(array('message' => 'Enter a status')))
        ));

        $builder->add('save_and_add', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
        $builder->add('save_and_edit', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
        $builder->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
    }

}
