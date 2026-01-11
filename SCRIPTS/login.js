const statusLabel = document.getElementById("loginStatus");
const userInput = document.getElementById("loginUser");
const passInput = document.getElementById("loginPass");
const loginButton  = document.getElementById("loginButton");
const log = document.getElementById("log");

/*users as consts for now; local storage or something later perhaps*/
const admin = {name:"admin", realname:"System admin", pass:"admin", pos:"Admin", status:"immune"};
const user1 = {name:"user1", realname:"Zaměstnanec 1", pass:"abc123", pos:"Employee", status:"unrestricted"};
const user2 = {name:"user2", realname:"UsernameHere", pass:"weakpass1212", pos:"Employee", status:"unrestricted"};
const dummy = {name:"DUMMY", realname:"unknown", pass:"asd", pos:"unknown", status:"restricted"};
let isLoggedIn = false;
let isBlocked = false;
let users = [admin, user1, user2, dummy];
let username;
let password;
let strikeCount = 0;
let logtime;


logtime = new Date(); /*adds the first line to the log*/
log.insertAdjacentHTML("afterend",`<p>> <span>${logtime.getHours()}:${logtime.getMinutes()}:${logtime.getSeconds()}</span> 
        LOG SESSION START ${logtime.getDate()}-${logtime.getMonth()+1}-${logtime.getFullYear()}
        </p>`);
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
    logtime = new Date();
    log.insertAdjacentHTML("afterend",`<p>> <span>${logtime.toLocaleTimeString("en-GB", { hour12: false })}</span> 
        System user logout 
        <br># USER: ${username}</p>`);
    userInput.value = "";
    passInput.value = "";
    document.body.classList.add("login_open");
    document.getElementById("login_visibility").classList.remove("hidden");
    document.getElementById("blur_visibility").classList.remove("hidden");
    clearLabel();
}
function debugCloseLogin(){
    document.body.classList.remove("login_open");
    document.getElementById("usernameLabel").innerHTML = "DEBUG";
    document.getElementById("positionLabel").innerHTML = "DEBUG";
    document.getElementById("realnameLabel").innerHTML = "DEBUG";
    document.getElementById("login_visibility").classList.add("hidden");
    document.getElementById("blur_visibility").classList.add("hidden");
    logtime = new Date();
        log.insertAdjacentHTML("afterend",`<p>> <span>${logtime.toLocaleTimeString("en-GB", { hour12: false })}</span> 
        System debug acess login
        </p>`);
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
        logtime = new Date();
        log.insertAdjacentHTML("afterend",`<p>> <span>${logtime.toLocaleTimeString("en-GB", { hour12: false })}</span> 
            Previously locked out user attempted to log in again
            </p>`);
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
                logtime = new Date();
                log.insertAdjacentHTML("afterend",`<p>> <span>${logtime.toLocaleTimeString("en-GB", { hour12: false })}</span> 
                    User was temporarily locked out due to high ammount of log in attempts, please check for any malicious activity
                    </p>`);
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
            logtime = new Date();
            log.insertAdjacentHTML("afterend",`<p>> <span>${logtime.toLocaleTimeString("en-GB", { hour12: false })}</span> 
                An account labeled as restricted has attempted to log in
                <br># USER: ${arrUser.name}
                <br># USER STATUS: ${arrUser.status}</p>`);
            return false;
        }
        else{
            if(password === arrUser.pass){
                console.log("# PASSWORD MATCH: ", arrUser.pass);
                document.getElementById("usernameLabel").innerHTML = arrUser.name;
                document.getElementById("positionLabel").innerHTML = arrUser.pos;
                document.getElementById("realnameLabel").innerHTML = arrUser.realname;
                logtime = new Date();
                log.insertAdjacentHTML("afterend",`<p>> <span>${logtime.toLocaleTimeString("en-GB", { hour12: false })}</span> 
                    System user login 
                    <br># USER: ${arrUser.name}</p>`);
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