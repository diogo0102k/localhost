<?php

namespace local;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

class Localhost extends PluginBase implements Listener {

    private $server;
    private $running = false;

    public function onEnable() {
        $this->getLogger()->info("Plugin LocalhostConnect habilitado!");

        // Iniciar o servidor TCP
        $this->startTCPServer();
    }

    public function onDisable() {
        $this->getLogger()->info("Plugin LocalhostConnect desabilitado!");

        // Parar o servidor TCP
        $this->stopTCPServer();
    }

    private function startTCPServer() {
        $address = "0.0.0.0"; // Endereço IP do servidor (0.0.0.0 para aceitar conexões de qualquer IP)
        $port = 80; // Porta do servidor (porta 80 é usada para HTTP)

        $this->server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_bind($this->server, $address, $port);
        socket_listen($this->server);

        $this->running = true;
        while ($this->running) {
            $client = socket_accept($this->server);
            if ($client !== false) {
                $this->handleClient($client);
                socket_close($client);
            }
        }
    }

    private function stopTCPServer() {
        $this->running = false;
        if ($this->server) {
            socket_close($this->server);
        }
    }

    private function handleClient($client) {
        // Lógica para lidar com a conexão TCP do cliente
       

        // Exemplo de leitura de dados do cliente
        $data = socket_read($client, 2048);
        $this->getLogger()->info("Dados recebidos: " . $data);

        // Exemplo de envio de resposta para o cliente
        $response = "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\n\r\n<html><body><h1>Olá, cliente!</h1></body></html>";
        socket_write($client, $response, strlen($response));
    }

}
