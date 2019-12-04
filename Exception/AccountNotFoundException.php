<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Exception;

/**
 * Class AccountNotFoundException
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\AuthenticationBundle\Exception
 */
class AccountNotFoundException extends \Exception
{
    protected  $message = 'Account not found';

}