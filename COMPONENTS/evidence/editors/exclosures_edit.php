<?php
    $id = $_GET["id"] ?? null;
    $isNew = ($_GET["action"] ?? "") === "new" && !$id;
    $exclosure = $isNew ? null : ($id ? get("exclosures_registry", $id) : null);
    $animals = getALL("animals_registry", "name ASC", null, ["clause" => "exclosure = :exclosure", "params" => [":exclosure" => $exclosure["name"]]]);

    $field = function($key) use ($exclosure) {return htmlspecialchars($exclosure[$key] ?? "");};
?>
<div class="editor_edit">
    <div class="editor_section_header" style="background-image: url('<?= $field("image")?>')">
        <h1><?= $isNew ? "NOVÁ EXPOZICE" : "UPRAVIT: " . htmlspecialchars($exclosure["name"] ?? "") ?></h1>
        <a class="editor_button" href="evidence.php?page=exclosures">← ZPĚT</a>
    </div>
    <form method="POST" action="evidence.php?page=exclosures&action=<?= ($isNew && !$id) ? 'new' : 'edit&id='.$id ?>">
        <div class="editor_edit_group">
            <h4>ZÁKLADNÍ INFORMACE</h4>
            <div class="editor_edit_fields">
                <div class="editor_field">
                    <label>Název</label>
                    <input type="text" name="name" value="<?= $field('name')?>" required>
                </div>
                <div class="editor_field">
                    <label>Lokace</label>
                    <input type="text" name="location" value="<?= $field('location')?>">
                </div>
                <div class="editor_field">
                    <label>Obrázek (URL)</label>
                    <input type="text" name="image" value="<?= $field('image')?>">
                </div>
            </div>
        </div>
        <div class="editor_edit_group">
            <h4>POPIS</h4>
            <div class="editor_edit_fields editor_edit_fields--full">
                <div class="editor_field editor_field--full">
                    <label>Popis</label>
                    <textarea name="description" rows="6"><?= $field('description') ?></textarea>
                </div>
            </div>
            <button class="editor_button" type="submit" name="form_action" value="save" id="button_save">ULOŽIT</button>
        </div>
        <div class="editor_table_wrapper">
            <table class="editor_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NÁZEV</th>
                        <th>LATINSKÝ NÁZEV</th>
                        <th>KLASIFIKACE</th>
                        <th>EXPOZICE</th>
                        <th>POČET</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (empty($animals)){
                            echo "<tr><td colspan='8' class='editor_table_empty'>Žádná zvířata v databázi</td></tr>";
                        }
                        else{
                            foreach ($animals as $animal){
                                echo "<tr>
                                    <td class='editor_muted'>#".htmlspecialchars($animal['id'])."</td>
                                    <td><strong>".htmlspecialchars($animal['name'])."</strong></td>
                                    <td class='editor_italic editor_muted'>".htmlspecialchars($animal['name_latin'])."</td>
                                    <td>".htmlspecialchars($animal['classification'])."</td>
                                    <td>".htmlspecialchars($animal['exclosure'])."</td>
                                    <td>".htmlspecialchars($animal['amount'])."</td>
                                    <td><a class='editor_button' href='evidence.php?page=animals&action=edit&id=".htmlspecialchars($animal['id'])."'>UPRAVIT</a></td>
                                    </tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <?php if (!$isNew): ?>
            <div class="editor_edit_danger">
                <h4>NEBEZPEČNÁ ZÓNA</h4>
                <p>Tato akce je nevratná. Expozice bude trvale odstraněna z databáze.</p>
                <button class="editor_button" id="button_delete" type="submit" name="form_action" value="delete"
                    onclick="return confirm('Opravdu chcete smazat tuto expozici?')">SMAZAT EXPOZICI</button>
            </div>
        <?php endif; ?>

    </form>
</div>