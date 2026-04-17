<?php
    define("SYSLOG_PATH", __DIR__ . "/log/zoo.syslog");
    define("SYSLOG_DISPLAY_LIMIT", 50);

    if (file_exists(SYSLOG_PATH)){
        # pokud soubor existuje tak z něho vytáhne všechen text (logtext) a roseká ho na řádky do pole (lines) pod určeným limitem
        $logtext = array_reverse(file(SYSLOG_PATH, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
        $lines = array_slice($logtext, 0, SYSLOG_DISPLAY_LIMIT);
    } 
    else{
        $lines = [];
    }
?>
<h1>ZÁZNAM SYSTÉMU</h1>
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
                    echo "<span class='timestamp'>> [".htmlspecialchars($timestamp)."] </span>
                        <span>".htmlspecialchars($user)."</span>
                        <span>".htmlspecialchars($action)."</span>".($detail ? "<span class='syslog_detail'> ".htmlspecialchars($detail)."</span>" : "");
                    echo "</div>";
                }
            }
        ?>
    </div>
</div>