<?php
    $id = $_GET["id"] ?? null;
    $isNew = ($_GET["action"] ?? "") === "new" && !$id;
    $animal = $isNew ? null : ($id ? get("animals_registry", $id) : null);
    $exclosures = getALL("exclosures_registry", "name ASC");

    $field = function($key) use ($animal) {return htmlspecialchars($animal[$key] ?? "");};
?>
<div class="editor_edit">
    <div class="editor_section_header" style="background-image: url('<?= $field("image")?>')">
        <h1><?= $isNew ? "NOVÉ ZVÍŘE" : "UPRAVIT: " . htmlspecialchars($animal["name"] ?? "") ?></h1>
        <a class="editor_button" href="evidence.php?page=animals">← ZPĚT</a>
    </div>
    <form method="POST" action="evidence.php?page=animals&action=<?= ($isNew && !$id) ? 'new' : 'edit&id='.$id ?>">
        <div class="editor_edit_group">
            <h4>ZÁKLADNÍ INFORMACE</h4>
            <div class="editor_edit_fields">
                <div class="editor_field">
                    <label>Název</label>
                    <input type="text" name="name" value="<?= $field('name')?>" required>
                </div>
                <div class="editor_field">
                    <label>Latinský název</label>
                    <input type="text" name="name_latin" value="<?= $field('name_latin')?>">
                </div>
                <div class="editor_field">
                    <label>Klasifikace</label>
                    <input type="text" name="classification" value="<?= $field('classification')?>">
                </div>
            </div>
        </div>

        <div class="editor_edit_group">
            <div class="editor_edit_fields">
                <div class="editor_field">
                    <label>Váha</label>
                    <input type="text" name="weight" value="<?= $field('weight')?>">
                </div>
                <div class="editor_field">
                    <label>Výška</label>
                    <input type="text" name="height" value="<?= $field('height')?>">
                </div>
                <div class="editor_field">
                    <label>Délka života</label>
                    <input type="text" name="lifespan" value="<?= $field('lifespan')?>">
                </div>
            </div>
        </div>

        <div class="editor_edit_group">
            <div class="editor_edit_fields">
                <div class="editor_field">
                    <label>Habitat</label>
                    <input type="text" name="habitat" value="<?= $field('habitat')?>">
                </div>
                <div class="editor_field">
                    <label>Oblast původu</label>
                    <input type="text" name="location_of_origin" value="<?= $field('location_of_origin')?>">
                </div>
                <div class="editor_field">
                    <label>Index vyhynutí (0–5)</label>
                    <input type="number" min="0" max="5" name="extninction_index" value="<?= $field('extninction_index')?>">
                </div>
            </div>
        </div>
        <div class="editor_edit_group">
            <div class="editor_edit_fields">
                <div class="editor_field">
                    <label>Počet jednotlivců v ZOO</label>
                    <input type="number" min="0" name="amount" value="<?= $field('amount')?>">
                </div>
                <div class="editor_field">
                    <label>Dieta a jídlo</label>
                    <input type="text" name="diet" value="<?= $field('diet')?>">
                </div>
                <div class="editor_field">
                    <label>Obrázek (URL)</label>
                    <input type="text" name="image" value="<?= $field('image') ?>">
                </div>
            </div>
            <div class="editor_field" id="field_long">
                <label>Expozice</label>
                <select name="exclosure">
                    <option value="">Nevybráno</option>
                    <?php
                        foreach ($exclosures as $exc){
                            $selected = ($animal["exclosure"] ?? "") === $exc["name"] ? "selected" : "";
                            echo "<option value='".htmlspecialchars($exc['name'])."' {$selected}>".htmlspecialchars($exc['name'])."</option>";
                        }
                    ?>
                </select>
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

        <?php if (!$isNew): ?>
            <div class="editor_edit_danger">
                <h4>NEBEZPEČNÁ ZÓNA</h4>
                <p>Tato akce je nevratná. Zvíře bude trvale odstraněno z databáze.</p>
                <button class="editor_button" id="button_delete" type="submit" name="form_action" value="delete"
                    onclick="return confirm('Opravdu chcete smazat toto zvíře?')">SMAZAT ZVÍŘE</button>
            </div>
        <?php endif; ?>

    </form>
</div>