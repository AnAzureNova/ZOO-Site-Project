<?php
    $totalAnimals = array_sum(array_column(getALL("animals_registry", "id ASC"), "amount"));
    $totalSpecies = count(getALL("animals_registry", "id ASC"));
    $totalExclosures = count(getALL("exclosures_registry", "id ASC"));
    $totalEmployees = count(getALL("employees_registry", "id ASC"));

    $today = new DateTime("today");
    $in2weeks = (clone $today)->modify("+14 days")->format("Y-m-d");
    $week_ago = (clone $today)->modify("-7 days")->format("Y-m-d");
    $tomorrow = (clone $today)->modify("+1 day")->format("Y-m-d");

    $upcomingEventsCount = count(getALL("events_registry", null, null, ["clause" => "date_published >= :today AND date_published <= :in2weeks", "params" => [":today" => $today->format("Y-m-d"), ":in2weeks" => $in2weeks]]));
    $recentVisitsCount = count(getALL("zoo_visits", null, null, ["clause" => "valid_from >= :week_ago", "params" => [":week_ago" => $week_ago]]));
    $todayEventsCount = count(getALL("events_registry", null, null, ["clause" => "date_published = :today", "params" => [":today" => $today->format("Y-m-d")]]));
    $expiredUnusedCount = count(getALL("zoo_visits", null, null, ["clause" => "valid_untill < :today AND used = 0", "params" => [":today" => $today->format("Y-m-d")]]));
?>
<div class="evidence_editor">
    <div class="editor_section_header" style="background-image: url('https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Flh3.googleusercontent.com%2Fp%2FAF1QipPDbA-hhoqp0_DL7kPIcekObgTwoq61KHIuEMjD%3Ds1600-w640&f=1&nofb=1&ipt=36da756ee42ac48c8e23ae066fd665b4ab05ac104bdc37ed56e81652a5700521')">
        <div><img id="header_icon" src="STYLE/resources/icons/home.png"><h1>DOBRÝ DEN, <?= strtoupper($_SESSION["evidence_user"]["firstname"]) ?></h1></div>
        <p><?= $today->format("d. m. Y") ?></p>
    </div>
     <div class="editor_table_wrapper">
        <table class="editor_table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>UŽIVATELSKÉ JMÉNO</th>
                    <th>JMÉNO A PŘÍJMENÍ</th>
                    <th>OKUPACE</th>
                    <th>PRACOVNÍ DOBA</th>
                    <th>VÝPLATA</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= htmlspecialchars($_SESSION["evidence_user"]["id"]) ?></td>
                    <td><?= htmlspecialchars($_SESSION["evidence_user"]["web_username"]) ?></td>
                    <td><?= htmlspecialchars(ucfirst($_SESSION["evidence_user"]["firstname"])." ".ucfirst($_SESSION["evidence_user"]["surname"])) ?></td>
                    <td><?= htmlspecialchars(ucfirst($_SESSION["evidence_user"]["occupation"])) ?></td>
                    <td><?= htmlspecialchars($_SESSION["evidence_user"]["shift"]) ?></td>
                    <td><?= htmlspecialchars($_SESSION["evidence_user"]["salary"]) ?></td>
                    <td><?= htmlspecialchars(ucfirst($_SESSION["evidence_user"]["status"])) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="editor_table_wrapper">
        <table class="editor_table editor_table--compact">
            <thead>
                <tr>
                    <th>STATISTIKY ZOO</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Zvířat celkem</td>
                    <td><?= $totalAnimals ?></td>
                </tr>
                <tr>
                    <td>Druhů</td>
                    <td><?= $totalSpecies ?></td>
                </tr>
                <tr>
                    <td>Počet expozic</td>
                    <td><?= $totalExclosures ?></td>
                </tr>
                <tr>
                    <td>Počet zaměstnanců</td>
                    <td><?= $totalEmployees ?></td>
                </tr>
                <tr>
                    <td>Návštěvy za posledních 7 dní</td>
                    <td><?= $recentVisitsCount ?></td>
                </tr>
                <tr>
                    <td>Akce v příštích 14 dnech</td>
                    <td><?= $upcomingEventsCount ?></td>
                </tr>
                <tr>
                    <td>Akce dnes</td>
                    <td><?= $todayEventsCount ?></td>
                </tr>
                <tr>
                    <td>Propadlé nevyužité vstupenky</td>
                    <td><?= $expiredUnusedCount ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="editor_section_footer" >
        <a class="editor_button" href="/index.php">Zpět na hlavní stránku</a>
        <a class="editor_button" href="/evidence.php?action=logout">Odhlásit se</a>
    </div>
</div>