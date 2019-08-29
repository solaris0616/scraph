<?php
require_once('configuration.php');
require_once('entry.php');

$entries = array();

// connect to database
// https://qiita.com/mpyw/items/b00b72c5c95aac573b71
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

    $stmt = $pdo->query('SELECT * FROM entries');
    while ($row = $stmt->fetch()) {
        $entry = new Entry($row['id'], $row['url'], $row['body']);
        $entries[] = $entry;
    }

} catch (PDOException $e) {
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage()); 
}
?>

<html>
    <head>
        <title>scraph</title>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>scraph</h1>
        <form action="register.php" method="post">
            <p>URL:</p>
            <input type="text" name="url">
            <p>Comment:</p>
            <textarea type="text" name="body"></textarea>
            <input type="submit" value="Regist">
        </form>
        <h1>Entries</h1>
<?php foreach($entries as $entry): ?>
        <h4><?= $entry->getUrl() ?></h4>
        <p><?= $entry->getBody() ?></p>
        <a href="./delete.php?id=<?= $entry->getId() ?>">削除</a>
<?php endforeach ?>
    </body>
</html>
