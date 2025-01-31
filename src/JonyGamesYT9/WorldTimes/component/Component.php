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

use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;

abstract class Component {

    public function onLoad(PluginBase $plugin): void {}

    public function onEnable(Plugin $plugin): void {}

    public function onDisable(Plugin $plugin): void {}

}