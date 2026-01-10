const statusLabel = document.getElementById("loginStatus");
const userInput = document.getElementById("loginUser");
const passInput = document.getElementById("loginPass");
const loginButton  = document.getElementById("loginButton");

/*users as consts for now; local storage or something later perhaps*/
const admin = {name:"admin", pass:"admin", pos:"Admin", status:"immune"};
const user1 = {name:"user1", pass:"abc123", pos:"Employee", status:"unrestricted"};
const user2 = {name:"user2", pass:"weakpass1212", pos:"Employee", status:"unrestricted"};
const dummy = {name:"DUMMY", pass:"asd", pos:"Unknown", status:"restricted"};
let isLoggedIn = true;
let isBlocked = false;
let users = [admin, user1, user2, dummy];
let username;
let password;
let strikeCount = 0;

/*------------------USER INPUT KEYBINDS------------------*/
/*Mainly QOL but i felt like i should add it for convenience*/
userInput.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
        e.preventDefault();
        passInput.focus();
    }
});
passInput.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
        e.preventDefault();
        passInput.blur();
        loginAuth();
    }
});
/*------------------------------------*/
function clearLabel(){ /*Will clear the popup once text is entered again*/
    statusLabel.innerHTML = "";
}
function logoutUser(){
    isLoggedIn = false;
    location.reload();
}

/*------------------HIDE OR SHOW WINDOW UPON START------------------*/
if (!isLoggedIn){
    document.body.classList.add("login_open");
    document.getElementById("login_visibility").classList.remove("hidden");
    document.getElementById("blur_visibility").classList.remove("hidden");
}
else{
    document.getElementById("login_visibility").classList.add("hidden");
    document.getElementById("blur_visibility").classList.add("hidden");
}
/*------------------MAIN FUNTION------------------*/
document.getElementById("loginForm").addEventListener("submit", (e) => {
    e.preventDefault();
    loginAuth();
});
function loginAuth(){
    if(isBlocked){
        statusLabel.innerHTML= "Z bezpečnostních důvodů přístup provizorně zablokován.";
    }
    else if(!isLoggedIn){
        username = userInput.value;
        console.log("> Saved temp user", username);
        password = passInput.value;
        console.log("> Attatched password", password);
        if (users.some(checkForUser)){
            console.log("# LOGIN AUTHORISED");
            document.body.classList.remove("login_open");
            document.getElementById("login_visibility").classList.add("hidden");
            document.getElementById("blur_visibility").classList.add("hidden");
            isLoggedIn = true;
        }
        else{
            console.log("# LOGIN FAILED");
            if (strikeCount > 2){
                isBlocked = true;
                statusLabel.innerHTML= "Kvůli vysokému počtu pokusů vám byl z bezpečnostních důvodů přístup provizorně zablokován, prosím zkuste to znovu později.";
            }
            else{
                statusLabel.innerHTML= "Špatné uživatelské jméno nebo heslo, prosím zkuste to znovu.";
                strikeCount++;
                console.log("bad secrets ", strikeCount);
            }
        }
    }
}
function checkForUser(arrUser){ /*Im rlly happy i got the object data working this is awsome*/
    if (username === arrUser.name){
        console.log("# USER MATCH FOUND: ", arrUser.name);
        if(arrUser.status === "restricted"){
            return false;
        }
        else{
            if(password === arrUser.pass){
               console.log("# PASSWORD MATCH: ", arrUser.pass);
                document.getElementById("username_label").innerHTML = arrUser.name;
                document.getElementById("position_label").innerHTML = arrUser.pos;
                return true;
            }
            else{
                console.log("> Bad secrets");
                return false;
            }
        }
    }
    else{
        console.log("> No user");
    }
}