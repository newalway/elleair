<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Doctrine\ORM\EntityManagerInterface;
use ProjectBundle\Entity\User;
use ProjectBundle\Entity\Blog;
use ProjectBundle\Entity\BlogImage;
use ProjectBundle\Entity\BrandType;
use ProjectBundle\Entity\Brand;
use ProjectBundle\Entity\Product;
use ProjectBundle\Entity\Promotion;
use ProjectBundle\Entity\Banner;
use ProjectBundle\Entity\Contact;
use ProjectBundle\Entity\SettingOption;
use ProjectBundle\Entity\Authentication;
use ProjectBundle\Entity\Pages;
use ProjectBundle\Entity\Showroom;
use ProjectBundle\Entity\OurClient;
use ProjectBundle\Entity\CustomerPaymentBankTransfer;
use ProjectBundle\Entity\CustomerOrder;
use ProjectBundle\Entity\CustomerOrderDelivery;
use ProjectBundle\Entity\BankAccount;
use ProjectBundle\Entity\CustomerOrderItem;
use ProjectBundle\Entity\History;
use ProjectBundle\Entity\Location;
use ProjectBundle\Entity\ProductCategory;
use ProjectBundle\Entity\TrackingNumber;
use ProjectBundle\Entity\OurBrand;



use ProjectBundle\Entity\News;
use ProjectBundle\Entity\NewsImage;
use ProjectBundle\Entity\NewsCategory;

use ProjectBundle\Entity\Jobs;
use ProjectBundle\Entity\JobLocation;
use ProjectBundle\Entity\ApplyJobs;
use ProjectBundle\Entity\Address;
use ProjectBundle\Entity\AttachFile;
use ProjectBundle\Entity\LanguageSkill;



use ProjectBundle\Form\Type\CustomerRegisterType;
use ProjectBundle\Form\Type\CustomerPaymentBankTransferType;
use ProjectBundle\Form\Type\ContactType;
use ProjectBundle\Form\Type\ApplyJobsType;





use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;


use ProjectBundle\Form\Type\PaymentBankTransferType;

use JMS\SecurityExtraBundle\Annotation\Secure;
use GuzzleHttp\Client;
use Symfony\Component\Intl\Locale;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\File\MimeType\FileinfoMimeTypeGuesser;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;


