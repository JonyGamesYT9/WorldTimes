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

namespace JonyGamesYT9\WorldTimes\component\util;

use JonyGamesYT9\WorldTimes\WorldTimes;
use JsonException;
use pocketmine\utils\Config;

class FetchFile {

    private string $path;

    private Config $config;

    private bool $changed = false;

    public function __construct(string $path) {
        $this->path = $path;
        $this->config = new Config(WorldTimes::getInstance()->getDataFolder() . $path, $this->getExtensionFromString(explode('.', $path)[1]));
    }

    public function setData(string $key, mixed $data): void {
        $this->setChanged();
        $this->getConfig()->set($key, $data);
    }

    public function setDataNested(string $key, mixed $data): void {
        $this->setChanged();
        $this->getConfig()->setNested($key, $data);
    }

    public function setDataAll(array $data, bool $save = false): void {
        $this->setChanged();
        $this->getConfig()->setAll($data);

        if ($save) {
            $this->save();
        }
    }

    public function getDataNested(string $key): mixed {
        return $this->getConfig()->getNested($key);
    }

    public function getDataAll(bool $keys = false): array {
        return $this->getConfig()->getAll($keys);
    }

    public function getData(string $key): mixed {
        return $this->getConfig()->get($key);
    }

    public function removeData(string $key): void {
        $this->getConfig()->remove($key);
    }

    public function removeDataNested(string $key): void {
        $this->getConfig()->removeNested($key);
    }

    /**
     * @throws JsonException
     */
    public function save(): void {
        if ($this->isChanged()) {
            $this->getConfig()->save();
            $this->setChanged(false);
        }
    }

    public function getExtensionFromString(string $extension): int {
        return match ($extension) {
            'yml', 'yaml' => Config::YAML,
            'json', 'js' => Config::JSON,
            default => Config::DETECT
        };
    }

    public function getConfig(): Config {
        return $this->config;
    }

    public function getPath(): string {
        return $this->path;
    }

    public function isChanged(): bool {
        return $this->changed;
    }

    public function setChanged(bool $changed = true): void {
        $this->changed = $changed;
    }
}