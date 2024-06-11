// Exemple d'enregistrement d'un message dans un fichier JSON
$message = [
    'sender' => 'utilisateur1',
    'receiver' => 'utilisateur2',
    'timestamp' => time(),
    'content' => 'Bonjour, comment ça va ?'
];

// Charger les messages existants
$messages = file_exists('messages.json') ? json_decode(file_get_contents('messages.json'), true) : [];

// Ajouter le nouveau message
$messages[] = $message;

// Enregistrer les messages dans le fichier
file_put_contents('messages.json', json_encode($messages));

