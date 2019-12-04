<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Controller;

use Rd\AuthenticationBundle\Exception\AccountNotFoundException;
use Rd\AuthenticationBundle\Service\Authentication\AuthenticationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AccountVerifyController
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\AuthenticationBundle\Controller
 */
class AccountVerifyController extends AbstractController
{

    /**
     * @Route("/confirm-account/{hash}", name="rd_authentication_confirm_account")
     * @param string                  $hash
     * @param AuthenticationInterface $authentication
     * @return RedirectResponse
     */
    public function index($hash, AuthenticationInterface $authentication): RedirectResponse
    {
        try {
            $authentication->confirmAccount($hash);
        } catch (AccountNotFoundException $e) {
            return $this->redirectToRoute('rd_authentication_lost_password');
        }

        return $this->redirectToRoute('rd_authentication_login');
    }
}