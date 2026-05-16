<?php
    $id = $_GET["id"] ?? null;
    $openingtime = getALL("opening_time", "id ASC");
    $info = getALL("zoo_management", "id ASC");
 
    $infoByName = [];
    foreach ($info as $row) {
        $infoByName[$row["name"]] = $row;
    }
    $timeVal = function($val){
        return htmlspecialchars($val ? substr($val, 0, 5) : "");
    };
    $infoField = function($name, $param) use ($infoByName){
        return htmlspecialchars($infoByName[$name][$param] ?? "");
    };
?>
<div class="editor_edit">
    <div class="editor_section_header">
        <div><img id="header_icon" src="STYLE/resources/icons/wrench.png"><h1>DOBA PROVOZU A KONTAKTY</h1></div>
        <button class="editor_button" type="submit" form="form_management" name="form_action" value="save_management">ULOŽIT</button>
    </div>
    <form id="form_management" method="POST" action="evidence.php?page=management">
        <div class="editor_edit_group">
            <h4>ADRESA</h4>
            <div class="editor_edit_fields">
                <div class="editor_field">
                    <label>Adresa jméno</label>
                    <input type="text" name="rows[address][parameter_1]" value="<?=$infoField('address', 'parameter_1')?>" required>
                </div>
                <div class="editor_field">
                    <label>Adresa poloha</label>
                    <input type="text" name="rows[address][parameter_2]" value="<?=$infoField('address', 'parameter_2')?>">
                </div>
                <div class="editor_field">
                    <label>IČO</label>
                    <input type="number" name="rows[identification_num][parameter_1]" value="<?=$infoField('identification_num', 'parameter_1')?>">
                </div>
            </div>
        </div>
        <div class="editor_edit_group">
            <h4>KONTAKTY</h4>
            <div class="editor_edit_fields">
                <div class="editor_field">
                    <label>E-Mail info</label>
                    <input type="email" name="rows[contact_info][parameter_1]" value="<?=$infoField('contact_info', 'parameter_1')?>">
                </div>
                <div class="editor_field">
                    <label>Telefon info</label>
                    <input type="tel" name="rows[contact_info][parameter_2]" value="<?=$infoField('contact_info', 'parameter_2')?>">
                </div>
            </div>
        </div>
        <div class="editor_edit_group">
            <div class="editor_edit_fields">
                <div class="editor_field">
                    <label>E-Mail vrátnice</label>
                    <input type="email" name="rows[contact_gate][parameter_1]" value="<?=$infoField('contact_gate', 'parameter_1')?>">
                </div>
                <div class="editor_field">
                    <label>Telefon vrátnice</label>
                    <input type="tel" name="rows[contact_gate][parameter_2]" value="<?=$infoField('contact_gate', 'parameter_2')?>">
                </div>
            </div>
        </div>
        <div class="editor_edit_group">
            <div class="editor_edit_fields">
                <div class="editor_field">
                    <label>E-Mail ztráty a nálezy</label>
                    <input type="email" name="rows[contact_returns][parameter_1]" value="<?=$infoField('contact_returns', 'parameter_1')?>">
                </div>
                <div class="editor_field">
                    <label>Telefon ztráty a nálezy</label>
                    <input type="tel" name="rows[contact_returns][parameter_2]" value="<?=$infoField('contact_returns', 'parameter_2')?>">
                </div>
            </div>
        </div>
        <div class="editor_edit_group">
            <h4>BANKOVNÍ ÚDAJE</h4>
            <div class="editor_edit_fields">
                <div class="editor_field">
                    <label>Banka</label>
                    <input type="text" name="rows[banking][parameter_1]" value="<?=$infoField('banking', 'parameter_1')?>">
                </div>
                <div class="editor_field">
                    <label>Bankovní spojení</label>
                    <input type="text" name="rows[banking][parameter_2]" value="<?=$infoField('banking', 'parameter_2')?>">
                </div>
                <div class="editor_field">
                    <label>ID datové schránky</label>
                    <input type="text" name="rows[databox_id][parameter_1]" value="<?=$infoField('databox_id', 'parameter_1')?>">
                </div>
            </div>
        </div>
        <div class="editor_edit_group">
            <h4>PROVOZNÍ DOBA</h4>
        </div>
        <div class="editor_table_wrapper">
            <table class="editor_table editor_table--compact">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>MĚSÍC</th>
                        <th>DOBA OTEVÍRÁNÍ</th>
                        <th>DOBA ZAVÍRÁNÍ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($openingtime as $month){
                            echo "<tr>
                                <td class='editor_muted'>#".$month["id"]."</td>
                                <td><strong>".$month["month"]."</strong></td>
                                <td><input type='time' name='from[".$month["id"]."]' value='".$timeVal($month["from"])."'></td>
                                <td><input type='time' name='to[".$month["id"]."]' value='".$timeVal($month["to"])."'></td>
                                </tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </form>
</div>