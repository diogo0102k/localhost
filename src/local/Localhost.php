<?php

namespace local;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\MainLogger;

class Localhost extends PluginBase {

    private $localhostServer;

    public function onEnable() {
        $this->getLogger()->info("Plugin LocalhostConnect habilitado!");

        $logger = $this->getLogger(); // Obtém o logger do plugin
        $this->localhostServer = new LocalhostServer($logger);
        $this->localhostServer->start();
    }

    public function onDisable() {
        $this->getLogger()->info("Plugin LocalhostConnect desabilitado!");

        $this->stopLocalhostServer();
    }

    private function stopLocalhostServer() {
        if ($this->localhostServer) {
            $this->localhostServer->stopServer();
        }
    }
}
