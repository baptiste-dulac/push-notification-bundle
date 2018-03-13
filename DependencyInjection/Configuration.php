<?php
namespace BaptisteDulac\PushNotificationsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder
            ->root("bd_push_notifications")->
            children()->
                arrayNode("android")->
                    canBeUnset()->
                    children()->
                        scalarNode("timeout")->defaultValue(5)->end()->
                        scalarNode("api_key")->isRequired()->cannotBeEmpty()->end()->
                    end()->
                 end()->
                arrayNode('ios')->
                    canBeUnset()->
                    children()->
                        scalarNode("timeout")->defaultValue(60)->end()->
                        booleanNode("sandbox")->defaultFalse()->end()->
                        scalarNode("pem")->cannotBeEmpty()->end()->
                        scalarNode("passphrase")->defaultValue("")->end()->
                    end()->
                end()->
            end()
        ;
    }
}