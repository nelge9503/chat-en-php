<?php
$id = mysqli_connect("127.0.0.1:3307","root","","chat");
if(isset($_POST["bout"])){
    if(!isset($_POST["nom"]) || $_POST["nom"]==""){
        $erreur1 = "Message anonyme, Entrez votre nom.";
    }
    if(!isset($_POST["message"]) || $_POST["message"]==""){
        $erreur2 = "Veuillez entrer votre message!.";
    }
    if(isset($_POST["nom"]) && $_POST["nom"]!="" && isset($_POST["message"]) && $_POST["message"]!=""){
        $nom = mysqli_real_escape_string($id,$_POST["nom"]);
        $message = mysqli_real_escape_string($id,$_POST["message"]);
        $req = "insert into messages values (null, '$nom','$message',now())";
        mysqli_query($id,$req);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="container">
        <header>
            <h1> Salut <?=$_SESSION["pseudo"]?> Chattez'en direct! Chatbox</h1>
        </header>
        <div class="messages">
            <ul>
                <?php
                
                $req = "select * from messages order by date desc";
                $res = mysqli_query($id, $req);
                while($ligne = mysqli_fetch_assoc($res)){ 
                echo "<li class='message'>".$ligne["date"]." - " 
                                            .$ligne["pseudo"]." - "
                                            . $ligne["message"].". </li>";
                }
                ?>
            </ul>
        </div>
        <?php if(isset($erreur1)) echo "<div class='erreur'>$erreur1</div>";?>
        <?php if(isset($erreur2)) echo "<div class='erreur'>$erreur2</div>";?>
        <div class="formu">
            <form action="" method="post">
                <input type="text" name="nom" placeholder="Entrez votre nom :">
                <input type="text" name="message" placeholder="Entrez votre message :">
                <select name="" id="">
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
               </select>              
                <br>
                <input class="bout" type="submit" value="Envoyer" name="bout">
            </form>
            <form onsubmit="return sendMessage();">
  <input id="message" placeholder="Enter message">
  <input type="submit">
</form>
 
<ul id="messages"></ul>
     
<script>
    function sendMessage() {
        
        var message = document.getElementById("message").value;
 
        /
        io.emit("send_message", {
          sender: sender,
          receiver: receiver,
          message: message
        });
 
        
        var html = "";
        html += "<li>You said: " + message + "</li>";
 
        document.getElementById("messages").innerHTML += html;
 
        return false;
    }
 
   
    io.on("new_message", function (data) {
        var html = "";
        html += "<li>" + data.sender + " says: " + data.message + "</li>";
 
        document.getElementById("messages").innerHTML += html;
    });
</script>
        </div>
    </div>
</body>
</html>