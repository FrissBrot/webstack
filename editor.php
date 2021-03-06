<?php
session_start();
if(!isset($_SESSION['username'])){
  header("Location: index.php");
  exit;
}

$loggedusername = $_SESSION['username'];

$filepath = 'C:\laragon\www\\' . $loggedusername . '.txt';
$file_handle = fopen($filepath, 'w');

if(count($_GET) > 0){ //wird nur ausgeführt, wenn array grösser 0

    $colors = $_GET["backgroundInpute"] ."," .$_GET["buttonInput"] ."," .$_GET["hoverInput"];

}
else{
    
    $colors = 0;

}; 

if(strlen($colors) > 1){
    
    //Daten in Datenbank Speichern
    require("mysql.php");
    $stmt = $mysql->prepare("UPDATE accounts SET colors = :color WHERE USERNAME = :username");
    $stmt->bindValue(":username", $loggedusername);
    $stmt->bindValue(":color", $colors);
    $stmt->execute();

};


//Daten Abfragen
require("mysql.php");
$stmt = $mysql->prepare("SELECT colors FROM accounts WHERE USERNAME = :user"); //Username überprüfen
$stmt->bindValue(":user", $loggedusername);
$stmt->execute();
$SavedColors = $stmt->fetch();

// SavedColors in Array umwandeln
$SavedColors1 = explode(",", $SavedColors[0]);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css" media="screen" />
    <link rel="icon" href="pictures\favicon.gif" type="image/gif">
    <title>Webstack • Editor</title>
</head>

