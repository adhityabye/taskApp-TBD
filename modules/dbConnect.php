<?php
// 
[
    'dbHost' => $dbHost,
    'dbName' => $dbName,
    'dbUsername' => $dbUsername,
    'dbPassword' => $dbPassword,
] = (array) json_decode(file_get_contents(__DIR__ . '/../config.json'));

try {
    $pdo = new PDO("pgsql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}

function executePostgreSQLQuery(string $query, bool $returnResult = true)
{
    global $pdo;

    try {
        $statement = $pdo->prepare($query);
        $statement->execute();

        if ($returnResult) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return true;
        }
    } catch (PDOException $exception) {
        return $exception->getMessage();
    }
}

function postgreQueryTCL(string $multipleQueries)
{
    global $pdo;

    try {
        $pdo->beginTransaction();
        $pdo->exec($multipleQueries);
        $pdo->commit();

        return true;
    } catch (PDOException $exception) {
        $pdo->rollBack();
        echo "Error: " . $exception->getMessage();
        return false;
    }
}
?>