<header>
    <div>
        <h1>ZOO MANAGEMENT</h1>
    </div>
    <div>
        <?php
            echo "<p>".htmlspecialchars($_SESSION["evidence_user"]["firstname"]." ".$_SESSION["evidence_user"]["surname"])."</p>";
            echo "<p>".htmlspecialchars($_SESSION["evidence_user"]["occupation"])."</p>";
        ?>
        <?php if (isset($_SESSION["evidence_user"])): ?>
            <a class="editor_button" href="/evidence.php?action=logout">Odhlásit se</a>
        <?php endif; ?>
    </div>
</header>