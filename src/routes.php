<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;

$container = $app->getContainer();
$container['upload_directory'] = '../../../public_html/cdn/backpackerid/profile_pic/';

// Routes
$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->post("/data/store/", function (Request $request, Response $response){
    $data = $request->getParsedBody();
    $kode = $data["kode"];
    $nama = $data["nama"];
    $jenis = $data["jenis"];
    $signature_path = $data["signature_path"];
    $foto_path = $data["foto_path"];

    $query = "INSERT INTO barang (kode, nama, jenis, signature_path, foto_path) VALUES ".
           "(:kode, :nama, :jenis, :sign, :foto)";
    $exec = $this->db->prepare($query);
    $data_param = [
        ":kode" => $kode,
        ":nama" => $nama,
        ":jenis" => $jenis,
        ":sign" => $signature_path,
        ":foto" => $foto_path
    ];  

    if($exec->execute($data_param)) {
        return $response->withJson(["status" => 200, "error" => false], 200);
    } else {
        return $response->withJson(["status" => 200, "error" => true], 200);
    }
});
