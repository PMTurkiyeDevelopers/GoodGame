<?php

                                     ###### New Version 1.4 ######
                                     # Working particles now!    #
                                     # Working Teleportation now!#
                                     # Added NameTag Chating!    #
                                     #############################

namespace GoodGame;

# PLUGIN
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
# EVENTS
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\player\PlayerExperienceChangeEvent;
# SOUNDS
use pocketmine\level\sound\FizzSound;
use pocketmine\level\sound\ClickSound;
use pocketmine\level\sound\BatSound;
use pocketmine\level\sound\LaunchSound;
use pocketmine\level\sound\PopSound;
# PARTICLES
use pocketmine\level\particle\BubbleParticle;
use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\level\particle\FlameParticle;
# COMMAND
// use commands coming soon...
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
# OTHERS
use pocketmine\Player;
use pocketmine\Level;
use pocketmine\utils\TextFormat;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
# CODE...
class Main extends PluginBase implements Listener
{
        ##############
		### ON/OFF ###
		##############
		
        public function OnEnable(){
			    $this->getServer()->getPluginManager()->registerEvents($this, $this);
                $this->getServer()->getLogger()->info("[§eGood§bGame] §aPlugin Has been Enabled!");
				@mkdir($this->getDataFolder());
				$this->saveDefaultConfig();
        }
        
        public function OnLoad() {
                $this->getServer()->getLogger()->info("[§eGood§bGame] §ePlugin Loading...!");
        }
        
        public function OnDisable() {
                $this->getLogger()->info("[§eGood§bGame] §cPlugin Has been Disabled!");
				$this->saveDefaultConfig();
        }

		##############
		### EVENTS ###
		##############
      
        public function OnDeath(PlayerDeathEvent $event){
                $player = $event->getPlayer();
        	$player->getLevel()->addSound(new FizzSound($player));
                $player->sendMessage("§7============");
                $player->sendMessage("§7==§cYOU DIED!§7==");
                $player->sendMessage("§7============");
        }
        
        public function OnRespawn(PlayerRespawnEvent $event){
                $player = $event->getPlayer();
        	$player->getLevel()->addSound(new BatSound($player));
        	$player->sendTip("§aRespawned!");
        }
        
        public function OnJoin(PlayerJoinEvent $event){
                $player = $event->getPlayer();
        	$player->getLevel()->addSound(new BatSound($player));
                $event->setJoinMessage("§6- Welcome to the §bAWESOME §eServer, §a".$player->getName());
                $x=$player->x;
                $y=$player->y;
                $z=$player->z;
                $player->getLevel()->addParticle(new BubbleParticle(new Vector3($x, $y , $z)));
        }
        
        public function onHold(PlayerItemHeldEvent $event){
                $player = $event->getPlayer();
            if($event->getItem()->getId() == 46){
                $player->sendPopup(TextFormat:: AQUA . "Your Inventory Clearing...");
                $player->getInventory()->clearAll();
            }
            if($event->getItem()->getId() == 347){
                $player->sendPopup("§a(Returning to Hub...");
                $spawn = $this->getServer()->getDefaultLevel()->getSafeSpawn();
                $player->teleport($spawn);//and now work TELEPORT :)
                $x=$player->x;
                $y=$player->y;
                $z=$player->z;
				$player->getLevel()->addParticle(new FlameParticle(new Vector3($x + 2, $y + 2, $z + 2)));
            }
        }
        
        public function OnDrop(PlayerDropItemEvent $event) {
                $player = $event->getPlayer();
                $player->sendTip("§bItem Dropped!");
                $player->getLevel()->addSound(new PopSound($player));
                $x=$player->x;
                $y=$player->y;
                $z=$player->z;
                $player->getLevel()->addParticle(new FlameParticle(new Vector3($x + 2, $y + 2, $z + 2)));
        }
        
        public function OnChat(PlayerChatEvent $event){
                $player = $event->getPlayer();
                $player->getLevel()->addSound(new ClickSound($player));
                $player->setNameTag("§aChatting..");
				$event->setFormat("§8[§eO_O§8]§d %s >".$event->getMessage());
				$player->setNameTag($player->getName());
				
        }
		
		public function OnXPChange(PlayerExperienceChangeEvent $event){
			$p=$event->getPlayer();
			$p->sendTip("§aNew Level Opened!");
			$p->getLevel()->addSound(new LaunchSound($p));
			$player->getLevel()->addParticle(new FlameParticle(new Vector3($x + 2, $y + 2, $z + 2)));
		}
		
		#  NEW EVENTS = NEXT UPTADE!!!
		# New more Events Soon...
}
# END OF PLUGIN
?>