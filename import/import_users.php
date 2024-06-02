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
    $item['password'] = '98765';
    $item['role'] = 'role_user';
    $userId = $userRepository->create($item);
    $addressId = $addressRepository->create($item['address'], $userId);
    $geoRepository->create($item['address']['geo'], $addressId);
    $companyRepository->create($item['company'], $userId);
}

$adminUser = [
    'id'=> '11',
    'name' => 'admin',
    'email'=> 'admin@admin.com',
    'username' => 'admin',
    'password'=> 'admin12345',
    'address'=> [
        'street'=> 'Kulas Light',
        'suite'=> 'Apt. 556',
        'city'=> 'Gwenborough',
        'zipcode'=> '92998',
        'geo'=> [
            'lat'=> '37.123',
            'lng'=> '56,234'
        ],
    ],
    'phone'=> '1-770-736-8031 x56442',
    'website'=> 'wwww.test.com',
    'company'=> [
        'name'=> 'Romaguera',
        'catchPhrase'=> 'Multi',
        'bs' => 'harness '
    ],
    'role'=> 'role_admin'
];

$userRepository->create($adminUser);

echo "Veriler başarıyla eklendi.\n";
