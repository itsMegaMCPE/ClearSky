<?php
namespace pocketmine\entity;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item as drp;
use pocketmine\nbt\tag\Int;
use pocketmine\Player;

class Rabbit extends Animal{
    const NETWORK_ID = 18;

    const TYPE_BROWN = 0;
    const TYPE_BLACK = 1;
    const TYPE_ALBINO = 2;
    const TYPE_SPOTTED = 3;
    const TYPE_SALT_PEPPER = 4;
    const TYPE_GOLDEN = 5;

    public $height = 0.5;
    public $width = 0.5;
    public $lenght = 0.5;
	
	protected $exp_min = 1;
	protected $exp_max = 3;

    public function initEntity(){
        $this->setMaxHealth(3);
        parent::initEntity();
        if(!isset($this->namedtag->Type)){
            $this->setType(mt_rand(0, 5));
        }
    }

    public function getName(){
        return "Rabbit";
    }

    public function spawnTo(Player $player){
        $pk = $this->addEntityDataPacket($player);
        $pk->type = Rabbit::NETWORK_ID;

        $player->dataPacket($pk);
        parent::spawnTo($player);
    }

    public function setType($type){
        $this->namedtag->Profession = new Int("Type", $type);
    }

    public function getType(){
        return $this->namedtag["Type"];
    }

    public function getDrops(){
        $drops = [drp::get(drp::RABBIT_HIDE, 0, mt_rand(0, 2))];

        if($this->getLastDamageCause() === EntityDamageEvent::CAUSE_FIRE){
            $drops[] = drp::get(drp::COOKED_RABBIT, 0, mt_rand(1, 2));
        }else{
            $drops[] = drp::get(drp::RAW_RABBIT, 0, mt_rand(1, 2));
        }

        return $drops;
    }


}