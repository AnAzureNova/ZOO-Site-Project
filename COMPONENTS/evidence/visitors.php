<?php
    $visitors = getALL("zoo_visits", "id DESC");
?>
<div class="evidence_editor">
    <div class="editor_section_header">
        <h1>PŘEHLED NÁVŠTĚVNÍKŮ</h1>
        <button class="editor_button" onclick="window.location.href='evidence.php?page=visitors&action=new'">+ NOVÁ AKCE</button>
    </div>
    <div class="editor_table_wrapper">
        <table class="editor_table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ČAS ZAKOUPENÍ</th>
                    <th>KÓD NÁKUPU</th>
                    <th>POČET OSOB</th>
                    <th>PLATÍ OD</th>
                    <th>PLATÍ DO</th>
                    <th>VSTUPENKA POUŽITA</th>
                    <th>VSTUPENKA PROPADLA</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (empty($visitors)){
                        echo "<tr><td colspan='8' class='editor_table_empty'>Žádné akce v databázi</td></tr>";
                    }
                    else{
                        foreach ($visitors as $visit){
                            echo "<tr>
                                <td class='editor_muted'>#".htmlspecialchars($visit['id'])."</td>
                                <td>".htmlspecialchars($visit['create_time'])."</td>
                                <td class='editor_italic editor_muted'>".htmlspecialchars($visit['code'])."</td>
                                <td><strong>".htmlspecialchars($visit['amount'])."</strong></td>
                                <td>".htmlspecialchars($visit['valid_from'])."</td>
                                <td>".htmlspecialchars($visit['valid_untill'])."</td>";
                            if($visit['used'] === 0){
                                echo "<td class='editor_italic editor_muted'>Ne</td>";
                            }
                            else{
                                echo "<td class='editor_italic editor_muted'>Ano</td>";
                            }
                            if($visit['used'] === 0){
                                echo "<td class='editor_italic editor_muted'>Ne</td>";
                            }
                            else{
                                echo "<td class='editor_italic editor_muted'>Ano</td>";
                            }
                            echo "<td><a class='editor_button' href='evidence.php?page=visitors&action=view&id=".htmlspecialchars($visit['id'])."'>ZOBRAZIT</a></td>
                            </tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>