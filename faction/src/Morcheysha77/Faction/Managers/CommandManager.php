<?php


namespace Morcheysha77\Faction\Managers;


class CommandManager extends Manager
{
    
    private array $blocked =
    [
        "about",
        "ban",
        "ban-ip",
        "banlist",
        "difficulty",
        "kick",
        "kill",
        "me",
        "pardon",
        "pardon-ip",
        "plugins",
        "tp"
    ];

    /**
     * @return string
     */
    public function getName(): string 
    {
        return "command";
    }
    
    public function init(): void
    {
        
        $commands = $this->plugin->getServer()->getCommandMap();

        foreach ($this->blocked as $command){
            
            $command = $commands->getCommand($command);

            if ($command->isRegistered()) $commands->unregister($command);
        }
    }
}