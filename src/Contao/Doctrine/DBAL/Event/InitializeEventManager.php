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

namespace Contao\Doctrine\DBAL\Event;

use Doctrine\Common\EventManager;
use Symfony\Component\EventDispatcher\Event;

class InitializeEventManager extends Event
{
	/**
	 * @var EventManager
	 */
	protected $eventManager;

	function __construct(EventManager $eventManager)
	{
		$this->eventManager = $eventManager;
	}

	/**
	 * @return \Doctrine\Common\EventManager
	 */
	public function getEventManager()
	{
		return $this->eventManager;
	}
}
