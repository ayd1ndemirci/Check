<?php

namespace Check;

use Check\command\CheckCommand;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{
    public static Main $main;
    
    public function onLoad():void
    {
        self::$main = $this;
    }
    protected function onEnable(): void
    {
        $this->getLogger()->info("Çek aktif - ayd4ndemirci");
        $this->getServer()->getCommandMap()->register("cek", new CheckCommand());
        $this->getServer()->getPluginManager()->registerEvents(new CheckListener(), $this);
    }
}
