<?php
    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $username = trim($_POST["username"] ?? "");
        $password = trim($_POST["password"] ?? "");
        $employee = loginEmployee($username, $password);

        if ($employee) {
            $_SESSION["evidence_user"] = ["id"=>$employee["id"], "username" => $employee["web_username"], "firstname" => $employee["firstname"], "surname" => $employee["surname"], "occupation" => $employee["occupation"],"status" => $employee["status"], "web_username" => $employee["web_username"], "salary" => $employee["salary"], "shift" => $employee["shift"]];
            logAction("login", $_SESSION["evidence_user"], "via browser");
            header("Location: /evidence.php");
            exit();
        } 
        else{
            $loginError = "Nesprávné přihlašovací údaje.";
            logAction("failed login attempt", null);
        }
    }
?>

<div class="evidence_login">
    <div class="login_box">
        <div class="login_top">
            <a href="/index.php" class="editor_button" >X</a>
            <h1>PŘIHLÁŠENÍ</h1>
            <p>Pro přístup k systému se prosím přihlašte za pomocí vašich přiřazených přihlašovacích údajů.</p>
            <?php 
                if(!empty($loginError)){
                    echo "<p class='login_error'>".htmlspecialchars($loginError)."</p>";
                }
            ?>
        </div>
        <form method="POST" action="/evidence.php">
            <div class="login_field">
                <label for="username">Uživatelské jméno</label>
                <input type="text" id="username" name="username" autocomplete="username" required>
            </div>
            <div class="login_field">
                <label for="password">Heslo</label>
                <input type="password" id="password" name="password" autocomplete="current-password" required>
            </div>
            <button type="submit">PŘIHLÁSIT SE</button>
        </form>
    </div>
    <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fbrevardzoo.org%2Fwp-content%2Fuploads%2F2023%2F07%2F230318-1-scaled-e1689277950565.jpg&f=1&nofb=1&ipt=71d5bd255b925d4ab6e7a5cb9130f5e937dd32a1c26aa64a659fdc3247dea7c0">
</div>