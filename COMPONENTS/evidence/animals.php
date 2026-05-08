<?php
    $animals = getALL("animals_registry", "name ASC");
    $exclosures = getALL("exclosures_registry", "name ASC");
?>
<div class="evidence_animals">
    <div class="animals_section_header">
        <h1>EVIDENCE ZVÍŘAT</h1>
        <button class="animals_button" onclick="window.location.href='evidence.php?page=animals&action=new'">+ NOVÉ ZVÍŘE</button>
    </div>
    <div class="animals_table_wrapper">
        <table class="animals_table">
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
                        echo "<tr><td colspan='8' class='animals_table_empty'>Žádná zvířata v databázi</td></tr>";
                    }
                    else{
                        foreach ($animals as $animal){
                            $extinctionClass = "";
                            if ($animal["extninction_index"] >= 4) $extinctionClass = "extinct_high";
                            else if ($animal["extninction_index"] >= 2) $extinctionClass = "extinct_mid";
                            else $extinctionClass = "extinct_low";

                            echo "<tr>
                                <td class='animals_muted'>#".htmlspecialchars($animal['id'])."</td>
                                <td><strong>".htmlspecialchars($animal['name'])."</strong></td>
                                <td class='animals_italic animals_muted'>".htmlspecialchars($animal['name_latin'])."</td>
                                <td>".htmlspecialchars($animal['classification'])."</td>
                                <td>".htmlspecialchars($animal['exclosure'])."</td>
                                <td>".htmlspecialchars($animal['amount'])."</td>
                                <td><a class='animals_button' href='evidence.php?page=animals&action=edit&id=".htmlspecialchars($animal['id'])."'>UPRAVIT</a></td>
                                </tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>