<body>
    <div class="Navigate">
        <a class="NavigateFont marginleft30" href="logout.php">ABMELDEN</a>
    </div>
    <div id="editfield">
        <div Id="editbar">
            <p id="EditBarTitle">BEARBEITEN</p>
            <div id="FarbenBereich">
                <p class="NavZwischenTittel">Farben</p>
                <form>
                    <label for="kb_selected_color_background" class="EditBarAtributesText">Hintergrundfarbe:</label>
                    <input type="color" id="kb_selected_color_background" class="EditBarAtributes PickerStyle"
                        value="#82E8BF">
                    <span id="hex-background" style="display: none;">(#000000)</span>
                </form>
                <form>
                    <label for="kb_selected_color_button" class="EditBarAtributesText">Buttonfarbe </label>
                    <input type="color" id="kb_selected_color_button" class="PickerStyle" value="#82E8BF">
                    <span id="hex-button" style="display: none;">(#000000)</span>
                </form>
                <form>
                    <label for="kb_selected_color_hover" class="EditBarAtributesText">Hoverfarbe </label>
                    <input type="color" id="kb_selected_color_hover" value="#82E8BF" class="PickerStyle">
                    <span id="hex-hover" style="display: none;">(#000000)</span>
                </form>
            </div>
            <div class="TrennBorder"></div>
            <div id="TextBereich">
                <p class="NavZwischenTittel">Text</p>
                <form>
                    <input type="text" id="Feld_1" class="EditTextInput">
                </form>
                <div id="TextBereichGenerate"></div>
                <button class="EditButtons" onclick="erstellenButton()">erstellen</button>
                <button class="EditButtons" onclick="TextAnpassen(2)">Update</button>
            </div>
            <div class="TrennBorder"></div>
            <button class="EditButtons"
                onclick="VarSubmit(removeFirstChar(backgroundInput.value), removeFirstChar(buttonInput.value), removeFirstChar(hoverInput.value))">Speichern</button>
        </div>
        <div id="previewbody">
            <img class="profileborder profilbildsize" src="pictures\pb.jpg" alt="Profilbild">
            <h1 id=usernameshow>Dein Benutzername</h1>
            <button type="button"
                onclick="window.open('https://open.spotify.com/user/69qw99f7ej6x4j26813u9hnly?si=bc5435e89ad54602', '_blank');"
                class="linkbutton" id="ButId1"><img alt="Spotify Icon" class="iconsize"
                    src="pictures\spotify.png">Spotify</button><br>
        </div>
    </div>

</body>
<script>
var name = <?php echo json_encode($loggedusername); ?>;
document.getElementById('usernameshow').innerHTML = name;

// Farbe aus ColorPicker auslesen
var backgroundInput = document.getElementById("kb_selected_color_background");

var theColor = backgroundInput.value;
backgroundInput.addEventListener("input", function() {

    // Farcode (Hex) schreiben
    document.getElementById("hex-background").innerHTML = backgroundInput.value;

    // Farbvariable schreiben
    document.documentElement.style.setProperty('--kb-color-background', backgroundInput.value);

}, false);

// Farbe aus ColorPicker auslesen
var buttonInput = document.getElementById("kb_selected_color_button");

var theColor = buttonInput.value;
buttonInput.addEventListener("input", function() {

    // Farcode (Hex) schreiben
    document.getElementById("hex-button").innerHTML = buttonInput.value;

    // Farbvariable schreiben
    document.documentElement.style.setProperty('--kb-color-button', buttonInput.value);
}, false);

// Farbe aus ColorPicker auslesen
var hoverInput = document.getElementById("kb_selected_color_hover");

var theColor = hoverInput.value;
hoverInput.addEventListener("input", function() {

    // Farcode (Hex) schreiben
    document.getElementById("hex-hover").innerHTML = hoverInput.value;

    // Farbvariable schreiben
    document.documentElement.style.setProperty('--kb-color-hover', hoverInput.value);
}, false);

//Textfeld anpassen
var elem = document.getElementById("Feld_1");
elem.addEventListener("change", function() {
        TextAnpassen("1");
    },
    false);

function TextAnpassen(Id) {
    var TextFeldNr = "#Feld_" + Id;
    var ButtonNr = "ButId" + Id;
    document.getElementById(ButtonNr).innerText = (document.querySelector(TextFeldNr).value);
}


function removeFirstChar(string) {
    let str1 = string;
    let result = str1.slice(1);
    return result;
}

var ButtonCount = 2; //Zählt wie viele Buttons erstellt wurden.

function erstellenButton() {

    //Button erstellen
    const btn = document.createElement("button");
    btn.innerHTML = "Hello Button";
    btn.setAttribute("id", "ButId" + ButtonCount);
    btn.setAttribute("class", "linkbutton");
    document.getElementById("previewbody").appendChild(btn);

    //Textfeld erstellen
    const btnT = document.createElement('input');
    btnT.type = 'text';
    btnT.setAttribute("id", "Feld_" + ButtonCount);
    btnT.setAttribute("class", "EditTextInput")
    document.getElementById("TextBereichGenerate").appendChild(btnT);

    var elem2 = document.getElementByClass(EditTextInput);
    elem2.addEventListener("change", function() {
            TextAnpassen("2");
        },
        false);
    /*var elem2 = document.getElementById("Feld_" + ButtonCount);
    elem2.addEventListener("change", function() {
            TextAnpassen("2");
        },
        false); */
    //ButtonCount hochzählen
    ButtonCount++;
}

//Daten aus Datenbank in CSS füllen 

var BackgroundColorData = "#" + "<?php echo ($SavedColors1[0]); ?>";
document.documentElement.style.setProperty('--kb-color-background', BackgroundColorData);
document.querySelector('#kb_selected_color_background').value = BackgroundColorData;

var ButtonColorData = "#" + "<?php echo ($SavedColors1[1]); ?>";
document.documentElement.style.setProperty('--kb-color-button', ButtonColorData);
document.querySelector('#kb_selected_color_button').value = ButtonColorData;

var HoverColorData = "#" + "<?php echo ($SavedColors1[2]); ?>";
document.documentElement.style.setProperty('--kb-color-hover', HoverColorData);
document.querySelector('#kb_selected_color_hover').value = HoverColorData;


//Daten an Server Senden
function VarSubmit(BackgroundColor, buttonInput, hoverInput) {
    window.location.href = "editor.php?backgroundInpute=" + BackgroundColor + "&buttonInput=" + buttonInput +
        "&hoverInput=" + hoverInput;
}
</script>


<style>
:root {
    --kb-color-background: #5395a7;
    --kb-color-button: silver;
    --kb-color-hover: green;
}

#editfield {
    display: flex;
    float: left;
}


#editbar {
    background-color: #252526;
    width: calc(100vw * 0.15);
    height: 100vh;
    color: white;
    margin-top: 100px;
    border-radius: 10px;
    border-color: #f4c700;
    border-style: solid;
    border-width: 2px;
    font-family: 'Rubik', sans-serif;
}

#EditBarTitle {
    font-size: 22px;
    font-family: 'Rubik', sans-serif;
    text-align: center;
}

