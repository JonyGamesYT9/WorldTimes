<?php
/*
 * Copyright Redlive Studios (c) 2024.
 * 
 * This file and any attachments are only for the use of the intended recipient and may contain information
 * that is legally privileged, confidential or exempt from disclosure under applicable law.
 *
 * If you are not the intended recipient, any disclosure, distribution or other use of this file or attachments is prohibited.
 *
 */

namespace JonyGamesYT9\WorldTimes\component;

use JonyGamesYT9\WorldTimes\util\ConfigComponent;
use JonyGamesYT9\WorldTimes\world\WorldComponent;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class ComponentRegistry extends Component {
    use SingletonTrait {
        setInstance as private;
        reset as private;
    }

    private array $defaults = [
        ConfigComponent::class,
        WorldComponent::class
    ];

    public function __construct() {
        self::setInstance($this);

        foreach ($this->defaults as $default) {
            $this->components[] = new $default();
        }
    }

    public function onLoad(PluginBase $plugin): void {
        foreach ($this->components as $component) {
            $component->onLoad($plugin);
        }
    }

    public function onEnable(Plugin $plugin): void {
        foreach ($this->components as $component) {
            $component->onEnable($plugin);
        }
    }

    public function onDisable(Plugin $plugin): void {
        foreach ($this->components as $component) {
            $component->onDisable($plugin);
        }
    }

    /** @var Component[] $components */
    private array $components = [];
}
