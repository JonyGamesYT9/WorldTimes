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

use JonyGamesYT9\WorldTimes\WorldTimes;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\world\World as PMWorld;

class World {

    public function __construct(
        private string $name,
        private int $time,
        private bool $stopTime
    ) {}

    public function getName(): string {
        return $this->name;
    }

    public function getTime(): int {
        return $this->time;
    }

    public function isStopped(): bool {
        return $this->stopTime;
    }

    public function apply(): void {
        if (!Server::getInstance()->getWorldManager()->loadWorld($this->name)) {
            WorldTimes::getInstance()->getLogger()->debug(TextFormat::RED . 'Failed to fetch the world ' . $this->name . ', the world path not exists or is not valid.');
            return;
        }

        $world = Server::getInstance()->getWorldManager()->getWorldByName($this->name);
        $world?->setTime($this->getTime());
        if ($this->isStopped()) {
            $world?->stopTime();
        }

        WorldTimes::getInstance()->getLogger()->info(TextFormat::GREEN . 'World ' . $this->name . ' applied successfully.');
    }

    public static function convertTimeToInt(string $time): int {
        return match (strtolower($time)) {
            'full' => PMWorld::TIME_FULL,
            'night' => PMWorld::TIME_NIGHT,
            'midnight' => PMWorld::TIME_MIDNIGHT,
            'noon' => PMWorld::TIME_NOON,
            'sunrise' => PMWorld::TIME_SUNRISE,
            'sunset' => PMWorld::TIME_SUNSET,
            default => PMWorld::TIME_DAY
        };
    }

    public static function fromData(string $name, array $data): self {
        return new self($name, self::convertTimeToInt($data['time']), $data['stop_time']);
    }
}