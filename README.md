# Scoreboard

**Scoreboard is a PocketMine-MP & Altay plugin that helps creatings scoreboard in MCPE 1.7!**
**Credit: [TwistedAsylumMC](https://github.com/TwistedAsylumMC/Scoreboards)**

## How to install!?
 - You can get the `.phar` file by clicking [here](https://poggit.pmmp.io/ci/NapolGamerTH/Scoreboards).
 - Add the `.phar` file to your `/plugins` directory.
 - You can edit the *Scoreboard* in config.yml `/plugins/Scoreboard` & restart your server.
 ***Note: This plugin only works on MCPE 1.7 and above.***
 
 ## Usage
  You'll need to import the `Napol\Scoreboard\Scoreboard.php` class. This is the main class and probably the only class you'll need for creating Scoreboard.
 ```php
 <?php
 use Napol\Scoreboard\Scoreboard;
 ```
 
 ### Creating an instance
  In the small documentation, `$api` will be used to refer to an instance of Scoreboards. You can create an instance by doing:
```php
$api = Scoreboard::getInstance();
``` 
 
### Creating a Scoreboard
  `$api::new()` creates a new Scoreboard with an objective name, display name and then sends it to a player.
```php
/** @var Player $player */
$api->new($player, "ObjectiveName", "Title of scoreboard in game");
```
  `$api::remove()` removes a Scoreboard from a player. You do not need to enter an objective name as it is stored from `$api::new()`.
```php
/** @var Player $player */
$api->remove($player);
```
  `$api::setLine()` sets a line's text. This only works if the player has a scoreboard sent to them. The `1` is the line, and can go up to `15`.
```php
/** @var Player $player */
$api->setLine($player, 1, "Line Text");
```
  `$api::getObjectiveName` returns a string of the Player's objective name from their scoreboard, returns null if the player does not have a scoreboard.
```php
/** @var Player $player */
$api->getObjectiveName($player);
```
  To update an existing scoreboard, you can simply use `$api::new()` again, and it will remove the Player's existing one, and add the new one.
```php
$api->new($player, 1, "Line 1");
$api->new($player, 2, "Line 2");
$api->new($player, 3, "Line 3");
```
