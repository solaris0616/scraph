<?php
require_once('configuration.php');
require_once('entry.php');

$entries = array();

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

    $stmt = $pdo->query('SELECT * FROM entries');
    while ($row = $stmt->fetch()) {
        $entry = new Entry($row['id'], $row['url'], $row['title'], $row['body']);
        $entries[] = $entry;
    }

} catch (PDOException $e) {
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage()); 
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>Scraph</title>
        <meta charset="utf-8">
        <meta name="description" content="Store your favorite sites like a scrapbook.">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <!-- navigation bar -->
        <nav class="teal darken-1">
            <div class="container">
                <div class="nav-wrapper">
                    <a href="#!" class="brand-logo">Scraph</a>
                </div>
            </div>
        </nav>

        <div class="container">
            <!-- cards -->
            <div class="row">
<?php foreach($entries as $entry): ?>
                <div class="col s12">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title">
                                <a href="<?= htmlspecialchars($entry->getUrl()) ?>" target="_blank">
                                    <?= htmlspecialchars($entry->getTitle()) ?>
                                </a>
                            </span>
                            <p><?= htmlspecialchars($entry->getBody()) ?></p>
                        </div>
                        <div class="card-action">
                            <a href="./delete.php?id=<?= $entry->getId() ?>">削除</a>
                        </div>
                    </div>
                </div>
<?php endforeach ?>
            </div>

            <!-- action button -->
            <div class="fixed-action-btn">
                <a class="btn-floating btn-large modal-trigger" href="#reg-modal">
                   <i class="large material-icons">add</i>
                </a>
            </div>

            <!-- registration modal -->
            <div id="reg-modal" class="modal">
                <div class="modal-content">
                    <form id="reg-form" class="col s12" action="regist.php" method="post">
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">account_circle</i>
                                <input id="url" name="url" type="text">
                                <label for="url">URL</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">mode_edit</i>
                                <textarea class="materialize-textarea" name="body" id="body"></textarea>
                                <label for="body">Comment</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button form="reg-form" type="submit" class="btn waves-effect waves-light modal-close">
                        Submit<i class="material-icons right">send</i>
                    </button>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script src="./script.js"></script>
    </body>
</html>
