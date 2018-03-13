<?php

namespace BaptisteDulac\PushNotificationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class BaptisteDulacPushNotificationExtension extends Extension
{
    /** @var ContainerBuilder */
    protected $container;

    /** @var string */
    protected $kernelRootDir;

    public function load(array $configs, ContainerBuilder $container)
    {
        $this->container = $container;
        $this->kernelRootDir = $container->getParameterBag()->get("kernel.root_dir");
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        if (isset($config['android'])) {
            $this->container->setParameter('bd_push_notifications.android.enabled', true);
            $this->container->setParameter("bd_push_notifications.android.api_key", $config["android"]["timeout"]);
            $this->container->setParameter("bd_push_notifications.android.api_key", $config["android"]["api_key"]);
            $loader->load('android.yaml');
        }

        if (isset($config['ios'])) {
            $this->addIOSConfig($config['ios']);
            $loader->load('ios.yaml');
        }
    }

    private function addIOSConfig(array $config): void
    {

        if (realpath($config["pem"]) !== false) {
            $pemFile = $config["pem"];
        } elseif (realpath($this->kernelRootDir.DIRECTORY_SEPARATOR.$config["pem"]) !== false) {
            $pemFile = $this->kernelRootDir.DIRECTORY_SEPARATOR.$config["pem"];
        } else {
            throw new \RuntimeException(sprintf('Pem file "%s" not found.', $config["pem"]));
        }

        $this->container->setParameter('bd_push_notifications.ios.enabled', true);
        $this->container->setParameter('bd_push_notifications.ios.timeout', $config["timeout"]);
        $this->container->setParameter('bd_push_notifications.ios.sandbox', $config["sandbox"]);
        $this->container->setParameter('bd_push_notifications.ios.pem', $pemFile);
        $this->container->setParameter('bd_push_notifications.ios.passphrase', $config["passphrase"]);
    }
}