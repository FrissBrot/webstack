<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8" content="text/html">
    <link rel="stylesheet" type="text/css" href="style.css" media="screen" />
    <link rel="icon" href="pictures\favicon.gif" type="image/gif">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init();</script>
    <!-- Webstack -->
    <title>Webstack • Home</title>
    <div class="Navigate">
      <button class="NavigateFont" onclick="scrollToLogin(1)">LOGIN</button>
      <button class="NavigateFont marginleft30" onclick="scrollToLogin(2)">REGISTRIEREN</button>
    </div>
  </head>
  <body>
    <div class="WebstackStart">
      <div class="WebstackStartSchrift">
        <h1 class="WebstackH1"><span class="WebstackSpan">Webstack</span>.</h1>
      </div>
    </div>
    <div class="LoginPage">
      <div class="LoginWindow" id="LoginWindow">
        <div class="tab">
          <button class="tablinks" id="loginbutton" onclick="openCity(event, 'Login')">Login</button>
          <button class="tablinks marginleft30 " id="registrierenbutton"onclick="openCity(event, 'Registrieren')">Registrieren</button>
        </div>
        <div class="LoginTabs">
          <div id="Login" class="tabcontent">
            <h3>Login</h3>
            <p>Login is the capital city of England.</p>
          </div>

          <div id="Registrieren" class="tabcontent">
            <<?php
              if (isset($_POST["submit"])) {
                require("mysql.php");
                $stmt = $mysql->prepare("SELECT * FROM accounts WHERE USERNAME = :user"); //Username überprüfen
                $stmt->bindParam(":user", $_POST["username"]);
                $stmt->execute();
                $count = $stmt->rowCount();
                if($count == 0){
                  //Username ist frei
                  if($_POST["pw"] == $_POST["pw2"]){ //überprüfung ob beide Passwörter übereinstimmen.
                    //user Erstellen
                    $stmt = $mysql->prepare("INSERT INTO accounts (USERNAME, PASSWORD) VALUES (:user, :pw)")
                    $stmt->bindParam(":user", $_POST["username"]);
                    $hash = password_hash($_POST["pw"], PASSWORD_BCRYPT);
                    $stmt->bindParam(":pw", $hash);
                    $stmt->execute();
                    echo "Der Benutzer wurde angelegt.";
                  } else {
                    echo "Die Passwörter stimmen nicht überein";
                  }
                } else {
                  echo "Der Username ist bereits vergeben";
                }
              }
             ?>
            <h3>Registrieren</h3>
            <form action="register.php" method="post" class="FormStyle">
              <input type="email" name="email" placeholder="E-Mailadresse" required><br>
              <input type="text" name="user" placeholder="Benutzername" required><br>
              <input type="password" name="pw1" placeholder="Passwort" required><br>
              <input type="password" name="pw2" placeholder="Passwort bestätigen" required><br>
              <div class="FormularButton">
                <button type="submit" name="submit">Erstellen</button>
              </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  <footer>
  </footer>
  <script>
  function openCity(evt, cityName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

document.getElementById("loginbutton").click();

function scrollToLogin(mode){
  document.querySelector('#LoginWindow').scrollIntoView({behavior: 'smooth'});

  if (mode === 1) {
    openCity(event, 'Login');
    document.getElementById("loginbutton").click();
  } else {
    openCity(event, 'Registrieren');
    document.getElementById("registrierenbutton").click();
  }

}

  </script>
</html>
