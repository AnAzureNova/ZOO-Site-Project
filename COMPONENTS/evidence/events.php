<?php
    $events = getALL("events_registry", "id DESC");
?>
<div class="evidence_editor">
    <div class="editor_section_header">
        <h1>AKCE A PROGRAMY</h1>
        <button class="editor_button" onclick="window.location.href='evidence.php?page=events&action=new'">+ NOVÁ AKCE</button>
    </div>
    <div class="editor_table_wrapper">
        <table class="editor_table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NÁZEV</th>
                    <th>LOKACE AKCE</th>
                    <th>DATUM</th>
                    <th>POČÁTEČNÍ ČAS</th>
                    <th>ČAS DO</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (empty($events)){
                        echo "<tr><td colspan='8' class='editor_table_empty'>Žádné akce v databázi</td></tr>";
                    }
                    else{
                        foreach ($events as $event){
                            $today = new DateTime("today");
                            $eventDate = new DateTime($event["date_published"]);
                            $diff = (int)$today->diff($eventDate)->days;

                            if (!empty($event["date_published"])){
                                $today = new DateTime("today");
                                $eventDate = new DateTime($event["date_published"]);
                                $diff = (int)$today->diff($eventDate)->days;

                                if ($diff === 0) $dueIn = "Dnes";
                                else if ($eventDate < $today) $dueIn = "Akce proběhla";
                                else if ($diff === 1) $dueIn = "Zítra";
                                else if ($diff === 2) $dueIn = "Pozítří";
                                else if ($diff < 5) $dueIn = "za ".$diff." dny";
                                else $dueIn = "za ".$diff." dní";

                                if (class_exists("IntlDateFormatter")){
                                    $formatter = new IntlDateFormatter("cs_CZ", IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                                    $formattedDate = $formatter->format($eventDate);
                                }
                                else{
                                    $formattedDate = $eventDate->format("d. m. Y");
                                }
                            }
                            else{
                                $dueIn = "—";
                                $formattedDate = "—";
                            }

                            echo "<tr>
                                <td class='editor_muted'>#".htmlspecialchars($event['id'])."</td>
                                <td><strong>".htmlspecialchars($event['title'])."</strong></td>
                                <td class='editor_italic editor_muted'>".htmlspecialchars($event['location'])."</td>
                                <td>".$formattedDate."</td>
                                <td>".htmlspecialchars($event['start_time'])."</td>
                                <td class='editor_italic editor_muted'>".$dueIn."</td>
                                <td><a class='editor_button' href='evidence.php?page=events&action=edit&id=".htmlspecialchars($event['id'])."'>UPRAVIT</a></td>
                            </tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>