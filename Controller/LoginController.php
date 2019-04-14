<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->render('RdAuthenticationundle::login.html.twig');
    }
}