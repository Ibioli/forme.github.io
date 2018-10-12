<?php include_once 'function.php';

class addPost{
    
    private $subject;
    private $nickname;
    private $bdd;
    
    public function __construct($nickname,$subject) {
        
        
        $this->subject = htmlspecialchars($subject);
        $this->nickname = htmlspecialchars($nickname);
        $this->bdd = bdd();
        
    }
    
    
    public function verif(){
        
           if(strlen($this->subject) > 0){ /*Si on a bien un sujet*/
                
                return 'ok';
            }
            else {/*Si on a pas de contenu*/
                $erreur = 'Please write the content';
                return $erreur;
            }
            
      
        
    }
    
    public function insert(){
       
        
        $requete2 = $this->bdd->prepare('INSERT INTO postSujet(propri,content,date,subject) VALUES(:propri,:content,NOW(),:subject)');
        $requete2->execute(array('propri'=>$_SESSION['id'],'content'=>  $this->sujet,'subject'=>  $this->nickname));
        
        return 1;
    }
    
}