<?php

declare (strict_types=1);

namespace FirstLogin;

use pocketmine\event\EventPriority;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

final class Plugin extends PluginBase
{

    protected Config $joinnedListFile;

    protected function onEnable(): void
    {
        $this->joinnedListFile = new Config($this->getDataFolder() . 'joinned.txt', Config::ENUM);
        $this->getServer()->getPluginManager()->registerEvent(
            PlayerJoinEvent::class,
            function (PlayerJoinEvent $event) : void {
                $player = $event->getPlayer();
                $username = strtolower($player->getName());
                if (!$this->joinnedListFile->exists($username))
                {
                    $this->getServer()->broadcastMessage("§8-  §7è a primeira vez do jogador §f{$player->getName()} §7jogando neste servidor! Seja bem vindo");
                    $this->joinnedListFile->set($username);
                    $this->joinnedListFile->save();
                }
            }, EventPriority::MONITOR, $this
        );
    }
}