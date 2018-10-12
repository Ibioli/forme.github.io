<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', '');

if(isset($_SESSION['id'])) {
   $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
   $requser->execute(array($_SESSION['id']));
   $user = $requser->fetch();
   if(isset($_POST['newnickname']) AND !empty($_POST['newnickname']) AND $_POST['newnickname'] != $user['nickname']) {
      $newnickname = htmlspecialchars($_POST['newnickname']);
      $insertnickname = $bdd->prepare("UPDATE membres SET nickname = ? WHERE id = ?");
      $insertnickname->execute(array($newnickname, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }
   if(isset($_POST['newemail']) AND !empty($_POST['newemail']) AND $_POST['newemail'] != $user['email']) {
      $newemail = htmlspecialchars($_POST['newmail']);
      $insertemail = $bdd->prepare("UPDATE membres SET email = ? WHERE id = ?");
      $insertemail->execute(array($newemail, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }
   if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
      $mdp1 = sha1($_POST['newmdp1']);
      $mdp2 = sha1($_POST['newmdp2']);
      if($mdp1 == $mdp2) {
         $insertmdp = $bdd->prepare("UPDATE membres SET password = ? WHERE id = ?");
         $insertmdp->execute(array($mdp1, $_SESSION['id']));
         header('Location: profil.php?id='.$_SESSION['id']);
      } else {
         $msg = "Your passwords do not match !";
      }
   }
?>
<html>
   <head>
      <title>Parasitology</title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="assets/css/mainus.css" />
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

         <h2>Edit my profil</h2>
         <div align="left">
            <form method="POST" action="" enctype="multipart/form-data">
               <label>Nickname:</label>
               <input type="text" name="newnickname" placeholder="nickname" value="<?php echo $user['nickname']; ?>" /><br /><br />
               <label>Email :</label>
               <input type="text" name="newemail" placeholder="email" value="<?php echo $user['email']; ?>" /><br /><br />
               <label>Password :</label>
               <input type="password" name="newmdp1" placeholder="password"/><br /><br />
               <label>Confirm your password :</label>
               <input type="password" name="newmdp2" placeholder="Confirmation du mot de passe" /><br /><br />
               <label>Profile photo:</label>
               <input type="File" name="profile"><br /><br />
               <input type="submit" value="Update my profil !" />
               <label>Profile photo:</label>
               <input type="File" name="profile">
            </form>
            <?php if(isset($msg)) { echo $msg; } ?>
         </div>
      </div>
   </body>
</html>
<?php   
}
else {
   header("Location: connexion.php");
}
?>