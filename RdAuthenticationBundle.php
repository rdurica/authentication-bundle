<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle;

use Rd\AuthenticationBundle\DependencyInjection\RdAuthenticationExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class RdAuthenticationBundle
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\AuthenticationBundle
 */
class RdAuthenticationBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new RdAuthenticationExtension();
    }

}