<?php

/**
 * Doctrine DBAL Bridge
 * Copyright (C) 2013 Tristan Lins
 *
 * PHP version 5
 *
 * @copyright  bit3 UG 2013
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @package    doctrine-dbal
 * @license    LGPL
 * @filesource
 */

namespace Contao\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\BooleanType;
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\DBAL\Types\Type;

/**
 *
 */
class ContaoBooleanType extends BooleanType
{
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL(
			array_merge(
				$fieldDeclaration,
				array(
					 'length' => 1,
					 'fixed' => true
				)
			)
		);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value ? $platform->convertBooleans($value) : '';
    }

    public function getName()
    {
        return 'contaoBoolean';
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
