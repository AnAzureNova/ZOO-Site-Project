<?php
    $animals = getALL("animals_registry", "name ASC");
?>
<div class="evidence_editor">
    <div class="editor_section_header">
        <h1>EVIDENCE ZVÍŘAT</h1>
        <button class="editor_button" onclick="window.location.href='evidence.php?page=animals&action=new'">+ NOVÉ ZVÍŘE</button>
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
</div>