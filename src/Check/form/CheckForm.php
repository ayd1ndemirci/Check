<?php

namespace Check\form;

use pocketmine\form\Form;
use pocketmine\item\ItemFactory;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use onebone\economyapi\EconomyAPI;
class CheckForm implements Form
{
    public array $turkish_date_format = [
        "01" => "Ocak",
        "02" => "Şubat",
        "03" => "Mart",
        "04" => "Nisan",
        "05" => "Mayıs",
        "06" => "Haziran",
        "07" => "Temmuz",
        "08" => "Ağustos",
        "09" => "Eylül",
        "10" => "Ekim",
        "11" => "Kasım",
        "12" => "Aralık"
    ];

    public function __construct(Player $player)
    {
        $this->player = $player;
    }
    function jsonSerialize(): array
    {
        return [
            "type" => "custom_form",
            "title" => "Çek Oluşturma Menüsü",
            "content" => [
                ["type" => "label", "text" => "§3Oluşturmak istediğin çek miktarını aşağıdaki kutucuğa yaz.\n§fParan: §7".EconomyAPI::getInstance()->myMoney($this->player)." TL\n"],
                ["type" => "input", "text" => "Çek Miktarı", "placeholder" => "Örnek: 7000", "default" => null]
            ]
        ];
    }
    function handleResponse(Player $player, $data): void
    {
        if (is_null($data)) return;
        $amount = (int)$data[1];
        $ecoapi = EconomyAPI::getInstance();
        if (!empty($amount)) {
            if (is_numeric($amount)) {
                if ($amount > 0) {
                    if ($ecoapi->myMoney($player) >= $amount) {
                        $item = VanillaItems::PAPER();
                        $item->setCustomName("§r§6" . $amount . " TL değerinde çek");
                        $item->setLore(["§r§aOluşturan: §2" . $player->getName(),
                            "§r§cOluşturulma Tarihi: §7" . date("d") . " " . $this->turkish_date_format[date("m")] . " " . date("Y H:i")]);
                        $item->getNamedTag()->setString("amount", $amount);
                        $item->getNamedTag()->setString("time", time());
                        if ($player->getInventory()->canAddItem($item)) {
                            $ecoapi->reduceMoney($player, $amount);
                            $player->getInventory()->addItem($item);
                            $player->sendMessage("§2Başarıyla §a" . $amount . " TL §2değerinde çek oluşturdun!");
                        } else $player->sendMessage("§cÇek oluşturabilmen için envanterinde boş alan olmalı!");
                    } else $player->sendMessage("§c" . $amount . " TL §4değerinde çek oluşturmak için§c " . $amount - $ecoapi->myMoney($this->player) . " TL §4gerekli!");
                } else $player->sendMessage("§cGirdiğiniz çek miktarı 1 ve 1'den büyük olmalı!");
            } else $player->sendMessage("§cSadece sayısal değer girebilirsin!");
        }
    }
}