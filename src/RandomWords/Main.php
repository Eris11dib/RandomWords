<?php

namespace RandomWords;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChangeSkinEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\plugin\Plugin;
use pocketmine\item\Item;
use RandomWords\Task\TimeTask;

class Main extends PluginBase implements Listener{

    public $prefix = "[§l§3RandomWords§r] =>";
    public $word;
    public $indovinato = false;
    public $economy;
    public $winner;

    public function onEnable(){

        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info($this->prefix . " §l§3Plugin Enabled");
        $this->economy = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
        $this->getScheduler()->scheduleRepeatingTask(new TimeTask($this),$this->getConfig()->get("time_message"));
    }

    /**
     * @param PlayerChatEvent $event
     */

    public function onChat(PlayerChatEvent $event){
        $player = $event->getPlayer();
		$msg = $event->getMessage();
		if($msg === $this->word){
			if($this->indovinato === true){
				$player->sendMessage($this->prefix . " Qualcuno ha già scritto la parola prima di te");
				$event->setCancelled(true);
			}else if($this->winner !== $player->getName()){
				$event->setCancelled(true);
				$this->getServer()->broadcastMessage($this->prefix . " Il Player " . "§6" . $player->getName() . "§r" . " ha scritto per primo la parola e ha vinto il premio");
				$rand = $this->getConfig()->get("rewards");
				$rand1 = $rand[array_rand($rand)];
				if(is_int($rand1)){
					$this->economy->addMoney($player,$rand1);
					$player->sendMessage($this->prefix . "Hai ricevuto: " . $rand1);
					$this->winner = $event->getPlayer()->getName();
				}else{
							$expl = explode(":", $rand1);
							$player->getInventory()->addItem(Item::get((int) $expl[0], (int) $expl[1], (int) $expl[2]));
							$this->winner = $event->getPlayer()->getName();
						}
					$this->indovinato = true;
					}else if ($msg === $this->word && $this->winner == $event->getPlayer()->getName()){
				$player->sendMessage($this->prefix . "Non puoi partecipare a questo round");
				$event->setCancelled(true);
			}
		}
	}
}