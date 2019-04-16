<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Controller;

use Rd\AuthenticationBundle\Entity\User;
use Rd\AuthenticationBundle\Event\UserEvent;
use Rd\AuthenticationBundle\Form\UserType;
use Rd\AuthenticationBundle\Service\Authentication\AuthenticationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @param Request                 $request
     * @param AuthenticationInterface $authentication
     * @return Response
     * @throws \Exception
     */
    public function index(Request $request, AuthenticationInterface $authentication): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $authentication->register($user);

            return $this->redirectToRoute('rd_authentication_login');
        }

        return $this->render('@RdAuthentication/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}