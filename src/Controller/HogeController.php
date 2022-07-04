<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Facebook\Facebook;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class HogeController extends AbstractController
{

    protected $facebook;

    public function __construct(Facebook $facebook)
    {
        $this->facebook = $facebook;   
    }

    #[Route('/hoge', name: 'app_hoge')]
    public function index(): Response
    {
          $fbHelper = $this->facebook->getRedirectLoginHelper();

          $permissions = ['email', 'public_profile', 'user_messenger_contact'];
          $fbLoginUrl = $fbHelper->getLoginUrl(
              $this->generateUrl('app_hoge', [], UrlGeneratorInterface::ABSOLUTE_URL),
              $permissions
          );
          
        return $this->render('hoge/index.html.twig', [
            'controller_name' => 'HogeController',
            'fbLoginUrl' => $fbLoginUrl
        ]);
    }

    /**
     * Facebook連携のコールバック
     *
     * @Route("/facebook/callback", name="recruitUserSns_facebookCallback")
     */
    public function facebookCallbackAction(Request $request)
    {
        $session = $request->getSession();
        
        $fb = $this->facebook;
        $helper = $fb->getRedirectLoginHelper();

        $accessToken = $helper->getAccessToken(
                $this->generateUrl('app_hoge', [], UrlGeneratorInterface::ABSOLUTE_URL)
            );


        if (empty($accessToken)) {
            return [
                'code' => 'error',
                'message' => 'Retry Sign in with Facebook.',
            ];
        }

            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get('/me?fields=id, email, name, first_name, middle_name, last_name, gender, locale',
                $accessToken->getValue());
   

        $fbUser = $response->getGraphUser();

        return [
            'code' => 'success',
            'accessToken' => $accessToken->getValue(),
            'id' => $fbUser->getId(),
            'email' => $fbUser->getEmail(),
            'name' => $fbUser->getName(),
            'first_name' => $fbUser->getFirstName(),
            'middle_name' => $fbUser->getMiddleName(),
            'last_name' => $fbUser->getLastName(),
            'gender' => $fbUser->getGender(),
//            'locale' => $fbUser->getLocale(),
        ];
        return $this->redirectToRoute('facebook');
    }
}
