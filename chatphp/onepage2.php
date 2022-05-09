<?php 
session_start();
if(isset($_post["bout"]))
{
    include "connexion.php";
    $login = mysqli_real_escape_string($id,$_POST["login"]);
    $mdp = mysqli_real_escape_string($id,$_POST["mdp"]);
    mysqli_query($id, "SET NAMES 'utf8'");
    $requete = "select * from users
                where pseudo = '$login'
                and mdp='$mdp'";

    $reponse = mysqli_query($id, $requete); 
    if(mysqli_num_rows($reponse)>0){
        $_SESSION["log"] = $login;
        header("location : chat.php");
    }else{
        $erreur = "Erreur, veuillez reessayer";
    }
?>

</body>
</html>