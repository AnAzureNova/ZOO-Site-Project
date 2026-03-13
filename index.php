<!DOCTYPE SITE>
<SITE lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="STYLE/resources/icons/pawprints.png" type="image/x-icon">
    <link rel="stylesheet" href="STYLE/global.css">
    <link rel="stylesheet" href="STYLE/globalDropdowns.css">
    <link rel="stylesheet" href="STYLE/mainPage.css">
    <title>Zoo Brno 2</title>
</head>
<?php
    session_start();
    include "DATABASE/database.php";
?>
<body>
<!----------------------------------------------------------------------------------------------------------->
<!--NAVBAR-->
<?php
    $motd = getCurrMotd();
    include "COMPONENTS/navbar.php";
    if ($motd){
         echo '<div class="bg_image" style="background-image: url(\''.$motd["bgimage"].'\')"><div class="bg_overlay"></div></div>';
    }
    else{
         echo '<div class="bg_image" style="background-image: url(/STYLE/resources/images/deer1.jpg)"><div class="bg_overlay"></div></div>';
    }
?>
<!----------------------------------------------------------------------------------------------------------->
<!--MAIN-->
    <main>
        <section>
            <div class="main_event_big">
                <?php
                    if ($motd){
                        echo '<div class="main_event_big_info">';
                        echo '<span></span><a href="">'.$motd["setdate"].'</a><a href="">'.$motd["setlocation"].'</a>';
                        echo '</div>';
                        echo '<h1>'.$motd["eventheader"].'</h1>';
                        echo '<hr><p>'.$motd["eventcontents"].'</p>';
                        echo '<a href="'.$motd["linktoredirect"].'">> ZJISTIT VÍCE</a>
                            <a id="redirectButton" href="">ZAKOUPIT VSTUPENKY</a>';
                    }
                    else{
                        echo "<h1><span>Žádné</span> dostupné <span>aktuality</span></h1>";
                        echo "<hr>";
                        echo "<p>Tato správa se zobrazí pouze v případě kdy není nakonfigurovaná zobrazená aktualita, prosím vyčkejte, pracujeme na tom!</p>";
                    }

                ?>
            </div>
            <div class="main_event_sub_title">
                <h2>Další novinky</h2>
            </div>
            <div class="main_event_sub">
                <?php
                    $events = getALL("events_registry", "id DESC", 3);
                    $count = count($events);
                    for ($i = 0; $i < 3; $i++) {
                        if ($i < $count) {
                            echo "<article>";
                            echo "<p>".$events[$i]["image"]."</p>";
                            echo "<h3>".$events[$i]["title"]."</h3>";
                            echo "<h5>".$events[$i]["date_published"]."</h5>";
                            echo "<p>".$events[$i]["description"]."</p>";
                            echo "<a href='".$events[$i]["linktoredirect"]."'>View more</a>";
                            echo "</article>";
                        }
                        else{
                            echo "<article>";
                            echo "<h3>No event</h3>";
                            echo "</article>";
                        }
                    }
                ?>
            </div>
            <div class="main_event_sub_extra">
                <a href="" id="redirectButton">VŠECHNY NOVINKY</a>
            </div>
            
        </section>
    </main>
<!----------------------------------------------------------------------------------------------------------->
<!--FOOTER-->
    <?php
        include "COMPONENTS/footer.php";
    ?>
    <script src="SCRIPTS/global.js"></script>
</body>
</SITE>