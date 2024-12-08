<?php
require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../utils/Bdd.php'; 
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\App;


// Vu que c'est la premiere fois j'ai regardé des videos poiur comprendre le processus des sockets notamment en PHP j'ai fais un lien avec les API TS et une certaines ressemblances des requetes http et j ai utiliser du code d'internet et de GPT pour cette premiere fois et pour me permettre de le refaire sur un autre projet Symfony par exemple !
class ChatServer implements MessageComponentInterface
{
    private $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        echo "Nouvelle co ";
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        // Pour decoder le json (la fonction) et ainsi permettre d'afficher le contenu du message de l'user
        $data = json_decode($msg, true);

        // Vérification de la validité des données reçues
        if (!isset($data['sender_id'], $data['receiver_id'], $data['message'])) {
            echo "Données de message invalides.\n";
            return;
        }

        try {
            $my_bdd = Bdd::my_bdd();

            $sql_insert_mess = "INSERT INTO `message` (sender_id, receiver_id, contenu, date_time) VALUES (?, ?, ?, NOW())";
            $req_mess = $my_bdd->prepare($sql_insert_mess);
            $req_mess->execute([$data['sender_id'], $data['receiver_id'], $data['message']]);

            date_default_timezone_set('Europe/Paris');
            // GPT
            foreach ($this->clients as $client) {
                // Envoi du message sous forme de JSON
                $client->send(json_encode([
                    'sender_id' => $data['sender_id'],
                    'receiver_id' => $data['receiver_id'],
                    'message' => $data['message'],
                    'time' => date('H:i')
                ]));
            }

        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion du message : " . $e->getMessage() . "\n";
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Co fermée";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Erreur : {$e->getMessage()}\n";
        $conn->close();
    }
}

// Lancer le serveur WebSocket
echo "Démarrage du serveur WebSocket...\n";
$server = new App('127.0.0.1', 8080); 
$server->route('/{path}', new ChatServer, ['*']); // accepte toutes les connexions à n'importe quelle route
$server->run();

?>
