<?php

namespace Check;

use Check\command\CheckCommand;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase
{
    public static Main $main;
    public static Config $config;
    public function onLoad():void
    {
        self::$main = $this;
        $this->saveResource("config.yml");
        $this->saveResource("check-item.yml", 2);
        self::$config = new Config($this->getDataFolder()."config.yml", 2);
    }
    protected function onEnable(): void
    {
        $this->getLogger()->info("Çek aktif - ayd4ndemirci");
        $this->getServer()->getCommandMap()->register("cek", new CheckCommand());
        $this->getServer()->getPluginManager()->registerEvents(new CheckListener(), $this);
    }
}