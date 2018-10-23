<?php
declare(strict_types=1);

namespace Napol\Scoreboard\Task;

use pocketmine\scheduler\Task;
use Napol\Scoreboard\Scoreboard;

class ScoreboardTask extends Task {

	private $plugin;
	private $titleIndex;
  
	public function __construct(Scoreboard $plugin, int $titleIndex) {
		$this->plugin = $plugin;
		$this->titleIndex = $titleIndex;
	}
  
	public function onRun(int $currentTick): void {
		$this->titleIndex++;
		$config = $this->plugin->getConfig();
		$titles = is_array($config->get("title")) ? $config->get("title") : ["Your Server"];
		$lines = is_array($config->get("line")) ? $config->get("line") : ["Please update your config"];
		if(!isset($titles[$this->titleIndex])) $this->titleIndex = 0;
		$api = Scoreboard::getInstance();
		foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
    /* <------------------------------> */
      $player = $p->getPlayer();
      $name = $player->getName();
      $online = $online = count(Server::getInstance()->getOnlinePlayers());
      $tps = $this->getServer()->getTicksPerSecond();
      $usage = $this->getServer()->getTickUsage();
      $max_online = $this->getServer()->getMaxPlayers();
      $hp = $player->getHealth();
      $maxhp = $player->getMaxHealth();
      $gm = $player->getGamemode();
      $fac = $this->plugin->factions->getPlayerFaction($player->getName());
      $xx = $player->getX();
      $yy = $player->getY();
      $zz = $player->getZ();
      $x = round($xx, 0);
      $y = round($yy, 0);
      $z = round($zz, 0);
      $group = $this->plugin->pp->getUserDataMgr()->getGroup($player)->getName();
      $money = $this->plugin->eco->myMoney($player->getName());
      $item = $player->getInventory()->getItemInHand()->getName();
      $id = $player->getInventory()->getItemInHand()->getId();
      $ids = $player->getInventory()->getItemInHand()->getDamage();
      $level = $player->getLevel()->getName();
      $ip = $player->getAddress();
      $tag = $player->getNameTag();
      $date = date("H.i");
      $kills = $this->plugin->killchat->getKills($name);
      $deaths = $this->plugin->killchat->getDeaths($name);
      $ping = $player->getPing($name);
      /* str_replace */
      $lines = $config->get("line");
      $lines = str_replace("{name}", $name, $bar);
      $lines = str_replace("{level}", $level, $bar);
      $lines = str_replace("{time}", $date, $bar);
      $lines = str_replace("{id}", $id, $bar);
      $lines = str_replace("{ids}", $ids, $bar);
      $lines = str_replace("{item}", $item, $bar);
      $lines = str_replace("{group}", $group, $bar);
      $lines = str_replace("{faction}", $fac, $bar);
      $lines = str_replace("{gm}", $gm, $bar);
      $lines = str_replace("{maxhp}", $maxhp, $bar);
      $lines = str_replace("{hp}", $hp, $bar);
      $lines = str_replace("{max_online}", $max_online, $bar);
      $lines = str_replace("{online}", $online, $bar);
      $lines = str_replace("{tps}", $tps, $bar);
      $lines = str_replace("{usage}", $usage, $bar);
      $lines = str_replace("{kills}", $kills, $bar);
      $lines = str_replace("{tag}", $tag, $bar);
      $lines = str_replace("{ip}", $ip, $bar);
      $lines = str_replace("{x}", $x, $bar);
      $lines = str_replace("{y}", $y, $bar);
      $lines = str_replace("{z}", $z, $bar);
      $lines = str_replace("{money}", $money, $bar);
      $lines = str_replace("{deaths}", $deaths, $bar);
      $lines = str_replace("{ping}", $ping, $bar);
      /* <------------------------------> */
			$api->new($p, $p->getName(), $titles[$this->titleIndex]);
			$i = 0;
			foreach($lines as $line){
				if($i < 15){
					$i++;
					$api->setLine($p, $i, $line);
				}
			}
		}
	}
}
