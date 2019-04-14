<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LoginController
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\AuthenticationBundle\Controller
 */
class LoginController extends AbstractController
{


    /**
     * @Route("/login", name="rd_authentication_login")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('@RdAuthentication/login.html.twig');
    }
}