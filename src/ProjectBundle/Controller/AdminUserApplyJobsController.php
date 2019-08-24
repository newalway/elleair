<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ProjectBundle\Entity\ApplyJobs;
use ProjectBundle\Entity\AttachFile;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Finder\Finder;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

use JMS\SecurityExtraBundle\Annotation\Secure;
use GuzzleHttp\Client;

use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;


class AdminUserApplyJobsController extends Controller
{
	const ROUTER_INDEX = 'admin_user_apply_jobs';
	const ROUTER_ADD = self::ROUTER_INDEX.'_new';
	const ROUTER_EDIT = self::ROUTER_INDEX.'_edit';
  	const ROUTER_PREFIX = 'contact';
	const ROUTER_CONTROLLER = 'AdminUserApplyJobs';

	protected function getQuerySearchData($arr_query_data)
	{
		$repository = $this->getDoctrine()->getRepository(ApplyJobs::class);
    	$query = $repository->findAllData($arr_query_data);
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
		$query = $this->getQuerySearchData($arr_query_data);
		$paginated = $util->setPaginatedOnPagerfanta($query);

	    $util->setBackToUrl();
	    return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':index.html.twig', array(
			'paginated' =>$paginated
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function viewAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		$util->setCkAuthorized();
    	$data = $em->getRepository(ApplyJobs::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		if($data->getStatus() == 4){
			$data->setStatus(3);
			$em->flush();
		}
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':view.html.twig', array(
			'data' => $data
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function deleteAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		$data = $em->getRepository(ApplyJobs::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }
		$pathToCheck = $this->container->getParameter('join_us_upload_path').$data->getFileUploadName();
		try {

			if (file_exists($pathToCheck))
			{
				unlink($pathToCheck);
				$em->remove($data);
				$em->flush();
			}else{
				echo "File Not Found";
				$em->remove($data);
				$em->flush();
			}

			$util->setRemoveNotice();
		} catch(\Doctrine\DBAL\DBALException $e) {
			$util->setCustomeFlashMessage('warning', $msg="Can't delete ".$data->getTitle());
		}

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
				$data = $em->getRepository(ApplyJobs::class)->find($data_id);

				if ($data) {
					$pathToCheck = $this->container->getParameter('join_us_upload_path').$data->getFileUploadName();
					try {
						if (file_exists($pathToCheck))
						{
							unlink($pathToCheck);
							$em->remove($data);
							$em->flush();
						}else{
							echo "File Not Found";
							$em->remove($data);
							$em->flush();
						}
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
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function _getunreadAction(Request $request)
	{
    	$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();
    	$data = $em->getRepository(ApplyJobs::class)->countBy(['status'=>4]);
		if($data){
			$count_text='<small class="label pull-right bg-yellow">'.$data.'</small>';
	    }else{
			$count_text='';
	    }
    	return new Response($count_text);
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function downloadAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$util->setCkAuthorized();
		$id = $request->get('id');

		$data = $this->getDoctrine()->getRepository(AttachFile::class)->find($id);
		if (!$data) {
			throw $this->createNotFoundException('This data doesn\'t exist');
		}
		$attach_file = $this->container->getParameter('join_us_upload_path').$data->getFileUploadname();
		try{
			$file_name = $data->getFileUploadname();
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

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function pdfAction(Request $request)
	{
		 $id = $request->get('id');
		 $util = $this->container->get('utilities');
		 $em = $this->getDoctrine()->getManager();

		 $util->setCkAuthorized();
		 $data = $em->getRepository(ApplyJobs::class)->find($id);
		 if (!$data) { throw $this->createNotFoundException('No data found'); }

		$snappy = $this->get('knp_snappy.pdf');
		$headerHtml = $this->renderView('ProjectBundle:AdminUserApplyJobs:header-pdf.html.twig');
		$footerHtml = $this->renderView('ProjectBundle:AdminUserApplyJobs:footer-pdf.html.twig');
		$html = $this->renderView('ProjectBundle:AdminUserApplyJobs:pdf.html.twig', array('data'=>$data));
		// $snappy->setOption('header-html', $headerHtml);
		// $snappy->setOption('footer-right', '[page]/[toPage]');
		// $snappy->setOption('footer-html', $footerHtml);
		$options = [
			'header-html' => $headerHtml,
			'footer-html' => $footerHtml,
			'footer-right'=> '[page]/[toPage]',
		];



		$filename = 'profile-'.$data->getId().'-'.date('YmdHis').'.pdf';





		return new Response(
		    $snappy->getOutputFromHtml($html,$options,true),
					200,
		    array(
		      'Content-Type'          => 'application/pdf',
		      'Content-Disposition'   => 'inline; filename="'.$filename.'"'
		    )
		);
	}
}
