<?php


namespace Morcheysha77\Faction\Tasks;


use pocketmine\scheduler\Task;

use pocketmine\math\Vector3;
use pocketmine\world\Position;

use pocketmine\world\sound\AnvilBreakSound;
use pocketmine\world\sound\ClickSound;
use pocketmine\world\sound\EndermanTeleportSound;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Constants\Command as CommandConstant;

class TeleportTask extends Task implements CommandConstant
{

    /** @var FPlayer $player */
    private FPlayer $player;
    /** @var Position $position */
    private Position $position;

    /** @var string $message */
    private string $message;

    /** @var Vector3 $vector3 */
    private Vector3 $vector3;

    /** @var int $time */
    private int $time = 6;

    /**
     * TeleportTask constructor.
     * @param FPlayer $player
     * @param Position $position
     * @param string $message
     */
    public function __construct(FPlayer $player, Position $position, string $message)
    {
        $this->player = $player;
        $this->position = $position;
        $this->message = $message;
        $this->vector3 = $player->getPosition()->asVector3();
    }

    public function onRun(): void
    {

        $this->player->sendPopup(self::PREFIX . "Téléportation dans §f" . --$this->time . " §9secondes. Ne bougez pas.");
        $this->player->getWorld()->addSound($this->vector3, new ClickSound());

        if($this->vector3->distance($this->player->getPosition()->asVector3()) >= 1)
        {

            $this->player->sendPopup(self::PREFIX . "La téléportation a était annuler car vous avez bougez...");
            $this->player->getWorld()->addSound($this->vector3, new AnvilBreakSound());

            $this->getHandler()->cancel();

        } elseif($this->time < 1) {

            $this->player->sendMessage($this->player->translate("teleported_to", [$this->message]));
            $this->player->teleport($this->position);
            $this->player->getWorld()->addSound($this->vector3, new EndermanTeleportSound());

            $this->getHandler()->cancel();

        }
    }
}