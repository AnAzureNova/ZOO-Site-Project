<?php
    define("SYSLOG_PATH", __DIR__ . "/zoo.syslog");
    define("SYSLOG_DISPLAY_LIMIT", 150);

    if (file_exists(SYSLOG_PATH)){
        # pokud soubor existuje tak z něho vytáhne všechen text (logtext) a roseká ho na řádky do pole (lines) pod určeným limitem
        $logtext = array_reverse(file(SYSLOG_PATH, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
        $lines = array_slice($logtext, 0, SYSLOG_DISPLAY_LIMIT);
    } 
    else{
        $lines = [];
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST["log_input"])){
        $input = $_POST["log_input"];
        logAction("console_report", $_SESSION["evidence_user"], $input);
        header("Location: /evidence.php?page=syslog");
        exit();
    }
?>
<div class="syslog">
    <div class="syslog_entries">
        <?php
            if (empty($lines)){
                echo "<p class='syslog_empty'>Žádné záznamy.</p>";
            }
            else{
                foreach ($lines as $line){
                    preg_match('/^\[(.+?)\] \[(.+?)\] (.+)$/', $line, $match); #nemám rád regex

                    $timestamp = $match[1] ?? "?"; # [1] čas (2026-04-17 14:23:01)
                    $user = $match[2] ?? "?"; # [2] uživatel (ADMIN)
                    $other = $match[3] ?? $line; # [3] zbytek (action | details)
                    [$action, $detail] = array_pad(explode(" | ", $other, 2), 2, ""); # rozdělí other na příslušné parametry

                    echo "<div class='syslog_entry'>";
                    echo "<span class='timestamp'>[".htmlspecialchars($timestamp)."] </span>
                        <span class='syslog_user'>".htmlspecialchars($user)."</span>
                        <span class='syslog_action'>".htmlspecialchars($action)."</span>".($detail ? "<span class='syslog_detail' title='".htmlspecialchars($detail)."'>".htmlspecialchars($detail)."</span>" : "");
                    echo "</div>";
                }
            }
        ?>
    </div>
</div>
<form method="post" action="" class="syslog_input">
    <input type="text" placeholder="> ENTER REPORT" name="log_input" id="log_input">
    <button type="submit">>>></button>
</form>