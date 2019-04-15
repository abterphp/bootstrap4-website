<?php

use AbterPhp\Bootstrap4Website\Bootstrappers;
use AbterPhp\Bootstrap4Website\Events;
use AbterPhp\Framework\Constant\Module;
use AbterPhp\Website\Constant\Event as WebsiteEvent;

return [
    Module::IDENTIFIER         => 'AbterPhp\Bootstrap4Website',
    Module::DEPENDENCIES       => ['AbterPhp\Website'],
    Module::ENABLED            => true,
    Module::HTTP_BOOTSTRAPPERS => [
        Bootstrappers\Events\Listeners::class,
    ],
    Module::EVENTS             => [
        WebsiteEvent::WEBSITE_READY => [
            /** @see \AbterPhp\Bootstrap4Website\Events\Listeners\WebsiteDecorator::handle */
            sprintf('%s@handle', Events\Listeners\WebsiteDecorator::class),
        ],
    ],
    Module::RESOURCE_PATH    => realpath(__DIR__ . '/resources'),
];
