<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ProjectBundle\Entity\SettingOption;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;

use JMS\SecurityExtraBundle\Annotation\Secure;
use GuzzleHttp\Client;
use ProjectBundle\Form\Type\AdminOptionJobAvailableType;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\File\MimeType\FileinfoMimeTypeGuesser;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AdminSettingJobAvailableController extends Controller
{
	const ROUTER_PREFIX = 'setting/options';
  const ROUTER_INDEX = 'admin_setting_job_available';
	const ROUTER_CONTROLLER = 'AdminSettingJobAvailable';

	/**
	 * @Secure(roles="ROLE_ADMIN")
	 */
	public function indexAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$repository = $this->getDoctrine()->getRepository(SettingOption::class);
    $em = $this->getDoctrine()->getManager();
    $setting_option = new SettingOption();
		$group_datas = $repository->getDataByCatType('file')->getQuery()->getOneorNullResult();

    if(!$group_datas) {
        $setting_option->setOptionName("job_available_file");
        $setting_option->setOptionTitle("Job Available File");
        $setting_option->setOptionType("file");
        $setting_option->setGroupType("Job Available");
        $setting_option->setCatType("file");
        $em->persist($setting_option);
        $em->flush($setting_option);

      return $this->redirect($this->generateUrl("admin_setting_job_available"));
    }

    $form = $this->createForm(AdminOptionJobAvailableType::class, $group_datas,array('allow_extra_fields'=>true));


    $util->setBackToUrl();
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':index.html.twig', array('group_datas' => $group_datas,"form"=>$form->createView()));
	}

	/**
  * @Secure(roles="ROLE_ADMIN")
  */
  public function updateAction(Request $request)
  {
    $util = $this->container->get('utilities');
		$repository = $this->getDoctrine()->getRepository(SettingOption::class);
    $em = $this->getDoctrine()->getManager();
    $setting_option = new SettingOption();
		$group_datas = $repository->getDataByCatType('file')->getQuery()->getOneorNullResult();

    if(!$group_datas) {
        throw $this -> createNotFoundException('The data doesn\'t exist');
    }
    $form = $this->createForm(AdminOptionJobAvailableType::class, $group_datas,array('allow_extra_fields'=>true));


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $em->persist($group_datas);
            $file = $form['optionValue']->getData();

            if($file){
                $extension = $file->guessExtension();
                $fileName = 'position-available'.date('d-m-Y').'.'.$extension;
                $filePathUpload = $this->container->getParameter('join_us_upload_path');

                try {
                    $file->move($filePathUpload,$fileName);
                    $group_datas->setOptionValue($fileName);
                  //  $group_datas->setFileUploadpath($filePathUpload);

                } catch (FileException $e){
                    //$this->logger->error('failed to upload : ' . $e->getMessage());
                    throw new FileException('Failed to upload file');
                }

            }
            $em->flush();

            $util->setUpdateNotice();
            return $this->redirect($this->generateUrl("admin_setting_job_available"));
        }



	return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':index.html.twig', array("form"=>$form->createView()));
  }

	/**
	 * @Secure(roles="ROLE_ADMIN")
	 */
	public function _databygroupAction(Request $request, $group_data)
	{
		$cat_type = $group_data->getCatType();
		$group_type = $group_data->getGroupType();

		$repository = $this->getDoctrine()->getRepository(SettingOption::class);
		$datas = $repository->getDataByGroup($cat_type, $group_type)->getQuery()->getResult();

		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':_databygroup.html.twig', array('group_data'=>$group_data, 'datas'=>$datas));
	}

	/**
	* @Secure(roles="ROLE_ADMIN")
	*/
	public function downloadFileJobAvailableAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$util->setCkAuthorized();
		$repository = $this->getDoctrine()->getRepository(SettingOption::class);

		$data = $repository->getDataByCatType('file')->getQuery()->getOneorNullResult();
		if (!$data) {
			throw $this->createNotFoundException('This data doesn\'t exist');
		}
		$attach_file = $this->container->getParameter('join_us_upload_path').$data->getOptionValue();

		try{
			$file_name = $data->getOptionValue();
			$response = new Response();
			$response->headers->set('Content-type', mime_content_type($attach_file));
			$response->setContent(file_get_contents($attach_file));
			$response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', $file_name ));
			return $response;
		}
		catch(\Exception $e){
			throw $this->createNotFoundException('This file is already deleted');
		}
	}
}
