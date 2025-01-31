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

namespace JonyGamesYT9\WorldTimes;

use JonyGamesYT9\WorldTimes\component\ComponentRegistry;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class WorldTimes extends PluginBase {
    use SingletonTrait {
        setInstance as private;
        reset as private;
    }

    public function onLoad(): void {
        self::setInstance($this);

        ComponentRegistry::getInstance()->onLoad($this);
    }

    public function onEnable(): void {
        ComponentRegistry::getInstance()->onEnable($this);
    }

    public function onDisable(): void {
        ComponentRegistry::getInstance()->onDisable($this);
    }
}