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

namespace Contao\Doctrine\DBAL;

/**
 * Class DoctrineDbalEvents
 * @package Contao\Doctrine\DBAL
 */
class DoctrineDbalEvents
{
    /**
     * The INITIALIZE_EVENT_MANAGER event occurs when the event manager will be created.
     *
     * This event allows you to add custom listeners to the doctrine event manager.
     * The event listener method receives a Contao\Doctrine\DBAL\Event\InitializeEventManager instance.
     *
     * @var string
     *
     * @api
     */
    const INITIALIZE_EVENT_MANAGER = 'doctrine.dbal.initialize-event-manager';
}
