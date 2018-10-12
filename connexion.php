<?php session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', '');

if(isset($_POST['formconnexion'])) {
   $emailconnect = htmlspecialchars($_POST['emailconnect']);
   $mdpconnect = sha1($_POST['mdpconnect']);
   if(!empty($emailconnect) AND !empty($mdpconnect)) {
      $requser = $bdd->prepare("SELECT * FROM membres WHERE email = ? AND password = ?");
      $requser->execute(array($emailconnect, $mdpconnect));
      $userexist = $requser->rowCount();
      if($userexist == 1) 
      {
         $userinfo = $requser->fetch();
         $_SESSION['id'] = $userinfo['id'];
         $_SESSION['nickname'] = $userinfo['nickname'];
         $_SESSION['email'] = $userinfo['email'];
         header("Location: profil.php?id=".$_SESSION['id']);
      } 
      else 
      {
         $erreur = "Wrong email or password !";
      }
   } 
   else
   {
      $erreur = "All the fields must be filled !";
   }
   }  
   ?>  
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
               <br><br />
      <div align="center">
         <h2>Connexion</h2>
         <br /><br />
         <form method="POST" action="">
            <input type="text" name="emailconnect" placeholder="email" />
            <input type="password" name="mdpconnect" placeholder="password" />
            <br /><br />
            <input type="submit" name="formconnexion" value="Connect !" />
         </form>
         <?php
         if(isset($erreur)) 
         {  
            echo '<font color="red">'.$erreur."</font>";
         }
         ?>
      </div>
   </body>
</html>
