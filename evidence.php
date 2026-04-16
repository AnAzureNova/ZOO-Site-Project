<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="STYLE/evidence.css">
    <link rel="icon" href="STYLE/resources/icons/wrench.png" type="image/x-icon">
    <title>INFORMAČNÍ SYSTÉM Zoo Brno 2</title>
</head>
<?php
    session_start();
    include "DATABASE/database.php";

    if (isset($_GET["action"]) && $_GET["action"] === "logout") {
        session_destroy();
        header("Location: /evidence.php");
        exit();
    }
?>
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
        <a href="evidence.php?page=employeelog">PŘEHLED ZAMĚSTNANCŮ</a>
        <a href="evidence.php?page=syslog">HISTORIE SYSTÉMU</a>
    </aside>
    <section class="evidence_main">
        <?php
            #safeguard, otevře login komponent pokud uživatel není přihlášen
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
                    include "COMPONENTS/evidence/animals.php";
                    break;
                case "exclosures":
                    include "COMPONENTS/evidence/exclosures.php";
                    break;
                case "events":
                    include "COMPONENTS/evidence/events.php";
                    break;
                case "eshop":
                    include "COMPONENTS/evidence/eshop.php";
                    break;
                case "visitorlog":
                    include "COMPONENTS/evidence/visitorlog.php";
                    break;
                case "employeelog":
                    include "COMPONENTS/evidence/employeelog.php";
                    break;
                case "syslog":
                    include "COMPONENTS/evidence/syslog.php";
                    break;
                default:
                    include "COMPONENTS/evidence/home.php";
                    break;
            }
        ?>
    </section>
</main>
</body>
</html>