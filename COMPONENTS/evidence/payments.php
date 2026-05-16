<?php
    $payments = getALL("payments", "id DESC");
?>
<div class="evidence_editor">
    <div class="editor_section_header">
        <div><img id="header_icon" src="STYLE/resources/icons/purchases.png"><h1>ZÁZNAM NÁKUPŮ</h1></div>
    </div>
    <div class="editor_table_wrapper">
        <table class="editor_table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ČAS ZAKOUPENÍ</th>
                    <th>KÓD NÁKUPU</th>
                    <th>JMÉNO</th>
                    <th>PŘÍJMENÍ</th>
                    <th>CENA NÁKUPU (Kč)</th>
                    <th>OBSAH NÁKUPU</th>
                    <th>TYP NÁKUPU</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (empty($payments)){
                        echo "<tr><td colspan='8' class='editor_table_empty'>Žádné akce v databázi</td></tr>";
                    }
                    else{
                        foreach ($payments as $payment){
                            echo "<tr>
                                <td class='editor_muted'>#".htmlspecialchars($payment['id'])."</td>
                                <td>".htmlspecialchars($payment['create_time'])."</td>
                                <td class='editor_italic editor_muted'>".htmlspecialchars($payment['payment_code'])."</td>
                                <td><strong>".htmlspecialchars($payment['firstname'])."</strong></td>
                                <td><strong>".htmlspecialchars($payment['surname'])."</strong></td>
                                <td>".htmlspecialchars($payment['pay_price'])."</td>
                                <td>".htmlspecialchars($payment['order_contents'])."</td>
                                <td class='editor_italic editor_muted'>".htmlspecialchars($payment['payment_type'])."</td>
                                <td><a class='editor_button' href='evidence.php?page=payments&action=view&id=".htmlspecialchars($payment['id'])."'>ZOBRAZIT</a></td>
                            </tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>