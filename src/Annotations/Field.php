<?php

/**
 * This file is part of the Miny framework.
 * (c) Dániel Buga <bugadani@gmail.com>
 *
 * For licensing information see the LICENSE file.
 */

namespace Modules\ORM\Annotations;

/**
 * @Annotation
 * @DefaultAttribute name
 * @Attribute('name', type: 'string')
 * @Attribute('setter')
 * @Attribute('getter')
 * @Target('property')
 */
class Field
{
    public $name;
    public $setter;
    public $getter;
}
