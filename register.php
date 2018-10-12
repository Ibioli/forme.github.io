<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', '');

if(isset($_POST['forminscription'])) {
   $nickname = htmlspecialchars($_POST['nickname']);
   $email = htmlspecialchars($_POST['email']);
   $email2 = htmlspecialchars($_POST['email2']);
   $mdp = sha1($_POST['mdp']);
   $mdp2 = sha1($_POST['mdp2']);
   if(!empty($_POST['nickname']) AND !empty($_POST['email']) AND !empty($_POST['email2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
      $nicknamelength = strlen($nickname);
      if($nicknamelength <= 255) {
         if($email == $email2) {
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
               $reqemail = $bdd->prepare("SELECT * FROM membres WHERE email = ?");
               $reqemail->execute(array($email));
               $emailexist = $reqemail->rowCount();
               if($emailexist == 0) {
                  if($mdp == $mdp2) {
                     $insertmbr = $bdd->prepare("INSERT INTO membres(nickname, email, password) VALUES(?, ?, ?)");
                     $insertmbr->execute(array($nickname, $email, $mdp));
                     $erreur = "Your account has been created ! <a href=\"connexion.php\">Connect</a>";
                  } else {
                     $erreur = "Your passwords do not match !";
                  }
               } else {
                  $erreur = "Email already exist !";
               }
            } else {
               $erreur = "Invalid email !";
            }
         } else {
            $erreur = "Your emails do not match !";
         }
      } else {
         $erreur = "Your nickname must not exceed 255 characters !";
      }
   } else {
      $erreur = "All fields must be filled !";
   }
}
?>
<!DOCTYPE html>
<html>
   <head>
      <title>Parasitology</title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="assets/css/main.css" />
   </head>
   <body>

      <body class="landing">
 
         <div id="page-wrapper">
          <header id="header" class="alt">
               <h1><a href="index.php"</a></h1>
                   <img src="images/logo.png">
                  <nav id="nav">
                     <ul>
                        <li class="special">
                           <a href="#menu" class="menuToggle"><span>Menu</span></a>
                           <div id="menu">
                              <ul>
                                 <li><a href="index.php">Home</a></li>
                                 <li><a href="REJOIGNIEZ-NOUS.html">Modules of the first semester</a></li>
                                 <li><a href="QUI SOMMES-NOUS.html">Chat</a></li>
                                 <li><a href="CONTACTEZ-NOUS.html">Contact us</a></li>
                                 <li><a href="profil.php">Profil</a></li>
                                 <li><a href="deconnexion.php">Log out</a></li>
                              </ul>
                           </div>
                        </li>
                     </ul>
                  </nav>
               </header>

      <div align="center">
         <h2>Register</h2>
         <br /><br />
         <form method="POST" action="">
            <table>
               <tr>
                  <td align="right">
                     <label for="nickname">Nickname</label>
                  </td>
                  <td>
                     <input type="text" placeholder="your nickname" id="nickname" name="nickname" value="<?php if(isset($nickname)) { echo $nickname; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="email">Email :</label>
                  </td>
                  <td>
                     <input type="email" placeholder="your email" id="email" name="email" value="<?php if(isset($email)) { echo $email; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="email2">Confirm your email :</label>
                  </td>
                  <td>
                     <input type="email" placeholder="Confirm your mail" id="email2" name="email2" value="<?php if(isset($email2)) { echo $email2; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="mdp">Password :</label>
                  </td>
                  <td>
                     <input type="password" placeholder="your password" id="mdp" name="mdp" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="mdp2">Confirm your password :</label>
                  </td>
                  <td>
                     <input type="password" placeholder="Confirm your password" id="mdp2" name="mdp2" />
                  </td>
               </tr>
               <tr>
                  <td></td>
                  <td align="center">
                     <br />
                     <input type="submit" name="forminscription" value="I register" />
                  </td>
               </tr>
            </table>
         </form>
         <?php
         if(isset($erreur)) {
            echo '<font color="red">'.$erreur."</font>";
         }
         ?>
      </div>
   </body>
</html>