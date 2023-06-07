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

function postgreQuery($queryString, $hasReturnValue=true) {
    global $pdo;
    try {
        $stmt = $pdo->prepare($queryString);
        $stmt->execute();
        return $hasReturnValue ? $stmt->fetchAll(PDO::FETCH_ASSOC) : true;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

function postgreQueryTCL($multipleQueryString) {
    global $pdo;
    try { 
        $pdo->beginTransaction();     
        $pdo->exec($multipleQueryString);   
        $pdo->commit();                     
        
        return true;
    } catch (PDOException $e) {
        $pdo->rollBack(); 
        echo "Error: " . $e->getMessage();
        return false;
    }
}

?>