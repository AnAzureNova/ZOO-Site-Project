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
    function getALL($table, $orderBy = null, $limit = null): array{
        global $db;
        $sql = "SELECT * FROM $table";
        if ($orderBy){
            $sql.=" ORDER BY $orderBy";
        }
        if ($limit){
            $sql.=" LIMIT $limit";
        }
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
    function loginEmployee($username, $password): mixed {
        global $db;
        $sql = "SELECT * FROM employees_registry WHERE web_username = :username AND web_password = :password";
        $stmt = $db->prepare($sql);
        $stmt->execute(['username' => $username, 'password' => $password]);
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);

        return $employee ?: false;
    }
    function insertAnimal($fields): int {
        global $db;
        $stmt = $db->prepare("INSERT INTO animals_registry (create_time, name, name_latin, classification, habitat, location_of_origin, lifespan, weight, height, description, extninction_index, amount, exclosure, image, diet) VALUES (NOW(), :name, :name_latin, :classification, :habitat, :location_of_origin, :lifespan, :weight, :height, :description, :extninction_index, :amount, :exclosure, :image, :diet)");
        
        $stmt->bindValue(":name", $fields["name"], PDO::PARAM_STR);
        $stmt->bindValue(":name_latin", $fields["name_latin"], PDO::PARAM_STR);
        $stmt->bindValue(":classification", $fields["classification"], PDO::PARAM_STR);
        $stmt->bindValue(":habitat", $fields["habitat"], PDO::PARAM_STR);
        $stmt->bindValue(":location_of_origin", $fields["location_of_origin"], PDO::PARAM_STR);
        $stmt->bindValue(":lifespan", $fields["lifespan"], PDO::PARAM_STR);
        $stmt->bindValue(":weight", $fields["weight"], PDO::PARAM_STR);
        $stmt->bindValue(":height", $fields["height"], PDO::PARAM_STR);
        $stmt->bindValue(":description", $fields["description"], PDO::PARAM_STR);
        $stmt->bindValue(":extninction_index", $fields["extninction_index"], PDO::PARAM_INT);
        $stmt->bindValue(":amount", $fields["amount"], PDO::PARAM_INT);
        $stmt->bindValue(":exclosure", $fields["exclosure"], $fields["exclosure"] === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(":image", $fields["image"], PDO::PARAM_STR);
        $stmt->bindValue(":diet", $fields["diet"], PDO::PARAM_STR);
        
        $stmt->execute();
        return (int)$db->lastInsertId();
    }
    function updateAnimal($fields):void{
        global $db;
        $stmt = $db->prepare("UPDATE animals_registry SET name=:name, name_latin=:name_latin, classification=:classification, habitat=:habitat, location_of_origin=:location_of_origin, lifespan=:lifespan, weight=:weight, height=:height, description=:description, extninction_index=:extninction_index, amount=:amount, exclosure=:exclosure, image=:image, diet=:diet WHERE id=:id");

        $stmt->bindValue(":name", $fields["name"], PDO::PARAM_STR);
        $stmt->bindValue(":name_latin", $fields["name_latin"], PDO::PARAM_STR);
        $stmt->bindValue(":classification", $fields["classification"], PDO::PARAM_STR);
        $stmt->bindValue(":habitat", $fields["habitat"], PDO::PARAM_STR);
        $stmt->bindValue(":location_of_origin", $fields["location_of_origin"], PDO::PARAM_STR);
        $stmt->bindValue(":lifespan", $fields["lifespan"], PDO::PARAM_STR);
        $stmt->bindValue(":weight", $fields["weight"], PDO::PARAM_STR);
        $stmt->bindValue(":height", $fields["height"], PDO::PARAM_STR);
        $stmt->bindValue(":description", $fields["description"], PDO::PARAM_STR);
        $stmt->bindValue(":extninction_index", $fields["extninction_index"], PDO::PARAM_INT);
        $stmt->bindValue(":amount", $fields["amount"], PDO::PARAM_INT);
        $stmt->bindValue(":exclosure", $fields["exclosure"], $fields["exclosure"] === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(":image", $fields["image"], PDO::PARAM_STR);
        $stmt->bindValue(":diet", $fields["diet"], PDO::PARAM_STR);
        $stmt->bindValue(":id", $fields["id"], PDO::PARAM_INT);

        $stmt->execute();
    }

    function deleteAnimal($id): void {
        global $db;
        $stmt = $db->prepare("DELETE FROM animals_registry WHERE id = :id");
        $stmt->execute(["id" => $id]);
    }
?>