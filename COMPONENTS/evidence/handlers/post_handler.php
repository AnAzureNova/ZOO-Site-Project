<?php
    #spustí se pokaždé co je něco uloženo
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $formAction = $_POST["form_action"] ?? "";
        $page = $_GET["page"] ?? "home";
        $id = $_GET["id"] ?? null;

        #--------------------------------------------------------------------------------------
        # tato část se zaměřuje na úpravu zvířat (management zvířat/animals page tab)
        if ($page === "animals") {
            $isNew = ($_GET["action"] ?? "") === "new";

            if ($formAction === "delete" && !$isNew && $id) {
                $animal = get("animals_registry", $id);
                deleteAnimal($id);
                logAction("animal_deleted", $_SESSION["evidence_user"], "ID: {$id}, name: " . ($animal["name"] ?? "?"));
                header("Location: /evidence.php?page=animals");
                exit();
            }

            $fields = [
                "name" => trim($_POST["name"] ?? ""),
                "name_latin" => trim($_POST["name_latin"] ?? ""),
                "classification" => trim($_POST["classification"] ?? ""),
                "habitat" => trim($_POST["habitat"] ?? ""),
                "diet" => trim($_POST["diet"] ?? ""),
                "location_of_origin" => trim($_POST["location_of_origin"] ?? ""),
                "lifespan" => trim($_POST["lifespan"] ?? ""),
                "weight" => trim($_POST["weight"] ?? ""),
                "height" => trim($_POST["height"] ?? ""),
                "description" => trim($_POST["description"] ?? ""),
                "extninction_index" => is_numeric($_POST["extninction_index"] ?? "") ? intval($_POST["extninction_index"]) : 0,
                "amount" => is_numeric($_POST["amount"] ?? "") ? intval($_POST["amount"]) : 0,
                "exclosure" => trim($_POST["exclosure"] ?? "") ?: null,
                "image" => trim($_POST["image"] ?? ""),
            ];

            if ($isNew) {
                $newId = insertAnimal($fields);
                logAction("animal_created", $_SESSION["evidence_user"], "ID: {$newId}, NAME: " . $fields["name"]);
                echo "<script>window.location.href='/evidence.php?page=animals&action=edit&id={$newId}';</script>";
                exit();
            }
            else{
                $fields["id"] = $id;
                
                $old = get("animals_registry", $id);
                $changed = [];
                $trackFields = ["name", "name_latin", "classification", "habitat", "location_of_origin", "lifespan", "weight", "height", "description", "extninction_index", "amount", "exclosure", "image", "diet"];
                
                foreach ($trackFields as $field) {
                    $oldVal = (string)($old[$field] ?? "");
                    $newVal = (string)($fields[$field] ?? "");
                    if ($oldVal !== $newVal) {
                        $changed[] = "{$field}: '{$oldVal}' → '{$newVal}'";
                    }
                }
                
                $detail = !empty($changed) ? "ID: {$id}, CHANGES: ".implode(", ", $changed) : "ID: {$id}, NO CHANGES";
                updateAnimal($fields);
                logAction("animal_updated", $_SESSION["evidence_user"], $detail);
                echo "<script>window.location.href='/evidence.php?page=animals&action=edit&id={$id}';</script>";
                exit();
            }
        }

        #--------------------------------------------------------------------------------------
        # tato část se zaměřuje na úpravu expozic (management expozic/exclosures page tab)
        if ($page === "exclosures") {
            $isNew = ($_GET["action"] ?? "") === "new";

            if ($formAction === "delete" && !$isNew && $id) {
                $exclosure = get("exclosures_registry", $id);
                deleteExclosure($id);
                logAction("exclosure_deleted", $_SESSION["evidence_user"], "ID: {$id}, name: ".($exclosure["name"] ?? "?"));
                header("Location: /evidence.php?page=exclosures");
                exit();
            }

            $fields = [
                "name" => trim($_POST["name"] ?? ""),
                "location" => trim($_POST["location"] ?? ""),
                "description" => trim($_POST["description"] ?? ""),
                "image" => trim($_POST["image"] ?? ""),
            ];

            if ($isNew) {
                $newId = insertExclosure($fields);
                logAction("exclosure_created", $_SESSION["evidence_user"], "ID: {$newId}, NAME: ".$fields["name"]);
                echo "<script>window.location.href='/evidence.php?page=exclosures&action=edit&id={$newId}';</script>";
                exit();
            }
            else{
                $fields["id"] = $id;
                
                $old = get("exclosures_registry", $id);
                $changed = [];
                $trackFields = ["name", "location", "description", "image"];
                
                foreach ($trackFields as $field) {
                    $oldVal = (string)($old[$field] ?? "");
                    $newVal = (string)($fields[$field] ?? "");
                    if ($oldVal !== $newVal) {
                        $changed[] = "{$field}: '{$oldVal}' → '{$newVal}'";
                    }
                }
                
                $detail = !empty($changed) ? "ID: {$id}, CHANGES: ".implode(", ", $changed) : "ID: {$id}, NO CHANGES";
                updateExclosure($fields);
                logAction("exclosure_updated", $_SESSION["evidence_user"], $detail);
                echo "<script>window.location.href='/evidence.php?page=exclosures&action=edit&id={$id}';</script>";
                exit();
            }
        }

        #--------------------------------------------------------------------------------------
        # tato část se zaměřuje na úpravu akcí a programu (management akcí/events page tab)
        if ($page === "events") {
            $isNew = ($_GET["action"] ?? "") === "new";

            if ($formAction === "delete" && !$isNew && $id) {
                $event = get("events_registry", $id);
                deleteEvent($id);
                logAction("events_deleted", $_SESSION["evidence_user"], "ID: {$id}, name: ".($event["title"] ?? "?"));
                header("Location: /evidence.php?page=events");
                exit();
            }

            $rawDate = trim($_POST["date_published"] ?? "");
            $parsedDate = DateTime::createFromFormat("Y-m-d", $rawDate);
            $dateValue = ($parsedDate && $parsedDate->format("Y-m-d") === $rawDate) ? $rawDate : null;

            $rawTime = trim($_POST["start_time"] ?? "");
            $parsedTime = DateTime::createFromFormat("H:i", $rawTime);
            $timeValue = $parsedTime ? $parsedTime->format("H:i:s") : null;

            $fields = [
                "title" => trim($_POST["title"] ?? ""),
                "location" => trim($_POST["location"] ?? ""),
                "description" => trim($_POST["description"] ?? ""),
                "linktoredirect" => trim($_POST["linktoredirect"] ?? ""),
                "date_published" => $dateValue,
                "start_time" => $timeValue,
                "image" => trim($_POST["image"] ?? ""),
            ];

            if ($isNew) {
                $newId = insertEvent($fields);
                logAction("event_created", $_SESSION["evidence_user"], "ID: {$newId}, NAME: ".$fields["title"]);
                echo "<script>window.location.href='/evidence.php?page=events&action=edit&id={$newId}';</script>";
                exit();
            }
            else{
                $fields["id"] = $id;
                
                $old = get("events_registry", $id);
                $changed = [];
                $trackFields = ["title", "location", "description", "linktoredirect", "date_published", "start_time", "image"];
                
                foreach ($trackFields as $field) {
                    $oldVal = (string)($old[$field] ?? "");
                    $newVal = (string)($fields[$field] ?? "");
                    if ($oldVal !== $newVal) {
                        $changed[] = "{$field}: '{$oldVal}' → '{$newVal}'";
                    }
                }
                
                $detail = !empty($changed) ? "ID: {$id}, CHANGES: ".implode(", ", $changed) : "ID: {$id}, NO CHANGES";
                updateEvent($fields);
                logAction("event_updated", $_SESSION["evidence_user"], $detail);
                echo "<script>window.location.href='/evidence.php?page=events&action=edit&id={$id}';</script>";
                exit();
            }
        }

        #--------------------------------------------------------------------------------------
        # tato část se zaměřuje na úpravu uživatelů (management uživatelů/employees page tab)
        if ($page === "employees") {
            $isNew = ($_GET["action"] ?? "") === "new";

            if ($formAction === "delete" && !$isNew && $id) {
                $employee = get("employees_registry", $id);
                deleteEmployee($id);
                logAction("employee_deleted", $_SESSION["evidence_user"], "ID: {$id}, name: " . ($employee["web_username"] ?? "?"));
                header("Location: /evidence.php?page=employees");
                exit();
            }

            $fields = [
                "firstname" => trim($_POST["firstname"] ?? ""),
                "surname" => trim($_POST["surname"] ?? ""),
                "occupation" => trim($_POST["occupation"] ?? ""),
                "salary" => is_numeric($_POST["salary"] ?? "") ? floatval($_POST["salary"]) : 0,
                "status" => trim($_POST["status"] ?? ""),
                "web_username" => trim($_POST["web_username"] ?? ""),
                "web_password" => trim($_POST["web_password"] ?? ""),
                "shift" => trim($_POST["shift"] ?? ""),
            ];

            if ($isNew) {
                $newId = insertEmployee($fields);
                logAction("employee_created", $_SESSION["evidence_user"], "ID: {$newId}, NAME: " . $fields["web_username"]);
                echo "<script>window.location.href='/evidence.php?page=employees&action=edit&id={$newId}';</script>";
                exit();
            }
            else{
                $fields["id"] = $id;
                
                $old = get("employees_registry", $id);
                $changed = [];
                $trackFields = ["firstname", "surname", "occupation", "salary", "status", "web_username", "web_password", "shift"];
                
                foreach ($trackFields as $field) {
                    $oldVal = (string)($old[$field] ?? "");
                    $newVal = (string)($fields[$field] ?? "");
                    if ($oldVal !== $newVal) {
                        $changed[] = "{$field}: '{$oldVal}' → '{$newVal}'";
                    }
                }
                
                $detail = !empty($changed) ? "ID: {$id}, CHANGES: ".implode(", ", $changed) : "ID: {$id}, NO CHANGES";
                updateEmployee($fields);
                logAction("employee_updated", $_SESSION["evidence_user"], $detail);
                echo "<script>window.location.href='/evidence.php?page=employees&action=edit&id={$id}';</script>";
                exit();
            }
        }
    }
?>