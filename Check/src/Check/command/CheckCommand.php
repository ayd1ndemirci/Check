<?php

namespace Check\command;

use Check\form\CheckForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class CheckCommand extends Command
{

    public function __construct()
    {
        parent::__construct("cek", "Çek Menüsü", "/cek", ["check"]);
    }
    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if ($player instanceof Player) {
            $player->sendForm(new CheckForm($player));
        }
    }
}