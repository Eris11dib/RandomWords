<?php

namespace RandomWords\Task;

use pocketmine\scheduler\Task;
use RandomWords\Main;

class TimeTask extends Task{

    public $main;

    public function __construct(Main $main){
        $this->main = $main;
    }

    public function onRun(int $tick){

        if(count($this->main->getServer()->getOnlinePlayers()) < $this->main->getConfig()->get("max_players")){
            return;
        }
        $rand = $this->main->getConfig()->get("words");
        $rand1 = $rand[array_rand($rand)];
        $this->main->getServer()->broadcastMessage($this->main->prefix . " Il primo che scriverà " . $rand1 . " riceverà un premio totalmente a caso");
        $this->main->word = $rand1;
        $this->main->indovinato = false;
    }

}