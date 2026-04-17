<?php
    define("SYSLOG_PATH", __DIR__ . "/log/zoo.syslog");
    define("SYSLOG_MAX_LINES", 100);

    # FUnkce pro zapisování akcí do historie logu
    function logAction($action, $cur_user = null, $detail = ""): void {
        $timestamp = date("Y-m-d H:i:s"); # grabne current time v určeném formátu
        $who = "SYSTEM"; # SYSTEM default value

        # přidá potřebné info o uživateli který vykonal akci a zapíše je do proměnné $who
        if ($cur_user && isset($cur_user["username"])) {
            $who = strtoupper($cur_user["username"]);
        }

        # sestaví celý řádek ve formátu [ČAS] [UŽÍVATEL] [AKCE] | [JINÉ]
        $line = "[{$timestamp}] [{$who}] {$action}";
        if ($detail !== ""){
            $line .= " | {$detail}";
        }
        $line .= PHP_EOL; #appendne end of line symbol

        #přidá line do souboru
        file_put_contents(SYSLOG_PATH, $line, FILE_APPEND | LOCK_EX);

        # pokud počet řádků přesáhne určený limit pak umaže řádky a nechá pouze x nejnovějších
        $allLines = file(SYSLOG_PATH, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (count($allLines) > SYSLOG_MAX_LINES) {
            $trimmed = array_slice($allLines, -SYSLOG_MAX_LINES);
            file_put_contents(SYSLOG_PATH, implode(PHP_EOL, $trimmed). PHP_EOL, LOCK_EX);
        }
    }
?>