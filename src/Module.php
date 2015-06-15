<?php

/**
 * This file is part of the Miny framework.
 * (c) Dániel Buga <daniel@bugadani.hu>
 *
 * For licensing information see the LICENSE file.
 */

namespace Modules\ORM;

use Miny\Application\BaseApplication;
use Miny\CoreEvents;
use Miny\Log\Log;
use ORMiny\EntityManager;

class Module extends \Miny\Modules\Module
{
    public function defaultConfiguration()
    {
        return [
            'entityMap' => [],
            'driver' => 'ORMiny\\Drivers\\AnnotationMetadataDriver'
        ];
    }

    public function getDependencies()
    {
        return ['Annotation', 'DBAL'];
    }

    public function init(BaseApplication $app)
    {
        $container = $app->getContainer();
        $container->addAlias('ORMiny\\MetadataDriverInterface', $this->getConfiguration('driver'));

        /** @var EntityManager $entityManager */
        $entityManager = $container->get('ORMiny\\EntityManager');
        $entityManager->setDefaultNamespace($this->getConfiguration('defaultNamespace', ''));
        foreach ($this->getConfiguration('entityMap') as $entityName => $className) {
            $entityManager->register($entityName, $className);
        }
    }

    public function eventHandlers()
    {
        $container = $this->application->getContainer();
        return [
            CoreEvents::SHUTDOWN => function () use ($container) {
                /** @var EntityManager $entityManager */
                $entityManager = $container->get('ORMiny\\EntityManager');
                try {
                    $entityManager->commit();
                } catch (\Exception $e) {
                    /** @var Log $log */
                    $log = $container->get('Miny\\Log\\Log');
                    $log->write(Log::ERROR, 'Miny-ORM', $e->getMessage());
                    $log->write(Log::ERROR, 'Miny-ORM', $e->getTraceAsString());
                }
            }
        ];
    }
}
