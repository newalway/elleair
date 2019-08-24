<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ProjectBundle\Entity\OurBrand;
use ProjectBundle\Entity\OurBrandVideos;

use ProjectBundle\Form\Type\AdminOurBrandType;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;

use JMS\SecurityExtraBundle\Annotation\Secure;
use GuzzleHttp\Client;

class AdminOurBrandController extends Controller
{
	const ROUTER_INDEX = 'admin_our_brand';
	const ROUTER_ADD = self::ROUTER_INDEX.'_new';
	const ROUTER_EDIT = self::ROUTER_INDEX.'_edit';
  	const ROUTER_PREFIX = 'our_client';
	const ROUTER_CONTROLLER = 'AdminOurBrand';

	protected function getQuerySearchData($arr_query_data,$locale)
	{
		$repository = $this->getDoctrine()->getRepository(OurBrand::class);
    	$query = $repository->findAllData();
		return $query;
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function indexAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$session = $request->getSession();
		try {
		  	$acctoken = $util->getAccessToken();
		} catch(\Exception $e) {
		  return $this->redirectToRoute('admin_user_generate_token');
		}



		$arr_query_data = $util->prepare_query_data($request);
		$query = $this->getQuerySearchData($arr_query_data,$request->getLocale());
		$paginated = $util->setPaginatedOnPagerfanta($query);

		$util->setBackToUrl();
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':index.html.twig', array(
				'paginated' =>$paginated
		));
	}

	/**
  	* @Secure(roles="ROLE_EDITOR")
  	*/
	public function newAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$util->setCkAuthorized();
		$form = $this->createForm(AdminOurBrandType::class, new OurBrand(),array('allow_extra_fields'=>true));
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':new.html.twig', array(
			'form'=>$form->createView()
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function createAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		$data = new OurBrand();
		$form = $this->createForm(AdminOurBrandType::class, $data,array('allow_extra_fields'=>true));
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em->persist($data);
			$this->saveOurBrandVideos($data);
			$em->flush();

			$util->setCreateNotice();
			$redirect_uri = $util->getRedirectUriSaveBtn($form, $data, self::ROUTER_INDEX, self::ROUTER_ADD, self::ROUTER_EDIT);
			return $this->redirect($redirect_uri);
		}
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':new.html.twig', array(
			'form'=>$form->createView()
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function editAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$util->setCkAuthorized();
		$data = $this->getDoctrine()->getRepository(OurBrand::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$form = $this->createForm(AdminOurBrandType::class, $data,array('allow_extra_fields'=>true));
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':edit.html.twig', array(
			'form'=>$form->createview()
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function updateAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		$data = $em->getRepository(OurBrand::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$form = $this->createForm(AdminOurBrandType::class, $data,array('allow_extra_fields'=>true));
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			if($request->get('removefileimage')==1){
				$data->removeImage();
			}
			if($request->get('removefileimageBanner')==1){
				$data->removeImageBanner();
			}
			if($request->get('removefileimageLogo')==1){
				$data->removeImageLogo();
			}
			if($request->get('removefileimageLabel')==1){
				$data->removeImageLabel();
			}



			$this->saveOurBrandVideos($data);

			$em->flush();

			$util->setUpdateNotice();
			$redirect_uri = $util->getRedirectUriSaveBtn($form, $data, self::ROUTER_INDEX, self::ROUTER_ADD, self::ROUTER_EDIT);
			return $this->redirect($redirect_uri);
		}
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':edit.html.twig', array('form'=>$form->createview()));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function deleteAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		$data = $em->getRepository(OurBrand::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$em->remove($data);
		$em->flush();

		$util->setRemoveNotice();
		return $this->redirect($util->getBackToUrl(self::ROUTER_INDEX));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function group_deleteAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		$data_ids = $request->get('data_ids');

		if ($data_ids) {
			$flg_del = false;
			foreach ($data_ids as $data_id) {
				$data = $em->getRepository(OurBrand::class)->find($data_id);
				if ($data) {
					try {
						$em->remove($data);
						$em->flush();
						$flg_del = true;
					} catch(\Doctrine\DBAL\DBALException $e) {
						$util->setCustomeFlashMessage('warning', $msg="Can't delete ".$data->getTitle());
					}
				}
			}
			if ($flg_del) {
				$util->setRemoveNotice();
			}
		}
		return $this->redirect($util->getBackToUrl(self::ROUTER_INDEX));
	}

	/**
	* @Secure(roles="ROLE_ADMIN")
	*/
	public function group_enableAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();
		$data_ids = $request->get('data_ids');
		if ($data_ids) {
			$flg_pub = false;
			foreach ($data_ids as $data_id) {
				$data = $em->getRepository(OurBrand::class)->find($data_id);
				if ($data) {
					$data->setStatus(1);
					$flg_pub = true;
				}
			}
			try {
				$em->flush();
			} catch(\Exception $e) {
				$util->setCustomeFlashMessage('warning', $msg="Can't enable ");
			}
			if($flg_pub){
				$util->setCustomeFlashMessage('notice', $msg="Published ");
			}
		}
		return $this->redirect($util->getBackToUrl(self::ROUTER_INDEX));
	}

	/**
	* @Secure(roles="ROLE_ADMIN")
	*/
	public function group_disableAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();
		$data_ids = $request->get('data_ids');
		if ($data_ids) {
			$flg_pub = false;
			foreach ($data_ids as $data_id) {
				$data = $em->getRepository(OurBrand::class)->find($data_id);
				if ($data) {
					$data->setStatus(0);
					$flg_pub = true;
				}
			}
			try {
				$em->flush();
			} catch(\Exception $e) {
				$util->setCustomeFlashMessage('warning', $msg="Can't disable ");
			}
			if ($flg_pub) {
				$util->setCustomeFlashMessage('notice', $msg="Unpublished ");
			}
		}
		return $this->redirect($util->getBackToUrl(self::ROUTER_INDEX));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function sortAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$arr_query_data = $util->prepare_query_data($request);
		$datas = $this->getQuerySearchData($arr_query_data,$request->getLocale())->getQuery()->getResult();
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':sort.html.twig', array('datas' =>$datas));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function sort_prosessAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		$i=0;
		$sorted = $request->get('sort');
		if ($sorted) {
			foreach ($sorted as $data_id) {
				$data = $em->getRepository(OurBrand::class)->find($data_id);
				if ($data) {
					$i=$i+1;
					$data->setPosition($i);
				}
			}
			try {
				$em->flush();
				$status='complete';
			} catch(\Exception $e) {
				$status='error';
			}
			return new Response($status);
		}
	}


	public function saveOurBrandVideos(OurBrand $ourBrand)
	{
		$util = $this->container->get('utilities');
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$em = $this->getDoctrine()->getManager();

		$our_brand_video_request = $ourBrand->getOurBrandVideos();
		$our_brand_video_in_our_brand = $em->getRepository(OurBrandVideos::class)->findByOurBrand($ourBrand);
		 if(count($our_brand_video_in_our_brand) > 0){
			 foreach ($our_brand_video_in_our_brand as $our_brand_video_old) {
				 $em->remove($our_brand_video_old);
			 }
			 foreach ($our_brand_video_request as  $our_brand_video) {
						$video = $our_brand_video->getVideo();
					  $video_type = $util->videoType($video);

					  if($video_type != 'unknown'){
						  if($video_type == 'youtube'){
							  // Youtube Json format
							  $json_url = $util->youtube_json_url($video);
							  $youtube_video_id = $util->youtube_video_id($video);
							  $oembed_json = json_decode($util->curl_get($json_url));

							  if($oembed_json){
								  $our_brand_video->setVideoId($youtube_video_id);
								  $our_brand_video->setVideoEmbed($oembed_json->html);
								  $our_brand_video->setVideoWidth($oembed_json->width);
								  $our_brand_video->getVideoHeight($oembed_json->height);
								  $our_brand_video->setVideoDuration(null);
								  $our_brand_video->setThumbnailUrl($oembed_json->thumbnail_url);
								  $our_brand_video->setThumbnailWidth($oembed_json->thumbnail_width);
								  $our_brand_video->setThumbnailHeight($oembed_json->thumbnail_height);
								  $our_brand_video->setThumbnailUrlPlayButton($oembed_json->thumbnail_url);
								  $our_brand_video->setOurBrand($ourBrand);
								  // if(empty($form_data->getTitle())){
								  // 	$data->setTitle($oembed_json->title);
								  // }

							  }else{
								  $util->setCustomeFlashMessage('warning', $msg="The URL for this video is not valid.");
								  $redirect_uri = $this->generateUrl(self::ROUTER_ADD);
							  }
						  }
					  }



				 $em->persist($our_brand_video);
			 }
			 $em->flush();

		 }else{
			 foreach ($our_brand_video_request as  $our_brand_video) {
						$video = $our_brand_video->getVideo();
					  $video_type = $util->videoType($video);

					  if($video_type != 'unknown'){
						  if($video_type == 'youtube'){
							  // Youtube Json format
							  $json_url = $util->youtube_json_url($video);
							  $youtube_video_id = $util->youtube_video_id($video);
							  $oembed_json = json_decode($util->curl_get($json_url));

							  if($oembed_json){
								  $our_brand_video->setVideoId($youtube_video_id);
								  $our_brand_video->setVideoEmbed($oembed_json->html);
								  $our_brand_video->setVideoWidth($oembed_json->width);
								  $our_brand_video->getVideoHeight($oembed_json->height);
								  $our_brand_video->setVideoDuration(null);
								  $our_brand_video->setThumbnailUrl($oembed_json->thumbnail_url);
								  $our_brand_video->setThumbnailWidth($oembed_json->thumbnail_width);
								  $our_brand_video->setThumbnailHeight($oembed_json->thumbnail_height);
								  $our_brand_video->setThumbnailUrlPlayButton($oembed_json->thumbnail_url);
								  $our_brand_video->setOurBrand($ourBrand);
								  // if(empty($form_data->getTitle())){
								  // 	$data->setTitle($oembed_json->title);
								  // }

							  }else{
								  $util->setCustomeFlashMessage('warning', $msg="The URL for this video is not valid.");
								  $redirect_uri = $this->generateUrl(self::ROUTER_ADD);
							  }
						  }
					  }
				 $em->persist($our_brand_video);
			 }
			 $em->flush();
		 }

	}

}
