<?php

/**
 * This file is part of the Miny framework.
 * (c) Dániel Buga <daniel@bugadani.hu>
 *
 * For licensing information see the LICENSE file.
 */

namespace Modules\ORM;

use Miny\Application\BaseApplication;

class Module extends \Miny\Modules\Module
{
    public function defaultConfiguration()
    {
        return [
            'entityMap' => [],
            'driver'    => 'ORMiny\\Drivers\\AnnotationMetadataDriver'
        ];
    }

    public function getDependencies()
    {
        return ['Annotation', 'DBAL'];
    }

    public function init(BaseApplication $app)
    {
        $container = $app->getContainer();
        $container->addAlias('ORMiny\\Driver', $this->getConfiguration('driver'));

        $entityManager = $container->get('ORMiny\\EntityManager');
        $entityManager->setDefaultNamespace($this->getConfiguration('defaultNamespace', ''));
        foreach ($this->getConfiguration('entityMap') as $entityName => $className) {
            $entityManager->register($entityName, $className);
        }
    }
}
