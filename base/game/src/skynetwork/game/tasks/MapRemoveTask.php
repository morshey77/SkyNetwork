<?php

namespace skynetwork\game\tasks;

use pocketmine\scheduler\AsyncTask;

class MapRemoveTask extends AsyncTask
{

    public function __construct(private readonly string $dir){}

    /**
     * @inheritDoc
     */
    public function onRun(): void
    {
        $this->removeRecursiveDirectory($this->dir);
    }

    /**
     * @param $dir
     * @return void
     */
    private function removeRecursiveDirectory($dir): void
    {
        foreach (array_diff(scandir($dir), array('.', '..')) as $file) {
            if(is_dir($filename = $dir . DIRECTORY_SEPARATOR . $file) AND !is_link($filename))
                $this->removeRecursiveDirectory($filename);
            else
                unlink($filename);
        }

        rmdir($dir);
    }
}