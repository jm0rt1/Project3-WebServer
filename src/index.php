<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
function connect_to_db()
{
	$dbconnection = new PDO('mysql:host=localhost;dbname=messaging_system','jm','pass123');
	return $dbconnection;
}

$app = new \Slim\App;


$app->get('/api/messages', function(Request $request, Response $response)
{
	$sql_query="SELECT * FROM messages";
	try
	{
		$datab = connect_to_db();
		$stmt = $datab->query($sql_query);
		$messages = $stmt->fetchAll(PDO::FETCH_OBJ);
		$datab=null;
		echo json_encode($messages);
	}
	catch(PDOException $e)
	{
		echo '{"error":{"text":'.$e->getMessage().'}';
	}
});
$app->delete('/api/messages/delete', function (Request $request, Response $response)
{
	$id = $request->getParam('id');
	$sql_query="DELETE FROM messages where id = '$id'";
	try
	{
		$datab=connect_to_db();
		$stmt=$datab->prepare($sql_query);
		$stmt->execute();
		$datab=null;
		echo '{"Result:{"text":"User Deleted"}';
	}
	catch (PDOException $e)
	{
		echo '{"error":{"text":'.$e->getMessage().'}';
	}
});
$app->post('/api/messages/add', function (Request $request, Response $response)
{
	$message_body = $request->getParam('message_body');
	$sender_id = $request->getParam('sender_id');
	$parent_message_id = $request->getParam('parent_message_id');

	$sql_query="INSERT INTO messages (message_body,sender_id,parent_message_id) VALUES (:message_body,:sender_id,:parent_message_id)";
	try
	{
		$datab=connect_to_db();
		$stmt=$datab->prepare($sql_query);
		$stmt->bindParam(':title',$title);
		$stmt->bindParam(':content',$content);
		$stmt->bindParam(':owner_id',$owner_id);
		$stmt->execute();
		$datab=null;
		echo '{"Result:{"text":"Post Added"}';
	}
	catch (PDOException $e)
	{
		echo '{"error":{"text":'.$e->getMessage().'}';
	}
});


$app->get('/api/message_recipients[/{id}]', function(Request $request, Response $response, $args)
{
	if(isset($args['id'])){
		$id = $args['id'];
		$sql_query="SELECT * FROM message_recipients where recipient_id= $id";
	}else{
		$sql_query="SELECT * FROM message_recipients";
	}


	try
	{
		$datab = connect_to_db();
		$stmt = $datab->query($sql_query);
		$messages = $stmt->fetchAll(PDO::FETCH_OBJ);
		$datab=null;
		echo json_encode($messages);
	}
	catch(PDOException $e)
	{
		echo '{"error":{"text":'.$e->getMessage().'}';
	}
});


$app->get('/api/users[/{name}]', function(Request $request, Response $response, $args)
{

	if(isset($args['name'])){
		
		$name = $args['name'];
		$sql_query="SELECT * FROM users where \user_name = $name";
		echo $name;

	}else{
		$sql_query="SELECT * FROM users";
		echo "no name";
	}
	try
	{
		$datab = connect_to_db();
		$stmt = $datab->query($sql_query);
		$messages = $stmt->fetchAll(PDO::FETCH_OBJ);
		$datab=null;
		echo json_encode($messages);
	}
	catch(PDOException $e)
	{
		echo '{"error":{"text":'.$e->getMessage().'}';
	}
});



$app->run();