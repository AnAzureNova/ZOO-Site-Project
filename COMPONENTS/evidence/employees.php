<?php
    $employees = getALL("employees_registry", "web_activity DESC");
?>
<div class="evidence_editor">
    <div class="editor_section_header">
        <div><img id="header_icon" src="STYLE/resources/icons/employees.png"><h1>PŘEHLED ZAMĚSTNANCŮ</h1></div>
        <?php if ($_SESSION["evidence_user"]["status"] === "admin"): ?>
            <button class="editor_button" onclick="window.location.href='evidence.php?page=employees&action=new'">+ NOVÝ UŽIVATEL</button>
        <?php endif; ?>
    </div>
    <div class="editor_table_wrapper">
        <table class="editor_table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>UŽIVATELSKÉ JMÉNO</th>
                    <th>VYTVOŘENÍ UŽIVATELE</th>
                    <th>JMÉNO A PŘÍJMENÍ</th>
                    <th>OKUPACE</th>
                    <th>PRACOVNÍ DOBA</th>
                    <th>VÝPLATA</th>
                    <th>STATUS</th>
                    <th>POSLEDNÍ AKTIVITA</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (empty($employees)){
                        echo "<tr><td colspan='8' class='editor_table_empty'>CHYBA V DATABÁZI</td></tr>";
                    }
                    else{
                        foreach ($employees as $employee) {
                            if (!empty($employee["web_activity"])) {
                                $today = new DateTime("today");
                                $employeeActivity = new DateTime($employee["web_activity"]);
                                $activityDate = new DateTime($employeeActivity->format("Y-m-d"));
                                $diff = (int)$today->diff($activityDate)->days;

                                console_log($employee["name"].$diff);
                                if ($diff === 0) $lastActive = "Dnes";
                                else if ($diff === 1) $lastActive = "Včera";
                                else $lastActive = "Před ".$diff." dny";

                                if (class_exists("IntlDateFormatter")) {
                                    $formatter = new IntlDateFormatter("cs_CZ", IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                                    $formattedDate = $formatter->format($employeeActivity)." ".$employeeActivity->format("H:i:s");
                                }
                                else {
                                    $formattedDate = $employeeActivity->format("d. m. Y H:i:s");
                                }
                            }
                            else {
                                $lastActive = "—";
                                $formattedDate = "—";
                            }

                            echo "<tr>
                                <td class='editor_muted'>#".htmlspecialchars($employee['id'])."</td>
                                <td><strong>".htmlspecialchars($employee['web_username'])."</strong></td>
                                <td class='editor_italic editor_muted'>".htmlspecialchars($employee['create_time'])."</td>
                                <td>".ucfirst(htmlspecialchars($employee['firstname']))." ".ucfirst(htmlspecialchars($employee['surname']))."</td>
                                <td>".ucfirst(htmlspecialchars($employee['occupation']))."</td>
                                <td>".ucfirst(htmlspecialchars($employee['shift']))."</td>
                                <td>".ucfirst(htmlspecialchars($employee['salary']))." Kč</td>
                                <td>".ucfirst(htmlspecialchars($employee['status']))."</td>
                                <td class='editor_italic editor_muted'>".$lastActive." - {$formattedDate}</td>";
                            if ($_SESSION["evidence_user"]["status"] === "admin"){
                                echo "<td><a class='editor_button' href='evidence.php?page=employees&action=edit&id=".htmlspecialchars($employee['id'])."'>UPRAVIT</a></td>";
                            }
                            echo "</tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>