<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ .'/../src/App/Database.php';

use GuzzleHttp\Client;
use App\Database;
use App\Repositories\PostRepository;

$client = new Client();
$database = new Database("127.0.0.1", "slimrestapi", "root", "");
$repository = new PostRepository($database);

$response = $client->request('GET', 'https://jsonplaceholder.typicode.com/posts');
$json = $response->getBody()->getContents();
$data = json_decode($json, true);

foreach ($data as $item) {
    $id = $repository->create($item);
}

echo "Veriler başarıyla eklendi.\n";
