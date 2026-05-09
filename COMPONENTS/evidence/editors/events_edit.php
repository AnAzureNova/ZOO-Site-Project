<?php
    $id = $_GET["id"] ?? null;
    $isNew = ($_GET["action"] ?? "") === "new" && !$id;
    $event = $isNew ? null : ($id ? get("events_registry", $id) : null);

    $field = function($key) use ($event) {return htmlspecialchars($event[$key] ?? "");};

    $timeValue = $event["start_time"] ? htmlspecialchars(substr($event["start_time"], 0, 5)) : "";
    $dateValue = $field("date_published");
?>
<div class="editor_edit">
    <div class="editor_section_header" style="background-image: url('<?= $field("image")?>')">
        <h1><?= $isNew ? "NOVÁ AKCE" : "UPRAVIT: ".htmlspecialchars($event["title"] ?? "")?></h1>
        <a class="editor_button" href="evidence.php?page=events">← ZPĚT</a>
    </div>
    <form method="POST" action="evidence.php?page=events&action=<?= ($isNew && !$id) ? 'new' : 'edit&id='.$id ?>">
        <div class="editor_edit_group">
            <h4>ZÁKLADNÍ INFORMACE</h4>
            <div class="editor_edit_fields">
                <div class="editor_field">
                    <label>Název</label>
                    <input type="text" name="title" value="<?= $field('title')?>" required>
                </div>
                <div class="editor_field">
                    <label>Datum akce</label>
                    <input type="date" name="date_published" value="<?= $dateValue?>">
                </div>
                <div class="editor_field">
                    <label>Čas počátku</label>
                    <input type="time" name="start_time" value="<?= $timeValue?>">
                </div>
            </div>
        </div>
        <div class="editor_edit_group">
            <div class="editor_edit_fields">
                <div class="editor_field">
                    <label>Lokace akce</label>
                    <input type="text" name="location" value="<?= $field('location')?>">
                </div>
                <div class="editor_field">
                    <label>Link na redirect</label>
                    <input type="text" name="linktoredirect" value="<?= $field('linktoredirect')?>">
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
        <?php if (!$isNew): ?>
            <div class="editor_edit_danger">
                <h4>NEBEZPEČNÁ ZÓNA</h4>
                <p>Tato akce je nevratná. Akce bude trvale odstraněna z databáze.</p>
                <button class="editor_button" id="button_delete" type="submit" name="form_action" value="delete" onclick="return confirm('Opravdu chcete smazat tuto akci?')">SMAZAT AKCI</button>
            </div>
        <?php endif; ?>
    </form>
</div>