<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ .'/../src/App/Database.php';

use GuzzleHttp\Client;
use App\Database;
use App\Repositories\UserRepository;
use App\Repositories\AddressRepository;
use App\Repositories\GeoRepository;
use App\Repositories\CompanyRepository;

$client = new Client();
$database = new Database("127.0.0.1", "slimrestapi", "root", "");
$userRepository = new UserRepository($database);
$addressRepository = new AddressRepository($database);
$geoRepository = new GeoRepository($database);
$companyRepository = new CompanyRepository($database);

$response = $client->request('GET', 'https://jsonplaceholder.typicode.com/users');
$json = $response->getBody()->getContents();
$data = json_decode($json, true);

foreach ($data as $item) {
    $userId = $userRepository->create($item);

    $addressId = $addressRepository->create($item['address'], $userId);

    $geoRepository->create($item['address']['geo'], $addressId);

    $companyRepository->create($item['company'], $userId);
}

echo "Veriler başarıyla eklendi.\n";
