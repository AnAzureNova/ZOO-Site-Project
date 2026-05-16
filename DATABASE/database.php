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
    function getALL($table, $orderBy = null, $limit = null, $where = null): array {
        global $db;
        $sql = "SELECT * FROM $table";
        if ($where) {
            $sql .= " WHERE " . $where["clause"];
        }
        if ($orderBy) {
            $sql .= " ORDER BY $orderBy";
        }
        if ($limit) {
            $sql .= " LIMIT $limit";
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($where["params"] ?? []);
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





    function insertExclosure($fields): int {
        global $db;
        $stmt = $db->prepare("INSERT INTO exclosures_registry (create_time, name, location, description, image) VALUES (NOW(), :name, :location, :description, :image)");
        
        $stmt->bindValue(":name", $fields["name"], PDO::PARAM_STR);
        $stmt->bindValue(":location", $fields["location"], PDO::PARAM_STR);
        $stmt->bindValue(":description", $fields["description"], PDO::PARAM_STR);
        $stmt->bindValue(":image", $fields["image"], PDO::PARAM_STR);
        
        $stmt->execute();
        return (int)$db->lastInsertId();
    }
    function updateExclosure($fields):void{
        global $db;
        $stmt = $db->prepare("UPDATE exclosures_registry SET name=:name, location=:location, description=:description, image=:image WHERE id=:id");

        $stmt->bindValue(":name", $fields["name"], PDO::PARAM_STR);
        $stmt->bindValue(":location", $fields["location"], PDO::PARAM_STR);
        $stmt->bindValue(":description", $fields["description"], PDO::PARAM_STR);
        $stmt->bindValue(":image", $fields["image"], PDO::PARAM_STR);
        $stmt->bindValue(":id", $fields["id"], PDO::PARAM_INT);

        $stmt->execute();
    }
    function deleteExclosure($id): void {
        global $db;
        $stmt = $db->prepare("DELETE FROM exclosures_registry WHERE id = :id");
        $stmt->execute(["id" => $id]);
    }






    function insertEvent($fields): int {
        global $db;
        $stmt = $db->prepare("INSERT INTO events_registry (date_published, start_time, title, location, description, linktoredirect, image) VALUES (:date_published, :start_time, :title, :location, :description, :linktoredirect, :image)");
        
        $stmt->bindValue(":date_published", $fields["date_published"], $fields["date_published"] === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(":start_time", $fields["start_time"], $fields["start_time"] === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(":title", $fields["title"], PDO::PARAM_STR);
        $stmt->bindValue(":location", $fields["location"], PDO::PARAM_STR);
        $stmt->bindValue(":description", $fields["description"], PDO::PARAM_STR);
        $stmt->bindValue(":linktoredirect", $fields["linktoredirect"], PDO::PARAM_STR);
        $stmt->bindValue(":image", $fields["image"], PDO::PARAM_STR);
        
        $stmt->execute();
        return (int)$db->lastInsertId();
    }
    function updateEvent($fields): void {
        global $db;
        $stmt = $db->prepare("UPDATE events_registry SET date_published=:date_published, start_time=:start_time, title=:title, location=:location, description=:description, linktoredirect=:linktoredirect, image=:image WHERE id=:id");

        $stmt->bindValue(":date_published", $fields["date_published"], $fields["date_published"] === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(":start_time", $fields["start_time"], $fields["start_time"] === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(":title", $fields["title"], PDO::PARAM_STR);
        $stmt->bindValue(":location", $fields["location"], PDO::PARAM_STR);
        $stmt->bindValue(":description", $fields["description"], PDO::PARAM_STR);
        $stmt->bindValue(":linktoredirect", $fields["linktoredirect"], PDO::PARAM_STR);
        $stmt->bindValue(":image", $fields["image"], PDO::PARAM_STR);
        $stmt->bindValue(":id", $fields["id"], PDO::PARAM_INT);

        $stmt->execute();
    }
    function deleteEvent($id): void {
        global $db;
        $stmt = $db->prepare("DELETE FROM events_registry WHERE id = :id");
        $stmt->execute(["id" => $id]);
    }






    function insertEmployee($fields): int {
        global $db;
        $stmt = $db->prepare("INSERT INTO employees_registry (create_time, firstname, surname, occupation, salary, status, web_username, web_password, shift) VALUES (NOW(), :firstname, :surname, :occupation, :salary, :status, :web_username, :web_password, :shift)");

        $stmt->bindValue(":firstname", $fields["firstname"], PDO::PARAM_STR);
        $stmt->bindValue(":surname", $fields["surname"], PDO::PARAM_STR);
        $stmt->bindValue(":occupation", $fields["occupation"], PDO::PARAM_STR);
        $stmt->bindValue(":salary", $fields["salary"], PDO::PARAM_STR);
        $stmt->bindValue(":status", $fields["status"], PDO::PARAM_STR);
        $stmt->bindValue(":web_username", $fields["web_username"], PDO::PARAM_STR);
        $stmt->bindValue(":web_password", $fields["web_password"], PDO::PARAM_STR);
        $stmt->bindValue(":shift", $fields["shift"], PDO::PARAM_STR);

        $stmt->execute();
        return (int)$db->lastInsertId();
    }

    function updateEmployee($fields): void {
        global $db;
        $stmt = $db->prepare("UPDATE employees_registry SET firstname=:firstname, surname=:surname, occupation=:occupation, salary=:salary, status=:status, web_username=:web_username, web_password=:web_password, shift=:shift WHERE id=:id");
        
        $stmt->bindValue(":firstname", $fields["firstname"], PDO::PARAM_STR);
        $stmt->bindValue(":surname", $fields["surname"], PDO::PARAM_STR);
        $stmt->bindValue(":occupation", $fields["occupation"], PDO::PARAM_STR);
        $stmt->bindValue(":salary", $fields["salary"], PDO::PARAM_STR);
        $stmt->bindValue(":status", $fields["status"], PDO::PARAM_STR);
        $stmt->bindValue(":web_username", $fields["web_username"], PDO::PARAM_STR);
        $stmt->bindValue(":web_password", $fields["web_password"], PDO::PARAM_STR);
        $stmt->bindValue(":shift", $fields["shift"], PDO::PARAM_STR);
        $stmt->bindValue(":id", $fields["id"], PDO::PARAM_INT);
        $stmt->execute();
    }

    function deleteEmployee($id): void {
        global $db;
        $stmt = $db->prepare("DELETE FROM employees_registry WHERE id = :id");
        $stmt->execute(["id" => $id]);
    }
    function trackActivity($user): void {
        global $db;
        $stmt = $db->prepare("UPDATE employees_registry SET web_activity = NOW() WHERE id = :id");
        $stmt->execute(["id" => $user["id"]]);
    }






    function updateOpeningTime($id, $from, $to): void {
        global $db;
        $stmt = $db->prepare("UPDATE opening_time SET `from`=:from, `to`=:to WHERE id=:id");
        $stmt->bindValue(":from", $from, $from === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(":to", $to, $to === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }
 
    function getZooManagementByName($name): mixed {
        global $db;
        $stmt = $db->prepare("SELECT * FROM zoo_management WHERE name = :name");
        $stmt->execute(["name" => $name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    function updateZooManagement($name, $parameter_1, $parameter_2): void {
        global $db;
        $stmt = $db->prepare("UPDATE zoo_management SET parameter_1=:parameter_1, parameter_2=:parameter_2 WHERE name=:name");
        $stmt->bindValue(":parameter_1", $parameter_1, PDO::PARAM_STR);
        $stmt->bindValue(":parameter_2", $parameter_2, PDO::PARAM_STR);
        $stmt->bindValue(":name", $name, PDO::PARAM_STR);
        $stmt->execute();
    }
?>