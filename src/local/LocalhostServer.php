<?php

namespace local;

use pocketmine\plugin\PluginLogger;
use pocketmine\Server;

class LocalhostServer extends \Thread {

    private $server;
    private $running = false;
    private $logger;

    public function __construct(PluginLogger $logger) {
        $this->logger = $logger;
    }

    public function run() {
        $address = "0.0.0.0"; // Endereço IP do servidor (0.0.0.0 para aceitar conexões de qualquer IP)
        $port = 80; // Porta do servidor (porta 80 é usada para HTTP)

        $this->server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_bind($this->server, $address, $port);
        socket_listen($this->server);

        $this->running = true;

        while ($this->running) {
            $client = socket_accept($this->server);
            if ($client !== false) {
                // Lidar com a lógica de comunicação com o cliente
                $this->handleClient($client);
                socket_close($client);
            }
        }
    }

    public function stopServer() {
        $this->running = false;
        if ($this->server) {
            socket_close($this->server);
        }
    }

    private function handleClient($client) {
        // Lógica para lidar com a conexão TCP do cliente
        //ler dados recebidos e enviar respostas para o cliente aqui

        // Exemplo de leitura de dados do cliente
        $data = socket_read($client, 2048);

     //  ERRO Antigo $this->logger->info("Dados recebidos: " . $data);
     var_dump("Dados recebidos: " . $data);

        
        // Exemplo de envio de resposta para o cliente
        $response = "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\n\r\n<html><body><h1>Olá, cliente!</h1></body></html>";
        socket_write($client, $response, strlen($response));
    }
}
