<?php


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->get('/tickets', function (Request $request, Response $response) {
    $sql = "SELECT * FROM ticket";
    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->query($sql);
        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db = null;
        $response->getBody()->write(json_encode($tickets));
        return $response
            ->withHeader('content-type', 'application/json');
    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage()
        );
        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json');
    }
});



$app->get('/comments', function (Request $request, Response $response) {
    $sql = "SELECT * FROM comment";
    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->query($sql);
        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db = null;
        $response->getBody()->write(json_encode($tickets));
        return $response
            ->withHeader('content-type', 'application/json');
    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage()
        );
        $response->getBody()->write(json_encode($tickets));
        return $response
            ->withHeader('content-type', 'application/json');
    }
});


$app->get('/ticket/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $sql = "SELECT * FROM ticket WHERE id = $id";
    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->query($sql);
        $ticket = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db = null;
        $response->getBody()->write(json_encode($ticket));
        return $response
            ->withHeader('content-type', 'application/json');
    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage()
        );
        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json');
    }
});



$app->post('/ticket/add', function (Request $request, Response $response) {


    $title = $request->getQueryParams('title');
    // $title = $args['title'];
    $description = $request->getQueryParams('description');
    $test = $request->getQueryParams('date');
    // $date = $test('Y-m-d H:i:s');
    $date = date('Y-m-d H:i:s');
    $statut = $request->getQueryParams('statut');
    $sql = "INSERT INTO ticket (title, description, date, statut) VALUE (:title, :description, :date, :statut)";
    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':statut', $statut);
        $result = $stmt->execute();
        $db = null;
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type', 'application/json');
    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage()
        );
        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json');
    }
});
