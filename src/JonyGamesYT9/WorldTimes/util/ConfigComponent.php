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

namespace JonyGamesYT9\WorldTimes\util;

use JonyGamesYT9\WorldTimes\component\Component;
use JonyGamesYT9\WorldTimes\component\util\FetchFile;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;

class ConfigComponent extends Component {
    use SingletonTrait {
        setInstance as private;
        reset as private;
    }

    private array $data;

    public const CONFIG_VERSION = '1';

    public function __construct() {
        self::setInstance($this);
    }

    public function onLoad(PluginBase $plugin): void {
        $plugin->saveResource('config.yml');
    }

    public function onEnable(Plugin $plugin): void {
        $this->data = (new FetchFile('config.yml'))->getDataAll();

        if (!$this->isConfigUpdated()) {
            $plugin->getLogger()->error('Your config.yml version is outdated. Please delete the plugin_data of this plugin to reload components.');
            Server::getInstance()->getPluginManager()->disablePlugin($plugin);
        }
    }

    public function isConfigUpdated(): bool {
        return $this->data['config-version'] === self::CONFIG_VERSION;
    }

    public function getWorlds(): array {
        return $this->data['worlds'];
    }
}