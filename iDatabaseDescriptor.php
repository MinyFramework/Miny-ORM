<?php

/**
 * This file is part of the Miny framework.
 * (c) Dániel Buga <daniel@bugadani.hu>
 *
 * For licensing information see the LICENSE file.
 */

namespace Modules\ORM;

interface iDatabaseDescriptor
{
    public function getForeignKeyFormat();
    public function getTableNameFormat();
    public function getTableDescriptors();
}
