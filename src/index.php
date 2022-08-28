<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
function connect_to_db()
{
	$dbconnection = new PDO('mysql:host=localhost;dbname=social_media','jm','pass123');
	return $dbconnection;
}

$app = new \Slim\App;
// comment 3


$app->get('/api/posts', function(Request $request, Response $response)
{
	$sql_query="SELECT * FROM posts";
	try
	{
		$datab = connect_to_db();
		$stmt = $datab->query($sql_query);
		$posts = $stmt->fetchAll(PDO::FETCH_OBJ);
		$datab=null;
		echo json_encode($posts);
	}
	catch(PDOException $e)
	{
		echo '{"error":{"text":'.$e->getMessage().'}';
	}
});
$app->delete('/api/posts/delete', function (Request $request, Response $response)
{
	$id = $request->getParam('id');
	$sql_query="DELETE FROM posts where id = '$id'";
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
$app->post('/api/posts/add', function (Request $request, Response $response)
{
	$title = $request->getParam('title');
	$content = $request->getParam('content');
	$owner_id = $request->getParam('owner_id');

	$sql_query="INSERT INTO posts (owner_id,title,content) VALUES (:owner_id,:title,:content)";
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

$app->run();