class MainController extends Controller
{
    public function _footerAction(Request $request)
    {
        $em = $this->getDoctrine();
        $news_recents  = $em->getRepository(Blog::class)->findAllActiveData()->setMaxResults(3)->getQuery()->getResult();
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':_footer.html.twig', array(
            'news_recents'=>$news_recents
        ));
    }
    public function _menu_newsAction(Request $request,$parameter = array())
    {
        $local = $request->getLocale();
        $em = $this->getDoctrine();
        //News Category Data

        $cate_id = null;
        if ($parameter){
            if($parameter['_route'] == "news_category"){
                $cate_id = $parameter['id'];
            }else if ($parameter['_route'] == "news_detail"){
                $repository = $em->getRepository(News::class);
                $id = $parameter['id'];
                $query = $repository->findAllActiveDataByNewsId($id)->getQuery()->getOneOrNullResult();
                $cate_id = $query->getNewsCategorys()->getId();
            }
        }


        $news_category_root_id = $this->container->getParameter('news_category_root_id');
        $repo_news_category = $em->getRepository(NewsCategory::class);
        $news_categorys = $repo_news_category->findAllData($news_category_root_id)->getQuery()->getResult();


        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':_menu_news.html.twig', array(
            'news_categorys'=>$news_categorys,'cate_id'=>$cate_id
        ));
    }

    public function _menu_our_brandsAction(Request $request,$our_brand_id = array())
    {
        $locale = $request->getLocale();
        $em = $this->getDoctrine();
        $our_brands  = $em->getRepository(OurBrand::class)->findAllActiveData($locale)->getQuery()->getResult();
        if ($our_brand_id){
            $our_brand_id = $our_brand_id;
        }else{
            $our_brand_id = null;
        }
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':_menu_our_brands.html.twig', array(
            'our_brands'=>$our_brands,
            'our_brand_id'=> $our_brand_id
        ));
    }

    public function indexAction(Request $request)
    {
        $locale = $request->getLocale();
        $em = $this->getDoctrine();
        $banners = $em->getRepository(Banner::class)->findAllActiveData($locale)->getQuery()->getResult();
        $pr_news  = $em->getRepository(News::class)->findAllActiveData()->setMaxResults(5)->getQuery()->getResult();
        $our_brands  = $em->getRepository(OurBrand::class)->findAllActiveData($locale)->getQuery()->getResult();
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':index.html.twig', array(
            'banners'=>$banners, 'pr_news'=>$pr_news, 'our_brands'=>$our_brands
        ));
    }

    public function our_brandAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine();
        $data  = $em->getRepository(OurBrand::class)->getActiveDataById($id)->getQuery()->getSingleResult();
        // $pr_news = $em->getRepository(News::class)->findAllActiveDataByOurBrandId($id)->setMaxResults(5)->getQuery()->getResult();

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':our_brand.html.twig', array(
            'data' => $data,
            // 'pr_news' => $pr_news
        ));
    }

    public function aboutAction(Request $request)
    {
        // $histories = $this->getDoctrine()->getRepository(History::class)->findAllData()->getQuery()->getResult();
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':about.html.twig', array(
            // 'histories'=>$histories,
        ));
    }

    public function corporateAction(Request $request)
    {
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':corporate.html.twig', array(

        ));
    }

    public function business_outlineAction(Request $request)
    {
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':business_outline.html.twig', array(

        ));
    }

    public function company_profileAction(Request $request)
    {
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':company_profile.html.twig', array(

        ));
    }
    public function terms_of_useAction(Request $request)
    {
        $data = $this->getDoctrine()->getRepository(Pages::class)->getActiveDataByName('terms_conditions',$request->getLocale());
        if (!$data) { throw $this->createNotFoundException('No data found'); }


        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':terms_of_use.html.twig', array(
            'data'=>$data
        ));
    }
    public function counselingAction(Request $request)
    {

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':counseling.html.twig', array(

        ));
    }
    public function in_shop_counselingAction(Request $request)
    {

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':in_shop_counseling.html.twig', array(

        ));
    }
    public function skin_problems_and_cosmeticsAction(Request $request)
    {

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':skin_problems_and_cosmetics.html.twig', array(

        ));
    }
    public function skin_allergyAction(Request $request)
    {

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':skin_allergy.html.twig', array(

        ));
    }
    public function skin_allergy_qaAction(Request $request)
    {

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':skin_allergy_qa.html.twig', array(

        ));
    }
    public function skin_allergy_testAction(Request $request)
    {

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':skin_allergy_test.html.twig', array(

        ));
    }
    public function skin_atopic_dermatitisAction(Request $request)
    {

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':skin_atopic_dermatitis.html.twig', array(

        ));
    }
    public function skin_atopic_dermatitis_qaAction(Request $request)
    {

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':skin_atopic_dermatitis_qa.html.twig', array(

        ));
    }
    public function skin_atopic_dermatitis_washAction(Request $request)
    {

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':skin_atopic_dermatitis_wash.html.twig', array(

        ));
    }
    public function adult_acneAction(Request $request)
    {

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':adult_acne.html.twig', array(

        ));
    }
    public function adult_acne_adviceAction(Request $request)
    {

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':adult_acne_advice.html.twig', array(

        ));
    }
    public function uv_rays_and_drynessAction(Request $request)
    {

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':uv_rays_and_dryness.html.twig', array(

        ));
    }
    public function testAction(Request $request)
    {

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':test.html.twig', array(

        ));
    }
    public function shopAction(Request $request)
    {
        $locations = $this->getDoctrine()->getRepository(Location::class)->findDataJoinedShop()->getQuery()->getResult();
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':shop.html.twig', array(
            'locations'=>$locations
        ));
    }
    public function sitemapAction(Request $request)
    {
        $product_categories = $this->getDoctrine()->getRepository(ProductCategory::class)->findPublicDataJoinedProduct()->getQuery()->getResult();
        $locations = $this->getDoctrine()->getRepository(Location::class)->findDataJoinedShop()->getQuery()->getResult();

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':sitemap.html.twig', array(
            'product_categories' => $product_categories,'locations'=>$locations
        ));
    }

    public function serviceAction(Request $request)
    {
        $data = $this->getDoctrine()->getRepository(Pages::class)->getActiveDataByName('service',$request->getLocale());
        if (!$data) { throw $this->createNotFoundException('No data found'); }
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':service.html.twig', array(
            'data'=>$data
        ));
    }

    public function how_to_buyAction(Request $request)
    {
        $data = $this->getDoctrine()->getRepository(Pages::class)->getActiveDataByName('how_to_buy',$request->getLocale());
        if (!$data) { throw $this->createNotFoundException('No data found'); }
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':how_to_buy.html.twig', array(
            'data'=>$data
        ));
    }

    public function shipping_deliveryAction(Request $request)
    {
        $data = $this->getDoctrine()->getRepository(Pages::class)->getActiveDataByName('shipping_delivery',$request->getLocale());
        if (!$data) { throw $this->createNotFoundException('No data found'); }
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':shipping_delivery.html.twig', array(
            'data'=>$data
        ));
    }


    public function privacy_policyAction(Request $request)
    {
        $data = $this->getDoctrine()->getRepository(Pages::class)->getActiveDataByName('privacy_policy',$request->getLocale());
        if (!$data) { throw $this->createNotFoundException('No data found'); }
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':privacy_policy.html.twig', array(
            'data'=>$data
        ));
    }

    public function contactAction(Request $request)
    {
        $form = $this->createForm(ContactType::class, new Contact());
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':contact.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    public function contact_createAction(Request $request)
    {
        $util = $this->container->get('utilities');
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->submit($request->request->all());
        $data = $form->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $subject = 'You have a new message(s) in your contact';
            $urls = $this->generateUrl('admin_contact_view',array('id'=>$data->getId()), UrlGeneratorInterface::ABSOLUTE_URL);
            $response = $this->sendmail($urls,$subject,$data);
            return new JsonResponse($response);
        }else{
            // $errors = $this->getFormErrorMessage($form);
            $errors = $util->getFormErrorMessage($form);
            $response['errors'] = $errors;
            $response['success'] = false;
            return new JsonResponse($response);
        }
    }

    public function blogAction(Request $request)
    {
        $util = $this->container->get('utilities');
        $session = $request->getSession();
        $repository = $this->getDoctrine()->getRepository(Blog::class);
        $query = $repository->findAllActiveData();
        $paginated = $util->setPaginatedOnPagerfanta($query,12);
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':blog.html.twig', array(
            'paginated' =>$paginated
        ));
    }

    public function blog_detailAction(Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine();
        $data = $em->getRepository(Blog::class)->getActiveDataById($request->get('id'))->getQuery()->getSingleResult();
        if (!$data) { throw $this->createNotFoundException('No data found'); }
        $data_image = $em->getRepository(BlogImage::class)->findBy(array('blog' => $request->get('id')), array('id' => 'ASC'));
        $recent_blogs  = $em->getRepository(Blog::class)->getActiveDataByRecent($request->get('id'))->setMaxResults(5)->getQuery()->getResult();
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':blog_detail.html.twig', array(
            'data'=>$data,'data_image'=>$data_image,'recent_blogs'=>$recent_blogs
        ));
    }

    public function showroomAction(Request $request)
    {
        $util = $this->container->get('utilities');
        $session = $request->getSession();
        $em = $this->getDoctrine();
        $query = $em->getRepository(Showroom::class)->findAllActiveData($request->getLocale());
        $paginated = $util->setPaginatedOnPagerfanta($query,12);
        $google_maps_api_key = $em->getRepository(Authentication::class)->findOneBy(['name'=>'google_maps_api_key']);
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':showroom.html.twig', array(
            'paginated' =>$paginated,
            'google_maps_api_key'=>$google_maps_api_key
        ));
    }

    public function join_usAction(Request $request)
    {
        $util = $this->container->get('utilities');
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();

        // $util->setCkAuthorized();
        // $acctoken = $util->getAccessToken();


        $query = $em->getRepository(Jobs::class)->findAllDataActive();
        $paginated = $util->setPaginatedOnPagerfanta($query,12);

        //$data_seting_file_job_available = $repository->getDataByCatType('file')->getQuery()->getOneorNullResult();
        // $file_name = $data_seting_file_job_available->getOptionValue();
        // $file_update = $data_seting_file_job_available->getUpdatedAt();


        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':join_us.html.twig', array(
            'paginated' =>$paginated,
            //"file_name"=>$file_name,"file_update"=>$file_update
        ));
    }
    public function jobs_openingAction(Request $request)
    {
        $util = $this->container->get('utilities');
        $session = $request->getSession();
        $em = $this->getDoctrine();
        $query = $em->getRepository(Jobs::class)->findAllDataActive($request->getLocale());
        $paginated = $util->setPaginatedOnPagerfanta($query,12);
        $google_maps_api_key = $em->getRepository(Authentication::class)->findOneBy(['name'=>'google_maps_api_key']);
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':jobs_opening.html.twig', array(
            'paginated' =>$paginated,
            'google_maps_api_key'=>$google_maps_api_key
        ));
    }
    public function apply_jobs_createAction(Request $request)
    {
        $util = $this->container->get('utilities');
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();

        $job_id = $request->attributes->get('job_id');
        $job = $em->getRepository(Jobs::class)->findAllDataActiveById($job_id)->getQuery()->getOneOrNullResult();

        if (!$job){
            throw $this->createNotFoundException('This data doesn\'t exist');
        }

        $data = new ApplyJobs();
        $form = $this->createForm(ApplyJobsType::class, $data, array('allow_extra_fields'=>true,'attr' => array('job_id' => $job->getId())));
        $repository = $this->getDoctrine()->getRepository(SettingOption::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($data);

            //// Save Address data
            $this->saveAddress($data);

            //// Save Educational data
            $this->saveEducational($data);

            //// Save language skill data
            $this->saveLanguageSkill($data);

            //// Save Computer skill data
            $this->saveComputerSkill($data);

            //// Save Othere skill data
            $this->saveOtherSkill($data);

            //// Save Work Experience skill data
            $this->saveWorkExperience($data);

            //// Save Trainnig skill data
            $this->saveTrainig($data);

            //// Save Files and Move Files.
            $this->saveAttachFile($data);





            $em->flush();
            $util->setCreateNotice();

            return $this->redirect($this->generateUrl('join_us'));
        }

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':apply_job.html.twig', array(
            'form'=>$form->createView(),
            // "file_name"=>$file_name,"file_update"=>$file_update
        ));
    }
    public function saveAddress(ApplyJobs $applyJob)
    {
        $util = $this->container->get('utilities');
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        $address_request = $applyJob->getAddress();
         foreach ($address_request as  $address) {
            $address->setApplyJobs($applyJob);
            $em->persist($address);
         }
         // $em->flush($address);
    }
    public function saveTrainig(ApplyJobs $applyJob)
    {
        $util = $this->container->get('utilities');
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        $training_request = $applyJob->getTraining();
         foreach ($training_request as  $training) {
            $training->setApplyJobs($applyJob);
            $em->persist($training);
         }
         // $em->flush($address);
    }

    public function saveComputerSkill(ApplyJobs $applyJob)
    {
        $util = $this->container->get('utilities');
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        $computer_skill_request = $applyJob->getComputerSkill();

         foreach ($computer_skill_request as  $computer_skill) {
            $computer_skill->setApplyJobs($applyJob);
            $em->persist($computer_skill);
         }
         // $em->flush($address);
    }
    public function saveWorkExperience(ApplyJobs $applyJob)
    {
        $util = $this->container->get('utilities');
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        $work_experience_request = $applyJob->getWorkExperience();

         foreach ($work_experience_request as  $work_experience) {
            $work_experience->setApplyJobs($applyJob);
            $em->persist($work_experience);
         }
         // $em->flush($address);
    }


    public function saveOtherSkill(ApplyJobs $applyJob)
    {
        $util = $this->container->get('utilities');
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        $other_skill_request = $applyJob->getOtherSkill();

         foreach ($other_skill_request as  $other_skill) {
            $other_skill->setApplyJobs($applyJob);
            $em->persist($other_skill);
         }
         // $em->flush($address);
    }
    public function saveLanguageSkill(ApplyJobs $applyJob)
    {
        $util = $this->container->get('utilities');
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        $language_skill_request = $applyJob->getLanguageSkill();

         foreach ($language_skill_request as  $language_skill) {
            $language_skill->setApplyJobs($applyJob);
            $em->persist($language_skill);
         }
         // $em->flush($address);
    }
    public function saveEducational(ApplyJobs $applyJob)
    {
        $util = $this->container->get('utilities');
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        $educational_request = $applyJob->getEducational();

         foreach ($educational_request as  $educational) {
            $educational->setApplyJobs($applyJob);
            $em->persist($educational);
         }
         // $em->flush($address);
    }
    public function saveAttachFile(ApplyJobs $applyJob)
    {
        $util = $this->container->get('utilities');
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        $attachFile_request = $request->files->get('apply_jobs')['attachFile'];
        $fileCount = count($attachFile_request);

        $filePathUpload = $this->container->getParameter('join_us_upload_path');

        if($fileCount > 0){

                foreach ($attachFile_request as  $file) {
                    try {
                        $attachFile = new AttachFile();
                        $extension = $file['fileUploadPath']->guessExtension();
                        $fileName = 'file-'.date('Ymd').'-'.rand(1, 99999).'.'.$extension;

                        // dump($file['fileUploadPath']);
                        // exit;
                        $file['fileUploadPath']->move($filePathUpload,$fileName);
                        $attachFile->setApplyJobs($applyJob);
                        $attachFile->setName($fileName);
                        $attachFile->setFileUploadPath($filePathUpload);
                        $attachFile->setFileUploadName($fileName);
                        $em->persist($attachFile);

                    } catch (FileException $e){
                        throw new FileException('Failed to upload file');
                    }

                }
                $em->flush($attachFile);
        }

    }

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





    public function searchAction(Request $request)
    {
        $session = $request->getSession();
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':search.html.twig', array());
    }

    public function search_apiAction(Request $request)
    {
        $session = $request->getSession();

        $arr_data = array();
        $arr_result = array();
        $arr_query_data = array();
        $all_result = 0;

        if($request->get('q')){
            $arr_query_data['q'] = $request->get('q');
            $em = $this->getDoctrine();

            $product = $em->getRepository(Product::class)->findAllActiveData($arr_query_data)->getQuery()->getResult(2);
            $arr_data['product'] = $product;
            $arr_result['product'] = count($product);

            $blog = $em->getRepository(Blog::class)->findAllActiveData($arr_query_data)->getQuery()->getResult(2);
            $arr_data['blog'] = $blog;
            $arr_result['blog'] = count($blog);

            foreach ($arr_result as $key => $value) {
                $all_result = $all_result + $value;
            }
        }

        $response = new JsonResponse();
        $response->setData(array(
            'data'  => $arr_data,
            'result' => $arr_result,
            'all_result' => $all_result,
            'time' => date('Y/m/d H:i:s'),
        ));
        $response->setSharedMaxAge(600);
        return $response;
    }

    /**
    * @Secure(roles="ROLE_CLIENT, ROLE_CUSTOMER, ROLE_USER, ROLE_EDITOR, ROLE_ADMIN")
    */
    public function default_target_loginAction(Request $request)
    {
        $user = $this->getUser();
        $session = $request->getSession();
        $auth_checker = $this->get('security.authorization_checker');
        $util = $this->container->get('utilities');

        $util->destroySessionAfterLogin($request);

        if( $auth_checker->isGranted('ROLE_EDITOR') || $auth_checker->isGranted('ROLE_ADMIN') ){
            return $this->redirect($this->generateUrl('admin'));

        }elseif( $auth_checker->isGranted('ROLE_CLIENT') || $auth_checker->isGranted('ROLE_CUSTOMER') ){
            //check valid token for only customer is_set_password
            $is_set_pwd = $user->getIsSetPassword();
            if($is_set_pwd){
                try {
                    $acctoken = $util->getAccessToken();
                    //check token expire here
                } catch(\Exception $e) {
                	//no access token or expire redirect to generate_token
                    return $this->redirectToRoute('member_generate_token');
                }
            }

            if($auth_checker->isGranted('ROLE_CLIENT')){
                return $this->redirect($this->generateUrl('designer'));
            }else{
                return $this->redirect($this->generateUrl('fos_user_profile_show'));
            }

        }else{
            return $this->redirect($this->generateUrl('homepage'));
        }
    }



    public function default_target_logoutAction(Request $request)
    {
        $util = $this->container->get('utilities');

        $util->destroySessionAfterLogout($request);
        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
    * @Secure(roles="ROLE_ADMIN, ROLE_EDITOR, ROLE_CUSTOMER, ROLE_CLIENT")
    */
    public function default_target_password_resettingAction(Request $request)
    {
        $util = $this->container->get('utilities');
        $session = $request->getSession();
        $user = $this->getUser();

        if($session->has('tmp_password_resetting')){
            //get password
            $new_pwd = $session->get('tmp_password_resetting');
            //get email
            $email = $user->getEmail();

            //get user scope
            $user_roles = $user->getRoles();
            if( in_array("ROLE_CLIENT",$user_roles) ){
                $scope = $this->container->getparameter('access_token_client_scope');
            }else{
                $scope = $this->container->getparameter('access_token_customer_scope');
            }

            //set oauth token
            $util->setAccessToken($email, $new_pwd, $scope);
            //reset session access token
            $token = $util->getAccessTokenFromDB();

            //remove session tmp_password_resetting
            $session->remove('tmp_password_resetting');
        }
        //return $this->redirect($this->generateUrl('fos_user_profile_show'));
        return $this->redirect($this->generateUrl('default_target_login'));
    }

    public function customer_registerAction(Request $request)
    {
        /*
        $session = $request->getSession();
        $user = $this->getUser();
        if($user){
          throw $this->createNotFoundException('You are not permitted to use that link to directly access that page');
        }

        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $form = $this->createForm(CustomerRegisterType::class, $user);
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':customer_register.html.twig', array('form' =>$form->createView()));
        */
    }

    public function customer_register_createAction(Request $request)
    {
        /*
        $util = $this->container->get('utilities');
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $user = $this->getUser();
        if($user){
          throw $this->createNotFoundException('You are not permitted to use that link to directly access that page');
        }

        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->createUser();

        $form = $this->createForm(CustomerRegisterType::class, $user);
        $form->handleRequest($request);
        $datas = $form->getData();
        $email = $datas->getEmail();

        $chk_email = $em->getRepository(User::class)->findByEmailCanonical($email);
        if(count($chk_email)>0){
          $form->get('email')->addError(new FormError('The email is already used'));//already exists email
        }

        if ($form->isSubmitted() && $form->isValid())
        {
          $plainpass = $datas->getPlainPassword();
          $roles = array('ROLE_CUSTOMER');

          // we set username in user entity
          // $user->setUsername($email);
          // $user->setUsernameCanonical($email);

          $user->setRoles($roles);

          $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');
          if($confirmationEnabled){
            // register with email comfirmation
            $mailer = $this->container->get('fos_user.mailer');
            $tokenGenerator = $this->container->get('fos_user.util.token_generator');
            //save confirmation token
            $user->setConfirmationToken($tokenGenerator->generateToken());
            //send confirmation email
            $mailer->sendConfirmationEmailMessage($user);
            //save user data
            $userManager->updateUser($user);
            //set oauth token
            $scope = $this->container->getparameter('access_token_customer_scope');
            $util->setAccessToken($email, $plainpass, $scope);
            $this->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
            $route = 'fos_user_registration_check_email';
            $this->get('session')->getFlashBag()->add('fos_user_success', 'registration.flash.user_created');
            return $this->redirect($this->generateUrl('fos_user_registration_check_email'));

          }else{
            // register with non comfirmation
            //enable customer status
            $user->setEnabled(1);
            //save user data
            $userManager->updateUser($user, true);
            //set oauth token
            $scope = $this->container->getparameter('access_token_customer_scope');
            $util->setAccessToken($email, $plainpass, $scope);
            return $this->redirect($this->generateUrl('customer_register_complete'));
          }
        }
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':customer_register.html.twig', array('form'=>$form->createview()));
        */
    }

    public function customer_register_completeAction(Request $request)
    {
        /*
        // $locale = $request->getLocale();
        // $translated = $this->get('translator')->trans('customer.registration');

        $session = $request->getSession();
        $flashBag = $this->get('session')->getFlashBag();
        foreach ($session->getFlashBag()->get('login_at_checkout', array()) as $val){
          if($val){
            //change flash login_at_checkout to register_at_checkout
            $flashBag->add('register_at_checkout', true);
          }
        }
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':customer_register_complete.html.twig', array());
        */
    }

    /*
    protected function getFormErrorMessage($form)
    {
        $errors = array();
        if($form){
            foreach ($form as $fieldName => $formField) {
                foreach ($formField->getErrors(true) as $error) {
                    $errors[$fieldName] = $error->getMessage();
                }
            }
        }
        return $errors;
    }
    */

    protected function sendmail($urls,$subject,$data)
    {
        $em = $this->getDoctrine()->getManager()->getRepository(SettingOption::class);
        //Recipients
        $setting_option_email = $em->findOneByOptionName('contact_mail_address');
        $arr_contact_mail_address = explode(",", $setting_option_email->getOptionValue());
        //Sender name
        $setting_option_name = $em->findOneByOptionName('contact_mail_name');
        $contact_mail_name = $setting_option_name->getOptionValue();
        //Default email
        $sender_mail_address = $this->container->getParameter('default_sender_mail_address') ;

        $message = (new \Swift_Message($subject))
        ->setFrom(array($sender_mail_address => $contact_mail_name))
        ->setTo($arr_contact_mail_address)
        ->setBody(
            $this->renderView(
                'ProjectBundle:'.$this->container->getParameter('view_main').':_email_contact.html.twig',
                array('urls'=> $urls,'subject'=>$subject,'data'=>$data)
            ),
            'text/html'
        );

        try{
            $this->get('mailer')->send($message);
            $response['success'] = true;
            $response['message'] = $this->get('translator')->trans('contact.send.thank');
        }catch(\Exception $e){
            #Do nothing
            $response['success'] = false;
            $response['message'] = $this->get('translator')->trans('contact.cannot.send');
        }

        return $response;
    }

    public function promotionAction(Request $request)
    {
        $util = $this->container->get('utilities');
        $session = $request->getSession();
        $repository = $this->getDoctrine()->getRepository(Promotion::class);
        $query = $repository->findAllActiveData();
        $paginated = $util->setPaginatedOnPagerfanta($query,10);



        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':promotion.html.twig', array(
            'paginated' =>$paginated
        ));
    }

    public function promotion_detailAction(Promotion $promotions,Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine();

        $data_promotion = $em->getRepository(Promotion::class)->getActiveDataById($promotions)->getQuery()->getSingleResult();

        $product_has_promotion = $this->getDoctrine()->getRepository(Product::class)->getActiveDataProductsByPromotionId($promotions)->getQuery();
        $util = $this->container->get('utilities');
        $limitPages = $this->container->getParameter('max_per_page_latest_product');
        $paginated = $util->setPaginatedOnPagerfanta($product_has_promotion,$limitPages);

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':promotion_detail.html.twig', array(
            'paginated'=>$paginated,
            'promotions'=>$data_promotion
        ));
    }

    public function trackAction(Request $request)
    {
        $em = $this->getDoctrine();
        $customerOrder = $em->getRepository(CustomerOrder::Class)->findCustomerOrderHasItemByOrderNumber($request->get('no'))->getQuery()->getResult();

        $bankAccount = $em->getRepository(BankAccount::Class)->findAllActiveData()->getQuery()->getResult();
        $payment_bank_transfer = $em->getRepository(CustomerPaymentBankTransfer::class)->findCustomerPaymentBankTransferByOrder($customerOrder)->getQuery()->getResult();
        $arr_tracking_numbers = $em->getRepository(TrackingNumber::class)->findSelectDataByOrder($customerOrder)->getQuery()->getArrayResult();

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':track.html.twig', array(
            'customerOrder'=>$customerOrder,
            'bankAccount'=>$bankAccount,
            'payment_bank_transfer'=>$payment_bank_transfer,
            'arr_tracking_numbers'=>$arr_tracking_numbers
        ));
    }

    public function portfolioAction(Request $request)
    {
        $data = $this->getDoctrine()->getRepository(Pages::class)->getActiveDataByName('portfolio',$request->getLocale());
        if (!$data) { throw $this->createNotFoundException('No data found'); }
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':portfolio.html.twig', array(
            'data'=>$data
        ));
    }

    public function confirm_paymentAction(Request $request)
    {
        $util = $this->container->get('utilities');
        $payment_bank_transfer = new CustomerPaymentBankTransfer();
        $form = $this->createForm(CustomerPaymentBankTransferType::class,$payment_bank_transfer);

        $now_date = new \DateTime();
        $form->get('timeTransfer')->setData($now_date);

        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        $data = $form->getData();

        // $bankAccount =  new BankAccount();
        // $bankAccountObj = $em->getRepository(BankAccount::Class)->findOneById(8);
        // dump($bankAccountObj[0]->getId());
        // exit;

        if ($form->isSubmitted() && $form->isValid()) {
            // dump($data);
            // exit;
            $customerOrderObj = $em->getRepository(CustomerOrder::Class)->findCustomerOrderHasItemByOrderNumber($data->getOrderNumber())->getQuery()->getResult();

            $file = $form['attach_file']->getData();
            // dump($imageEn->getImage());
            // $file =	$file->getClientOriginalName();
            $extension = $file->guessExtension();
            $date = date("Y-m-d");
            $fileName = $date.rand(1, 99999).'.'.$extension;
            $file->move($this->container->getParameter('files_upload_bank_transfer'),$fileName);

            $payment_bank_transfer->setAttachFile($fileName);
            // $payment_bank_transfer->setBankAccount($bankAccountObj);
            $payment_bank_transfer->setCustomerOrder($customerOrderObj[0]);
            //dump($data);
            $em->persist($payment_bank_transfer);
            $em->flush();

            $util->sendMailPaymentBankTransfer($payment_bank_transfer);

            $this->get('session')->getFlashBag()->add('notice', 'succes');
            return $this->redirect($this->generateUrl('confirm_payment'));
        }

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':confirm_payment.html.twig', array(
            'form' =>$form->createView(),
        ));
    }

    public function search_paymentDataAction(Request $request){
        $payment_bank_transfer = new CustomerPaymentBankTransfer();
        //$form = $this->createForm(CustomerPaymentBankTransferType::class,$payment_bank_transfer);
        //$em = $this->getDoctrine()->getManager();
        // $form->handleRequest($request);

        if (isset($_REQUEST['orderId'])){
            $ordid = $request->get('orderId');
            $em = $this->getDoctrine()->getManager();
            $customerOrderObj = $em->getRepository(CustomerOrder::Class)->checkCustomerHasOrderById($ordid)->getQuery()->getOneOrNullResult();
            if (isset($customerOrderObj)){
            $customerOrderAddressObj = $em->getRepository(CustomerOrderDelivery::Class)->findCustomerOrderDeliveryByOrder($customerOrderObj,1)->getQuery()->getOneOrNullResult();
            $data  = array('firstname'=>$customerOrderAddressObj->getFirstName(),
                            'lastname'=>$customerOrderAddressObj->getLastName(),
                            'phone'=>$customerOrderAddressObj->getPhone(),
                            'orderNumber' =>$customerOrderObj->getOrderNumber(),
                            'totalPrice' =>$customerOrderObj->getTotalPrice()
            );

            $json_response = new JsonResponse();
    		// $json_response->setEncodingOptions(JSON_NUMERIC_CHECK);
            $json_response->setData($data);
            return $json_response;
            }else{
                return new JsonResponse(false);
            }
        }
    }

    public function newsAction(Request $request)
    {
        $cate_id = trim($request->get('cate_id'));
        $util = $this->container->get('utilities');
        $news_category_root_id = $this->container->getParameter('news_category_root_id');
        $session = $request->getSession();
        $em = $this->getDoctrine();
        //News Data
        $repository = $em->getRepository(News::class);
        $query = $repository->findAllActiveData($cate_id);
        $paginated = $util->setPaginatedOnPagerfanta($query,12);
        //$category_name = $query->getSingleResult();

        //News Category Data
        $repo = $em->getRepository(NewsCategory::class);
        $categorys = $repo->findById($cate_id);

        // $categorys_name= "";
// dump($categorys);exit;
        if(count($categorys)>0){
            $category = $categorys[0];
        }else{
            $category = null;
        }
        // if($cate_id){
        //     $categorys_name = $repo->findAllDataById($cate_id)->getQuery()->getSingleResult()->getTitle();
        // }else{
        //     $categorys_name= "";
        // }


        //Feature top ad
        // $banner_ad_repo = $this->getDoctrine()->getManager()->getRepository(BannerAds::class);
        // $con_banner_news_top_ad = $this->container->getParameter('con_banner_news_top_ad');
        // $news_top_ad = $banner_ad_repo->findOneByBannerGroup($con_banner_news_top_ad);

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':news.html.twig', array(
            'paginated'=>$paginated,
            'category'=>$category,
            // 'recent_news'=>$recent_news
        ));
    }

    public function news_detailAction(Request $request)
    {

        $util = $this->container->get('utilities');
        $em = $this->getDoctrine();
        $data = $em->getRepository(News::class)->getActiveDataById($request->get('id'))->getQuery()->getSingleResult();
        if (!$data) { throw $this->createNotFoundException('No data found'); }
        $session = $request->getSession();

        //         $sessionVal = $session->get('history');
        //         $sessionVal[3] = $data;
        //         // Set value back to session
        //         $session->set('history', $sessionVal);
        // dump($sessionVal);
        // exit;
                //
        // $aa = $this->getResponse()->setCookie('history', serialize($data));
        //
        // $data = unserialize($this->getRequest()->getCookie('history'));
        // dump($session);
        // exit;
        // $sessionVal = $session->get('history');
        // // Append value to retrieved array.
        // $sessionVal[] = $data;
        // // Set value back to session
        // $session->set('history', $sessionVal);
         $locale = Locale::getDefault();
         $category_name = $data->getNewsCategorys()->setLocale($locale)->getTitle();
         $arr_path_category_id = array('id'=>$data->getNewsCategorys()->getId());
         // dump($arr_path_category_id);
         // exit;


        $data_image = $em->getRepository(NewsImage::class)->findBy(array('news' => $request->get('id')), array('id' => 'ASC'));
        $recent_news  = $em->getRepository(News::class)->getActiveDataByRecent($request->get('id'))->setMaxResults(3)->getQuery()->getResult();

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':news_detail.html.twig', array(
            'data'=>$data,'data_image'=>$data_image,'recent_news'=>$recent_news,'category_name'=>$category_name,
            'arr_path_category_id'=>$arr_path_category_id
        ));
    }
    public function _sidebar_menu_newsAction(Request $request,$arr_path_category_id=array())
    {
        $local = $request->getLocale();
        $em = $this->getDoctrine();
        //News Category Data
        $news_category_root_id = $this->container->getParameter('news_category_root_id');
        $repo_news_category = $em->getRepository(NewsCategory::class);
        $news_categorys = $repo_news_category->findAllActiveData($news_category_root_id)->getQuery();

        $this->pathCategoryId = $arr_path_category_id;
        // dump($this->pathCategoryId);
        // exit;
        $options = array(
            'decorate' => true,
            // 'rootOpen' => '<ul class="sidebar-links">',
            // 'rootClose' => '</ul>',
            'rootOpen' => function($rOpen) {
                if($rOpen[0]['lvl'] == 1){
                    $html = '<ul class="sidebar-links">';
                }else{
                    $html = '<ul class="pl-4 pt-2">';
                }
                return $html;
            },
            'rootClose' => function($rClose) {
                if($rClose[0]['lvl'] == 1){
                    $html = '</ul>';
                }else{
                    $html = '</ul>';
                }
                return $html;
            },
            'childOpen' => function($cOpen) {
                $id = $cOpen['id'];
                $level = $cOpen['lvl'];
                // $title = $cOpen['translations'][Locale::getDefault()]['title'];

                // $active_class = '';
                $html = "<li>";
                $active_class = '';
                if(sizeof($this->pathCategoryId)){
                    if (in_array($id, $this->pathCategoryId)) {
                        // $active_class = "active";
                        $active_class = 'active';
                    }
                }
                if($level == 1){
                    $html = '<li class="'.$active_class.'">';
                }else{
                    $html = '<li class="'.$active_class.'">';
                }



                return $html;
            },
            'childClose' => function($cClose) {
                $html = "</li>";
                return $html;

            },
            'nodeDecorator' => function($node) {
                // dump($node);
                // exit;
                if($node['lvl'] == 1){
                    $html = '';
                }else{
                    $url = $this->container->get('router')->generate('news_category',array('cate_id'=>$node['id'],'slug'=>$node['slug']));
                    $html = '<a href="'.$url.'" id="sidebar-slug-'.$node['slug'].'" class="nc'.$node['lvl'].'">'.$node['translations'][Locale::getDefault()]['title'].'</a>';
                }
                $url = $this->container->get('router')->generate('news_category',array('cate_id'=>$node['id'],'slug'=>$node['slug']));
                $html = '<a href="'.$url.'" id="sidebar-slug-'.$node['slug'].'" class="nc'.$node['lvl'].'">'.$node['translations'][Locale::getDefault()]['title'].'</a>';

                return $html;
            }
        );
        $tree_news_categorys = $repo_news_category->buildTree($news_categorys->getArrayResult(), $options);

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':_sidebar_menu_news.html.twig', array(
            'tree_news_categorys'=>$tree_news_categorys,
        ));
    }

}
