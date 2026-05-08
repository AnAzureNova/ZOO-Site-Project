<?php
    #spustí se pokaždé co je něco uloženo
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $formAction = $_POST["form_action"] ?? "";
        $page = $_GET["page"] ?? "home";
        $id = $_GET["id"] ?? null;

        # tato část se zaměřuje na úpravu zvířat (management zvířat/animals page tab)
        if ($page === "animals") {
            $isNew = ($_GET["action"] ?? "") === "new";

            if ($formAction === "delete" && !$isNew && $id) {
                $animal = get("animals_registry", $id);
                deleteAnimal($id);
                logAction("animal_deleted", $_SESSION["evidence_user"], "id: {$id}, name: " . ($animal["name"] ?? "?"));
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
                
                $detail = !empty($changed) ? "ID: {$id}, CHANGES: " . implode(", ", $changed) : "ID: {$id}, NO CHANGES";
                updateAnimal($fields);
                logAction("animal_updated", $_SESSION["evidence_user"], $detail);
                echo "<script>window.location.href='/evidence.php?page=animals&action=edit&id={$id}';</script>";
                exit();
            }
        }
    }
?>