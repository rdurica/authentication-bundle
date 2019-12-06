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

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition('Rd\AuthenticationBundle\Service\Mail\MailService');

        $definition->replaceArgument('$homepage', $config['homepage'] ?? $definition->getArgument('$homepage'));
        $definition->replaceArgument('$from', $config['email']['from'] ?? $definition->getArgument('$from'));

        $definition = $container->getDefinition('Rd\AuthenticationBundle\Controller\LoginController');
        $background = $config['background'] ?? $definition->getArgument('$background');
        $definition->replaceArgument('$background', $background);

        $definition = $container->getDefinition('Rd\AuthenticationBundle\Controller\CreatePasswordController');
        $definition->replaceArgument('$background', $background);

        $definition = $container->getDefinition('Rd\AuthenticationBundle\Controller\LostPasswordController');
        $definition->replaceArgument('$background', $background);

        $definition = $container->getDefinition('Rd\AuthenticationBundle\Controller\RegistrationController');
        $definition->replaceArgument('$background', $background);

        $this->addAnnotatedClassesToCompile([
            '**Bundle\\Controller\\',
        ]);
    }

}