.NavZwischenTittel {
    font-size: 18px;
    color: white;
    text-align: center;

}

.TrennBorder {
    margin-top: 30px;
    width: calc((100vw * 0.15) * 0.7);
    margin-left: calc(((100vw * 0.15) - (100vw * 0.15) * 0.7) / 2);
    border-style: none;
    border-color: #f4c700;
    border-radius: 5px;
    border-width: 2px;
    border-bottom-style: solid;
}

.EditTextInput {
    color: white;
    background-color: #333333;
    border-radius: 10px;
    height: 25px;
    width: calc((100vw * 0.15) * 0.8);
    border-style: solid;
    margin-left: calc(((100vw * 0.15) - (100vw * 0.15) * 0.8) / 2);
    margin-top: 10px;

}

.EditButtons {
    margin-top: 10px;
    color: white;
    background-color: #333333;
    border-radius: 50px;
    height: 30px;
    width: calc((100vw * 0.15) / 2);
    margin-left: calc(((100vw * 0.15) - ((100vw * 0.15) / 2)) / 2);

}

.EditBarAtributesText {
    margin-left: 30px;
}

.EditBarAtributes {
    text-align: left;
}

.PickerStyle {
    -webkit-appearence: none;
    -moz-appearance: none;
    appearance: none;
    border: none;
    background-color: transparent;
}

.PickerStyle::-webkit-color-swatch {
    border-radius: 15px;
    border: none;
}

.PickerStyle::-moz-color-swatch {
    border-radius: 15px;
    border: none;
}

#previewbody {
    text-align: center;
    color: black;
    background-color: var(--kb-color-background);
    width: calc(100vw * 0.6);
    border-radius: 50px;
    margin-top: 100px;
    margin-left: calc((100vw - (100vw * 0.9)) / 2);
    margin-right: calc((100vw - (100vw * 0.6)) / 2);
}

.iconsize {
    height: 50px;
    width: 50px;
}

h1 {
    font-size: 75px;
    font-family: arial;
}

#onlyfanstext {
    font-size: 30px;
}

.linkbutton {
    border: 10px none;
    border-radius: 100px;
    padding: 20px;
    background-color: var(--kb-color-button);
    margin-top: 27px;
    height: 128px;
    width: calc(90%);
    max-width: 900px;
    font-size: 75px;
    color: black;
    font-family: arial;
    text-decoration: none;
    transition: 0.2s;
}

.linkbutton:hover {
    background-color: var(--kb-color-hover);
    margin-top: 25px;
    height: 130px;
    width: calc(91%);
    max-width: 956px;
}

.profileborder {
    border-radius: 100%;
    border-style: solid;
    border-width: 2px;
    border-color: #396774;
}

.profilbildsize {
    width: 25%;
    height: 25%;
    max-width: 230px;
    max-height: 230px;
    margin-top: 15px;
}

.footertext {
    font-family: arial;
    font-size: 30px;
    text-decoration: none;
    color: black;
    margin-top: 50px;
}

.notfounderrortext {
    font-family: arial;
    font-size: 25px;
    color: black;
    text-decoration: none;
}
</style>

</html>