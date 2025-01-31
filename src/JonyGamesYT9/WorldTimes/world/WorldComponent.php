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

namespace JonyGamesYT9\WorldTimes\world;

use JonyGamesYT9\WorldTimes\component\Component;
use JonyGamesYT9\WorldTimes\util\ConfigComponent;
use pocketmine\plugin\Plugin;
use pocketmine\utils\SingletonTrait;

class WorldComponent extends Component {
    use SingletonTrait {
        setInstance as private;
        reset as private;
    }

    private array $worlds = [];

    public function __construct() {
        self::setInstance($this);
    }

    public function onEnable(Plugin $plugin): void {
        foreach (ConfigComponent::getInstance()->getWorlds() as $worldName => $worldData) {
            $this->add(World::fromData($worldName, $worldData));
        }

        foreach ($this->getWorlds() as $world) {
            $world->apply();
        }
    }

    public function add(World $world): void {
        $this->worlds[$world->getName()] = $world;
    }

    /**
     * @return World[]
     */
    public function getWorlds(): array {
        return $this->worlds;
    }
}