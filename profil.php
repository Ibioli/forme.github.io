<?php session_start();


$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', '');

if(isset($_GET['id']) AND $_GET['id'] > 0) {
   $getid = intval($_GET['id']);
   $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();
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

      <div>
         <h2>Profil of <?php echo $userinfo['nickname']; ?></h2>
         <br /><br />
         nickname = <?php echo $userinfo['nickname']; ?>
         <br />
         email = <?php echo $userinfo['email']; ?>
         <br />
         <?php
         if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) {
         ?>
         <br />
         <a href="editionprofil.php">Edit my profil</a>
         <a href="deconnexion.php">Log out</a>
         <?php
         }
         ?>
      </div>
   </body>
</html>
