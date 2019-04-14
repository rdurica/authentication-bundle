<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    /**
     * @Route("/lost-password", name="rd_authentication_lost_password")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('@RdAuthentication/lost_password.html.twig');
    }
}