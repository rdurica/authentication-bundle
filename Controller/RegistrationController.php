<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Controller;

use Rd\AuthenticationBundle\Entity\User;
use Rd\AuthenticationBundle\Form\UserType;
use Rd\AuthenticationBundle\Helper\BundleHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class RegistrationController
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\AuthenticationBundle\Controller
 */
class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="rd_authentication_registration")
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     * @throws \Exception
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setConfirmHash(BundleHelper::generateString());

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect('/');
        }

        return $this->render('@RdAuthentication/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}