<?
require_once('configuration.php');

$id = $_GET['id'];

if($id > 0) {
    try {
        $pdo = new PDO(
            'mysql:dbname='.$db_conf['dbname'].';host='.$db_conf['hostname'].';charset=utf8mb4',
            $db_conf['username'],
            $db_conf['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );

        $query = 'DELETE FROM entries WHERE id=:id';
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();

    } catch (PDOException $e) {
        header('Content-Type: text/plain; charset=UTF-8', true, 500);
        exit($e->getMessage()); 
    }
}

// redirect index.php
header('Location: http://'.$_SERVER['HTTP_HOST']);
exit();
?>
