<?
require 'vendor/autoload.php';
$db = new PDO('sqlite:bbs.db');
$db->exec('CREATE TABLE IF NOT EXISTS bbs(id INTEGER PRIMARY KEY, contents TEXT)');
$app = new \Slim\Slim();
$app->response->headers->set('Content-Type', 'application/json');

$app->get("/items/", function() use ($app, $db){
	echo json_encode($db->query('SELECT id, contents FROM bbs ORDER by ID DESC')->fetchAll(PDO::FETCH_ASSOC));
});

$app->post("/items/", function() use ($app, $db){
	$text = $app->request->post('text');
	$db->prepare('INSERT INTO bbs(contents) VALUES(?)')->execute([$text]);
	$result["status"] = "success";
	$result["text"] = $text;
	echo json_encode($result);
});
$app->run();
