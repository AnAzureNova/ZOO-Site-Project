<?php
    $dsn = "mysql:host=127.0.0.1;dbname=zoodatabase;charset=utf8mb4";
    $username = "zoomanagement";
    $password = "4q=2L*7(/^tGcxC?";

    try {
        $db = new PDO($dsn, $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        #echo "<h1>Success</h1><br><br><br>";
    }
    catch (PDOException $e){
        echo "Unable to connect DB: ". $e->getMessage();
        exit();
    }

    function get($table, $id): mixed{
        global $db;
        $sql = "SELECT * FROM $table WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute(['id'=>$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    function getALL($table): array{
        global $db;
        $sql = "SELECT * FROM $table";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }

    function getCurrMotd():mixed{
        global $db;
        $sql = "SELECT * FROM motd WHERE iscurrent = 1";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
?>