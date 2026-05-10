<?php
    session_start();
    include "DATABASE/database.php";
    include "COMPONENTS/evidence/log/actionlog.php";
    include "COMPONENTS/evidence/debug/PHP-JS_log.php";

    # logout uživatele
    if (isset($_GET["action"]) && $_GET["action"] === "logout") {
        logAction("logout", $_SESSION["evidence_user"] ?? null, "via browser");
        session_destroy();
        header("Location: /evidence.php");
        exit();
    }

    # timeout na 15 minut bez aktivity
    define("TIMEOUT_TIME", 15 * 60);
    if (isset($_SESSION["last_activity"]) && (time() - $_SESSION["last_activity"]) > TIMEOUT_TIME) {
        console_log("> FORCED LOGOUT");
        logAction("session_timeout", $_SESSION["evidence_user"], "due to inactivity");
        session_destroy();
        header("Location: /evidence.php");
        exit();
    }
    console_log("> DEBUG :: TIME TILL TIMEOUT " . gmdate("i:s", TIMEOUT_TIME - (time() - ($_SESSION["last_activity"] ?? time())))); #pouze debug do konzole jak dlouho než uživatel dostane timeout
    $_SESSION["last_activity"] = time();
    trackActivity($_SESSION["evidence_user"]);

    # POST handler pro komponenty
    include "COMPONENTS/evidence/handlers/post_handler.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="STYLE/evidence.css">
    <link rel="stylesheet" href="STYLE/evidence_editor.css">
    <link rel="stylesheet" href="STYLE/evidence_login.css">
    <link rel="icon" href="STYLE/resources/icons/wrench.png" type="image/x-icon">
    <title>INFORMAČNÍ SYSTÉM Zoo Brno 2</title>
</head>
<body>
<?php
    include "COMPONENTS/evidence/evidenceHeader.php";
?>
<main>
    <aside class="evidence_sideNav">
        <a href="evidence.php?page=home">HLAVNÍ STRÁNKA</a>
        <a href="evidence.php?page=management">MANAGEMENT ZOO</a>
        <a href="evidence.php?page=animals">EVIDENCE ZVÍŘAT</a>
        <a href="evidence.php?page=exclosures">EXPOZICE</a>
        <a href="evidence.php?page=events">AKCE A PROGRAMY</a>
        <a href="evidence.php?page=eshop">ZÁZNAMY E-SHOPU</a>
        <a href="evidence.php?page=visitorlog">PŘEHLED NÁVŠTĚVNÍKŮ</a>
        <a href="evidence.php?page=employees">PŘEHLED ZAMĚSTNANCŮ</a>
        <a href="evidence.php?page=syslog">HISTORIE SYSTÉMU</a>
    </aside>
    <section class="evidence_main">
        <?php
            # donutí načíst login komponent pokud uživatel není přihlášen
            if (!isset($_SESSION["evidence_user"])) {
                include "COMPONENTS/evidence/login.php";
                exit();
            }
            $page = $_GET["page"] ?? "home";
            switch ($page){
                case "management":
                    include "COMPONENTS/evidence/management.php";
                    break;
                case "animals":
                    if (isset($_GET["action"]) && ($_GET["action"] === "edit" || $_GET["action"] === "new")){
                        include "COMPONENTS/evidence/editors/animals_edit.php";
                    }
                    else{
                        include "COMPONENTS/evidence/animals.php";
                    }
                    break;
                case "exclosures":
                    if (isset($_GET["action"]) && ($_GET["action"] === "edit" || $_GET["action"] === "new")){
                        include "COMPONENTS/evidence/editors/exclosures_edit.php";
                    }
                    else{
                        include "COMPONENTS/evidence/exclosures.php";
                    }
                    break;
                case "events":
                    if (isset($_GET["action"]) && ($_GET["action"] === "edit" || $_GET["action"] === "new")){
                        include "COMPONENTS/evidence/editors/events_edit.php";
                    }
                    else{
                        include "COMPONENTS/evidence/events.php";
                    }
                    break;
                case "eshop":
                    include "COMPONENTS/evidence/eshop.php";
                    break;
                case "visitorlog":
                    include "COMPONENTS/evidence/visitorlog.php";
                    break;
                case "employees":
                    if (isset($_GET["action"]) && ($_GET["action"] === "edit" || $_GET["action"] === "new")){
                        include "COMPONENTS/evidence/editors/employees_edit.php";
                    }
                    else{
                        include "COMPONENTS/evidence/employees.php";
                    }
                    break;
                case "syslog":
                    include "COMPONENTS/evidence/log/syslog.php";
                    break;
                default:
                    include "COMPONENTS/evidence/home.php";
                    break;
            }
        ?>
    </section>
</main>
<script src="SCRIPTS/select.js"></script>
</body>
</html>