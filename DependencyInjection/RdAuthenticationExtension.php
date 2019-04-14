<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class RdAuthenticationExtension
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Robbyte\AuthenticationBundle\DependencyInjection
 */
class RdAuthenticationExtension extends Extension
{


    /**
     * Load bundle configs
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
        $this->addAnnotatedClassesToCompile([
            '**Bundle\\Controller\\',
        ]);
    }

}