<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Controller;

use Rd\AuthenticationBundle\Entity\User;
use Rd\AuthenticationBundle\Form\ChangePasswordType;
use Rd\AuthenticationBundle\Service\Authentication\AuthenticationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CreatePasswordController
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\AuthenticationBundle\Controller
 */
class CreatePasswordController extends AbstractController
{


    /**
     * @Route("/create-password/{hash}", name="rd_authentication_create_password")
     * @param string                  $hash
     * @param Request                 $request
     * @param AuthenticationInterface $authentication
     * @return Response
     */
    public function index(string $hash, Request $request, AuthenticationInterface $authentication): Response
    {
        $form = $this->createForm(ChangePasswordType::class);

        /** @var ?User $user */
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy([
            'confirmHash' => $hash,
            'active'      => true,
            'confirmed'   => true,
        ]);

        if (!$user) {
            return $this->redirectToRoute('rd_authentication_lost_password');
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            /** @var string $plainPassword */
            $plainPassword = $data['plainPassword'];

            $authentication->changePassword($user, $plainPassword);

            return $this->redirectToRoute('rd_authentication_login');
        }

        return $this->render('@RdAuthentication/create_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}