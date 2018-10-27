<?php
declare(strict_types=1);

namespace Napol\Scoreboard;

use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\utils\Config;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

#Task Scoreboard
use Napol\Scoreboard\Task\ScoreboardTask;

class Scoreboard extends PluginBase implements Listener{

  private static $instance;
  private $scoreboards = [];
  
  public function onLoad(): void {
    self::$instance = $this;
  }
  
  public function onEnable(): void {
    $this->saveResource("config.yml");
    $this->getScheduler()->scheduleRepeatingTask(new ScoreboardTask($this, 0), (int)$this->getConfig()->get("update-interval"));
    $this->getLogger()->info("§eScoreboard §ahas Enabled!");
    $this->getLogger()->info("§bAuthor§f: §aNapolGamer TH");
  }
  
	public static function getInstance(): Scoreboard {
		return self::$instance;
	}
  
	public function new(Player $player, string $objectiveName, string $displayName): void {
		if(isset($this->scoreboards[$player->getName()])){
			$this->remove($player);
		}
		$pk = new SetDisplayObjectivePacket();
		$pk->displaySlot = "sidebar";
		$pk->objectiveName = $objectiveName;
		$pk->displayName = $displayName;
		$pk->criteriaName = "dummy";
		$pk->sortOrder = 0;
		$player->sendDataPacket($pk);
		$this->scoreboards[$player->getName()] = $objectiveName;
	}
	public function remove(Player $player): void {
		$objectiveName = $this->getObjectiveName($player);
		$pk = new RemoveObjectivePacket();
		$pk->objectiveName = $objectiveName;
		$player->sendDataPacket($pk);
		unset($this->scoreboards[$player->getName()]);
	}
	public function setLine(Player $player, int $score, string $message): void {
		if(!isset($this->scoreboards[$player->getName()])){
			$this->getLogger()->error("Cannot set a score to a player with no scoreboard");
			return;
		}
		if($score > 15 || $score < 1){
			$this->getLogger()->error("Score must be between the value of 1-15. $score out of range");
			return;
		}
		$objectiveName = $this->getObjectiveName($player);
		$entry = new ScorePacketEntry();
		$entry->objectiveName = $objectiveName;
		$entry->type = $entry::TYPE_FAKE_PLAYER;
		$entry->customName = $message;
		$entry->score = $score;
		$entry->scoreboardId = $score;
		$pk = new SetScorePacket();
		$pk->type = $pk::TYPE_CHANGE;
		$pk->entries[] = $entry;
		$player->sendDataPacket($pk);
	}
	public function getObjectiveName(Player $player): ?string {
		return isset($this->scoreboards[$player->getName()]) ? $this->scoreboards[$player->getName()] : null;
	}
	public function onQuit(PlayerQuitEvent $event): void {
		if(isset($this->scoreboards[($player = $event->getPlayer()->getName())])) unset($this->scoreboards[$player]);
	}
}
