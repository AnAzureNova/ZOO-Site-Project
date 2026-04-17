<?php
    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $username = trim($_POST["username"] ?? "");
        $password = trim($_POST["password"] ?? "");
        $employee = loginEmployee($username, $password);

        if ($employee) {
            $_SESSION["evidence_user"] = ["id"=>$employee["id"], "username" => $employee["web_username"], "firstname" => $employee["firstname"], "surname" => $employee["surname"], "occupation" => $employee["occupation"],];
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
        <h1>PŘIHLÁŠENÍ</h1>
        <?php 
            if(!empty($loginError)){
                echo "<p class='login_error'>".htmlspecialchars($loginError)."</p>";
            }
        ?>
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
</div>