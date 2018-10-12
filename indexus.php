<?php session_start();
include_once 'function/function.php';
include_once 'function/addPost.class.php';
$bdd = bdd();

if(!isset($_SESSION['id'])){

    header('Location: register.php');
}
else {
    
    if(isset($_POST['nickname']) AND isset($_POST['subject'])){
    
    $addPost = new addPost($_POST['nickname'],$_POST['subject']);
    $verif = $addPost->verif();
    if($verif == "ok"){
        if($addPost->insert()){
            
        }
    }
    else {/*Si on a une erreur*/
        $erreur = $verif;
    }
    
}
    
    
    ?>
<!DOCTYPE html>
<head>
    <meta charset='utf-8' />
    <title>Forum </title>
    
    <meta name="author" content="Thibault Neveu"> 
    <link rel="stylesheet" type="text/css" href="css/general.css" />
    <link rel="shortcut icon" href="images/favicon.ico" />
    <link href='http://fonts.googleapis.com/css?family=Karla' rel='stylesheet' type='text/css'>
<head>
<body>
 <h1>Welcome to parasitology forum</h1>
    
            <div id="Cforum">
                <?php 
                
                 echo 'Welcome: '.$_SESSION['nickname'].' :) - <a href="deconnexion.php">Log out</a> ';
                if(isset($_GET['category'])){ /*SI on est dans une categorie*/
                    $_GET['category'] = htmlspecialchars($_GET['category']);
                    ?>
                    <div class="categories">
                      <h1><?php echo $_GET['category']; ?></h1>
                    </div>
                <a href="addSujet.php?category=<?php echo $_GET['category']; ?>">Add a subject</a>
                <?php 
                $requete = $bdd->prepare('SELECT * FROM sujet WHERE category = :category ');
                $requete->execute(array('category'=>$_GET['category']));
                while($reponse = $requete->fetch()){
                    ?>
                     <div class="categories">
                         <a href="index.php?subject=<?php echo $reponse['nickname'] ?>"><h1><?php echo $reponse['nickname'] ?></h1></a>
                    </div>
                    <?php
                }
                ?>
                
                    
                    <?php
                }
                
                else if(isset($_GET['subject'])){ /*SI on est dans une categorie*/
                    $_GET['subject'] = htmlspecialchars($_GET['subject']);
                    ?>
                    <div class="categories">
                      <h1><?php echo $_GET['subject']; ?></h1>
                    </div>
                
                <?php 
                $requete = $bdd->prepare('SELECT * FROM postSujet WHERE subject = :subject ');
                $requete->execute(array('subject'=>$_GET['subject']));
                while($reponse = $requete->fetch()){
                    ?>
                <div class="post">
                    <?php 
                     $requete2 = $bdd->prepare('SELECT * FROM membres WHERE id = :id');
                     $requete2->execute(array('id'=>$reponse['propri']));
                     $membres = $requete2->fetch();
                     echo $membres['nickname']; echo ': <br>';
                     
                     echo $reponse['content'];
                    ?>
                 </div> 
                <?php
                   
                }
                ?>
                
                 <form method="post" action="index.php?subject=<?php echo $_GET['subject']; ?>">
                        <textarea name="subject" placeholder="Your message..." ></textarea>
                        <input type="hidden" name="nickname" value="<?php echo $_GET['subject']; ?>" />
                        <input type="submit" value="Add to conversation" />
                        <?php 
                        if(isset($erreur)){
                            echo $erreur;
                        }
                        ?>
                    </form>
                <?php
                }
                else { /*Si on est sur la page normal*/
                    
                       
                
                        $requete = $bdd->query('SELECT * FROM categories');
                        while($reponse = $requete->fetch()){
                        ?>
                            <div class="categories">
                                <a href="index.php?category=<?php echo $reponse['nickname']; ?>"><?php echo $reponse['nickname']; ?></a>
                              </div>
                
                    <?php 
                    }
                    
                }
                 ?>
                
                
                
                
                
            </div>
</body>
</html>
    <?php
}
?>
