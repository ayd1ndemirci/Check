<?php

namespace Check;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemUseEvent;
use onebone\economyapi\EconomyAPI;
use pocketmine\world\sound\XpLevelUpSound;

class CheckListener implements Listener
{
    function itemUseEvent(PlayerItemUseEvent $event)
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        if (!$item->getNamedTag()->getTag("amount")) return;
        $amount = $item->getNamedTag()->getString("amount");
        $player->sendMessage("§a" . $amount . " TL §2değerinde çek bozduruldu!");
        $player->getInventory()->removeItem($player->getInventory()->getItemInHand());
        EconomyAPI::getInstance()->addMoney($player, $amount);
        $player->getWorld()->addSound($player->getPosition(), new XpLevelUpSound(10), [$player]);
    }
}