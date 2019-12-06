<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Controller;

use Rd\AuthenticationBundle\Exception\AccountNotFoundException;
use Rd\AuthenticationBundle\Service\Authentication\AuthenticationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LostPasswordController
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\AuthenticationBundle\Controller
 */
class LostPasswordController extends AbstractController
{

    private string $background;


    /**
     * LoginController constructor.
     *
     * @param string $background
     */
    public function __construct(string $background)
    {
        $this->background = $background;
    }


    /**
     * @param Request                 $request
     * @param AuthenticationInterface $authentication
     * @return Response
     * @Route("/lost-password", name="rd_authentication_lost_password")
     * @throws \Exception
     */
    public function index(Request $request, AuthenticationInterface $authentication): Response
    {
        $form = $this->createFormBuilder()->add('email', EmailType::class)->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            /** @var string $email */
            $email = $data['email'];

            try {
                $authentication->regeneratePassword($email);
            } catch (AccountNotFoundException $e) {
                return $this->redirectToRoute('rd_authentication_lost_password');
            }

            return $this->redirectToRoute('rd_authentication_login');
        }

        return $this->render('@RdAuthentication/lost_password.html.twig', [
            'form'       => $form->createView(),
            'background' => $this->background,
        ]);
    }
}