<?php

                                     ###### Yeni Sürüm 1.4 ######
                                     # Parçacıklar Çalışıyor!   #
                                     # Işınlanma Çalışıyor!     #
                                     # Konuşuyor İsmi Eklendi!  #
                                     ############################

namespace GoodGame;

# EKLENTİ
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
# SESLER
use pocketmine\level\sound\FizzSound;
use pocketmine\level\sound\ClickSound;
use pocketmine\level\sound\BatSound;
use pocketmine\level\sound\LaunchSound;
use pocketmine\level\sound\PopSound;
# PARÇACIKLAR
use pocketmine\level\particle\BubbleParticle;
use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\level\particle\FlameParticle;
# KOMUT
// komutlar yakında kullanılacak
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
# DİĞERLERİ
use pocketmine\Player;
use pocketmine\Level;
use pocketmine\utils\TextFormat;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
# KOD...
class Main extends PluginBase implements Listener
{
        ##############
		### AÇ/KAPA ##
		##############
		
        public function OnEnable(){
			    $this->getServer()->getPluginManager()->registerEvents($this, $this);
                $this->getServer()->getLogger()->info("[§eGood§bGame] §aEklenti Açıldı!");
				@mkdir($this->getDataFolder());
				$this->saveDefaultConfig();
        }
        
        public function OnLoad() {
                $this->getServer()->getLogger()->info("[§eGood§bGame] §eEklenti Yükleniyor...");
        }
        
        public function OnDisable() {
                $this->getLogger()->info("[§eGood§bGame] §cEklenti Kapandı!");
				$this->saveDefaultConfig();
        }

		##############
		### EVENTS ###
		##############
      
        public function OnDeath(PlayerDeathEvent $event){
                $player = $event->getPlayer();
        	$player->getLevel()->addSound(new FizzSound($player));
                $player->sendMessage("§7============");
                $player->sendMessage("§7==§cÖLDÜN!§7==");
                $player->sendMessage("§7============");
        }
        
        public function OnRespawn(PlayerRespawnEvent $event){
                $player = $event->getPlayer();
        	$player->getLevel()->addSound(new BatSound($player));
        	$player->sendTip("§aYeniden Doğdun!");
        }
        
        public function OnJoin(PlayerJoinEvent $event){
                $player = $event->getPlayer();
        	$player->getLevel()->addSound(new BatSound($player));
                $event->setJoinMessage("§6 Muhteşem Sunucuya Hoşgeldin, §a".$player->getName());
                $x=$player->x;
                $y=$player->y;
                $z=$player->z;
                $player->getLevel()->addParticle(new BubbleParticle(new Vector3($x, $y , $z)));
        }
        
        public function onHold(PlayerItemHeldEvent $event){
                $player = $event->getPlayer();
            if($event->getItem()->getId() == 46){
                $player->sendPopup(TextFormat:: AQUA . "Envanterin Temizleniyor...");
                $player->getInventory()->clearAll();
            }
            if($event->getItem()->getId() == 347){
                $player->sendPopup("§aHuba Geri Dönülüyor...");
                $spawn = $this->getServer()->getDefaultLevel()->getSafeSpawn();
                $player->teleport($spawn);//ve Işınlanma şimdi çalışıyor :)
                $x=$player->x;
                $y=$player->y;
                $z=$player->z;
				$player->getLevel()->addParticle(new FlameParticle(new Vector3($x + 2, $y + 2, $z + 2)));
            }
        }
        
        public function OnDrop(PlayerDropItemEvent $event) {
                $player = $event->getPlayer();
                $player->sendTip("§bEşya Bırakıldı!");
                $player->getLevel()->addSound(new PopSound($player));
                $x=$player->x;
                $y=$player->y;
                $z=$player->z;
                $player->getLevel()->addParticle(new FlameParticle(new Vector3($x + 2, $y + 2, $z + 2)));
        }
        
        public function OnChat(PlayerChatEvent $event){
                $player = $event->getPlayer();
                $player->getLevel()->addSound(new ClickSound($player));
                $player->setNameTag("§aKonuşuyor...");
				$event->setFormat("§8[§eO_O§8]§d %s >".$event->getMessage());
				$player->setNameTag($player->getName());
				
        }
		
		public function OnXPChange(PlayerExperienceChangeEvent $event){
			$p=$event->getPlayer();
			$p->sendTip("§aYeni Seviye Açıldı!");
			$p->getLevel()->addSound(new LaunchSound($p));
			$player->getLevel()->addParticle(new FlameParticle(new Vector3($x + 2, $y + 2, $z + 2)));
		}
		
		#  YENİ EVENTS = GELECEK GÜNCELLEME!!!
		# Yeni daha fazla events yakında...
}
# EKLENTİNİN SONU
?>
