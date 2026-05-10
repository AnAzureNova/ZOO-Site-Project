<?php
    $id = $_GET["id"] ?? null;
    $isNew = ($_GET["action"] ?? "") === "new" && !$id;
    $employee = $isNew ? null : ($id ? get("employees_registry", $id) : null);

    $field = function($key) use ($employee) {return htmlspecialchars($employee[$key] ?? "");};
?>
<div class="editor_edit">
    <div class="editor_section_header" style="background-image: url('<?= $field("image")?>')">
        <h1><?= $isNew ? "NOVÝ UŽIVATEL" : "UPRAVIT: ".htmlspecialchars($employee["web_username"] ?? "")?></h1>
        <a class="editor_button" href="evidence.php?page=employees">← ZPĚT</a>
    </div>
    <form method="POST" action="evidence.php?page=employees&action=<?= ($isNew && !$id) ? 'new' : 'edit&id='.$id ?>">
        <div class="editor_edit_group">
            <h4>ZÁKLADNÍ INFORMACE</h4>
            <div class="editor_edit_fields">
                <div class="editor_field">
                    <label>Jméno</label>
                    <input type="text" name="firstname" value="<?= $field('firstname')?>" required>
                </div>
                <div class="editor_field">
                    <label>Příjmení</label>
                    <input type="text" name="surname" value="<?= $field('surname')?>">
                </div>
                <div class="editor_field">
                    <label>Okupace</label>
                    <select name="occupation">
                        <?php
                            $occupations = ["" => "Nevybráno", "uklízeč" => "Uklízeč", "referent" => "Referent", "veterinář" => "Veterinář", "ošetřovatel" => "Ošetřovatel", "asistent" => "Asistent", "vedoucí obchodu" => "Vedoucí obchodu", "pracovník obchodu" => "Pracovník obchodu", "technik" => "Technik", "it asistent" => "IT asistent", "obsluha" => "Obsluha", "kuchař" => "Kuchař", "manažér" => "Manažér", "kurátor" => "Kurátor", "architekt" => "Architekt",  "ředitel" => "Ředitel", "system admin" => "System admin"];
                            foreach ($occupations as $value => $label){
                                $selected = ($field("occupation") === $value) ? "selected" : "";
                                echo "<option value='{$value}' {$selected}>{$label}</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="editor_edit_group">
            <div class="editor_edit_fields">
                <div class="editor_field">
                    <label>Pracovní doba</label>
                    <input type="text" name="shift" value="<?= $field('shift')?>">
                </div>
                <div class="editor_field">
                    <label>Plat (Kč)</label>
                    <input type="number" name="salary" value="<?= $field('salary')?>">
                </div>
            </div>
        </div>
        <div class="editor_edit_group">
            <h4>SYSTÉMOVÉ INFORMACE</h4>
            <div class="editor_edit_fields">
                <div class="editor_field">
                    <label>Uživatelské jméno</label>
                    <input type="text" name="web_username" value="<?= $field('web_username')?>">
                </div>
                    <div class="editor_field">
                        <label>Uživatelské heslo</label>
                        <input type="text" name="web_password" value="<?= $field('web_password')?>">
                    </div>
                <div class="editor_field">
                    <label>Systémový status</label>
                    <select name="status">
                        <?php
                            $statuses = ["blokován" => "Blokován", "limitován" => "Limitován", "editor" => "Editor", "admin" => "Admin"];
                            foreach ($statuses as $value => $label){
                                $selected = ($field("status") === $value) ? "selected" : "";
                                echo "<option value='{$value}' {$selected}>{$label}</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <button class="editor_button" type="submit" name="form_action" value="save" id="button_save">ULOŽIT</button>
        </div>
        <?php if (!$isNew && $_SESSION["evidence_user"]["status"] === "admin"): ?>
            <div class="editor_edit_danger">
                <h4>NEBEZPEČNÁ ZÓNA</h4>
                <p>Tato akce je nevratná. Uživatel bude trvale odstraněn z databáze.</p>
                <button class="editor_button" id="button_delete" type="submit" name="form_action" value="delete" onclick="return confirm('Opravdu chcete smazat uživatele?')">SMAZAT UŽIVATELE</button>
            </div>
        <?php endif; ?>
    </form>
</div>