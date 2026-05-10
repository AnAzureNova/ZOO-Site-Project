<?php
    $exclosures = getALL("exclosures_registry", "id DESC");
?>
<div class="evidence_editor">
    <div class="editor_section_header">
        <h1>EXPOZICE</h1>
        <button class="editor_button" onclick="window.location.href='evidence.php?page=exclosures&action=new'">+ NOVÁ EXPOZICE</button>
    </div>
    <div class="editor_table_wrapper">
        <table class="editor_table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NÁZEV</th>
                    <th>LOKACE EXPOZICE</th>
                    <th>POČET ZVÍŘAT</th>
                    <th>NEJBĚŽNĚJŠÍ ZVÍŘE</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (empty($exclosures)){
                        echo "<tr><td colspan='8' class='editor_table_empty'>Žádné expozice v databázi</td></tr>";
                    }
                    else{
                        foreach ($exclosures as $exclosure){
                            $exclosureAnimals = getALL("animals_registry", "name ASC", null, ["clause" => "exclosure = :exclosure", "params" => [":exclosure" => $exclosure["name"]]]);
                            $totalAmount = array_sum(array_column($exclosureAnimals, "amount"));
                            usort($exclosureAnimals, fn($a, $b) => $b["amount"] - $a["amount"]);
                            $mostCommon = !empty($exclosureAnimals) ? $exclosureAnimals[0]["name"] : "—";

                            echo "<tr>
                                <td class='editor_muted'>#".htmlspecialchars($exclosure['id'])."</td>
                                <td><strong>".htmlspecialchars($exclosure['name'])."</strong></td>
                                <td class='editor_italic editor_muted'>".htmlspecialchars($exclosure['location'])."</td>
                                <td>".$totalAmount."</td>
                                <td>".htmlspecialchars($mostCommon)."</td>
                                <td><a class='editor_button' href='evidence.php?page=exclosures&action=edit&id=".htmlspecialchars($exclosure['id'])."'>UPRAVIT</a></td>
                                </tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>