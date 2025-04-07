<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

Class CertificazioniController {
    
    public function index(Request $request, Response $response, $args){
        $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
        $result = $mysqli_connection->query("SELECT * FROM certificazioni");
        $results = $result->fetch_all(MYSQLI_ASSOC);
    
        $response->getBody()->write(json_encode($results));
        return $response->withHeader("Content-type", "application/json")->withStatus(200);
      }

    
      public function show(Request $request, Response $response, $args)
      {
        $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
        $mioId = $args["id_cert"];
        $result = $mysqli_connection->query("SELECT * FROM certificazioni WHERE id=" . $mioId);
        $results = $result->fetch_all(MYSQLI_ASSOC);
    
        $response->getBody()->write(json_encode($results));
        return $response->withHeader("Content-type", "application/json")->withStatus(200);
      }

      public function create(Request $request, Response $response, $args)
  {
    $body=json_decode($request->getBody()->getContents(), true);
    $titolo=$body["titolo"];
    $voto=$body["votazione"];
    $ente = $body["ente"];

    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("INSERT INTO certificazioni (titolo, votazione, ente) VALUES ('$titolo', '$voto', '$ente')");
    
    if($mysqli_connection->affected_rows>0)
    {
      $results=["msg"=>"ok"];
      $response->getBody()->write(json_encode($results));
      return $response->withHeader("Content-type", "application/json")->withStatus(201);
    }
    $results=["msg"=>"ko"];
    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(400);
    
  }


}