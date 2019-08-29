<?php
require_once('configuration.php');

$url = $_POST['url'];
$body = $_POST['body'];

// connect to database
try {
    $pdo = new PDO(
        'mysql:dbname='.$db_conf['dbname'].';host='.$db_conf['hostname'].';charset=utf8mb4',
        $db_conf['username'],
        $db_conf['password'],
        [
            // Error mode: throw exception
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // Fetch mode: associative array
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );

    // query
    $query = 'INSERT INTO entries (url, body) VALUES (:url, :body)';
    $stmt = $pdo->prepare($query);
    // bind
    $stmt->bindValue(':url', $url, PDO::PARAM_STR);
    $stmt->bindValue(':body', $body, PDO::PARAM_STR);
    // execute
    $stmt->execute();

} catch (PDOException $e) {
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage()); 
}

// redirect index.php
header('Location: http://'.$_SERVER['HTTP_HOST']);
exit();
?>
