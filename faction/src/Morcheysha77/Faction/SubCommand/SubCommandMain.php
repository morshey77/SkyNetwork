<?php


namespace Morcheysha77\Faction\SubCommand;


class SubCommandMain extends SubCommand
{

    /** @var array<string, SubCommand> $subcommands */
    protected array $subcommands = [];

    public function getCommand(string $name): ?SubCommand
    {
        return $this->subcommands[$name] ?? null;
    }

    public function matchSubCommand(string &$command, array &$args): ?SubCommand
    {

        $count = min(count($args), 255);

        for($i = 0; $i < $count; ++$i) {

            $command .= array_shift($args);

            if(($command = $this->getCommand($command)) !== null) return $command;

            $command .= " ";

        }

        return null;
    }

    /**
     * @param string $dir
     */
    protected function registerSubCommand(string $dir): void
    {
        foreach (scandir($dir) as $file) {
            if(!in_array($file, [".", ".."])) {
                if(is_dir($dir . "/" . $file)) $this->registerSubCommand($dir . "/" . $file);
                else {

                    $name = "\\" . str_replace([dirname(__FILE__), "/", ".php"], ["", "\\", ""], __NAMESPACE__ . $dir . "/" . $file);
                    $class = new $name($this->plugin);

                    if($class instanceof SubCommand) {

                        $this->subcommands[str_replace(".php", "", $file)] = $class;

                        foreach ($class->getAlias() as $alias) {

                            $this->subcommands[$alias] = $class;

                        }
                    }
                }
            }
        }
    }
}