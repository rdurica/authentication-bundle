<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('@RdAuthentication/registration.html.twig');
    }
}