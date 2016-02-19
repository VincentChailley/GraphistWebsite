<?php
/* Si le formulaire est envoyé alors on fait les traitements */
if (isset($_POST['envoye']))
{
    /* Récupération des valeurs des champs du formulaire */
    if (get_magic_quotes_gpc())
    {
      $civilite		= stripslashes(trim($_POST['civilite']));
      $nom	     	= stripslashes(trim($_POST['nom']));
      $expediteur	= stripslashes(trim($_POST['email']));
      $sujet		= stripslashes(trim($_POST['sujet']));
      $message		= stripslashes(trim($_POST['message']));
    }
    else
    {
      $civilite		= trim($_POST['civilite']);
      $nom		    = trim($_POST['nom']);
      $expediteur	= trim($_POST['email']);
      $sujet		= trim($_POST['sujet']);
      $message		= trim($_POST['message']);
    }
 
    /* Expression régulière permettant de vérifier si le 
    * format d'une adresse e-mail est correct */
    $regex_mail = '/^[-+.\w]{1,64}@[-.\w]{1,64}\.[-.\w]{2,6}$/i';
 
    /* Expression régulière permettant de vérifier qu'aucun 
    * en-tête n'est inséré dans nos champs */
    $regex_head = '/[\n\r]/';
 
    /* Si le formulaire n'est pas posté de notre site on renvoie 
    * vers la page d'accueil */
    if($_SERVER['HTTP_REFERER'] != 'http://www.monsite.com/send_email.php')
    {
      header('Location: http://www.monsite.com/');
    }
    /* On vérifie que tous les champs sont remplis */
    elseif (empty($civilite) 
           || empty($nom) 
           || empty($expediteur) 
           || empty($sujet) 
           || empty($message))
    {
      $alert = 'Tous les champs doivent être renseignés';
    }
    /* On vérifie que le format de l'e-mail est correct */
    elseif (!preg_match($regex_mail, $expediteur))
    {
      $alert = 'L\'adresse '.$expediteur.' n\'est pas valide';
    }
    /* On vérifie qu'il n'y a aucun header dans les champs */
    elseif (preg_match($regex_head, $expediteur) 
            || preg_match($regex_head, $nom) 
            || preg_match($regex_head, $sujet))
    {
        $alert = 'En-têtes interdites dans les champs du formulaire';
    }
    /* Si aucun problème et aucun cookie créé, on construit le message et on envoie l'e-mail */
    elseif (!isset($_COOKIE['sent']))
    {
        /* Destinataire (votre adresse e-mail) */
        $to = 'vchailley@gmail.com';
 
        /* Construction du message */
        $msg  = 'Bonjour,'."\r\n\r\n";
        $msg .= 'Ce mail a été envoyé depuis monsite.com par '.$civilite.' '.$nom."\r\n\r\n";
        $msg .= 'Voici le message qui vous est adressé :'."\r\n";
        $msg .= '***************************'."\r\n";
        $msg .= $message."\r\n";
        $msg .= '***************************'."\r\n";
 
        /* En-têtes de l'e-mail */
        $headers = 'From: '.$nom.' <'.$expediteur.'>'."\r\n\r\n";
 
        /* Envoi de l'e-mail */
        if (mail($to, $sujet, $msg, $headers))
        {
            $alert = 'E-mail envoyé avec succès';
 
            /* On créé un cookie de courte durée (ici 120 secondes) pour éviter de 
            * renvoyer un mail en rafraichissant la page */
            setcookie("sent", "1", time() + 120);
 
            /* On détruit la variable $_POST */
            unset($_POST);
        }
        else
        {
            $alert = 'Erreur d\'envoi de l\'e-mail';
        }
 
    }
    /* Cas où le cookie est créé et que la page est rafraichie, on détruit la variable $_POST */
    else
    {
        unset($_POST);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Aurélie Marcuard</title>
<link rel="icon" type="image/png" href="IMG/logo.png" />
<link href='http://fonts.googleapis.com/css?family=Libre+Baskerville:400italic' rel='stylesheet' type='text/css'>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
	$(document).ready(function(){
    	$(".logo").click(function(){
			$(".vague").delay(1000).animate({left:'2000'},1500);
			$(".menu").delay(1000).slideDown("slow");
			$('.logo').addClass('logostand').removeClass('logo');
			$('#page0').delay(1500).fadeIn(1000);
			
			$('.menu-vertical li').click(function(){
 			var index = $(".menu-vertical li").index(this);
    		for (var i=0; i<12; i++)
  			{
   			if (i!=index){
			$('#page'+i).hide();
  			}
  			}
			$('#page'+index).show();
 			return i;
			});
			
			$('body').append('<a href="#top" class="top_link" title="Revenir en haut de page">Haut</a>');
			$('.top_link').css({
				'position':'fixed',
				'left':'30px',
				'bottom'	:'30px',
				'display':'none',
				'padding':'20px',
				'color':'blue',
				
				'border':'solid 2px blue',
				'opacity':'0.9',
				'z-index':'2000'
			});
			$(window).scroll(function(){
				posScroll = $(document).scrollTop();
				if(posScroll >=550) 
				$('.top_link').fadeIn(600);
				else
				$('.top_link').fadeOut(600);
			});
			
			$("#pic1").click(function(){
			$("#page1").show();
			$("#page0").hide();
    		});
			$("#pic2").click(function(){
			$("#page2").show();
			$("#page0").hide();
    		});
			$("#pic3").click(function(){
			$("#page3").show();
			$("#page0").hide();
    		});
			$("#pic4").click(function(){
			$("#page4").show();
			$("#page0").hide();
    		});
			$("#pic5").click(function(){
			$("#page5").show();
			$("#page0").hide();
    		});
			$("#pic6").click(function(){
			$("#page6").show();
			$("#page0").hide();
    		});
			$("#pic7").click(function(){
			$("#page7").show();
			$("#page0").hide();
    		});
			$("#pic8").click(function(){
			$("#page8").show();
			$("#page0").hide();
    		});
			$("#pic9").click(function(){
			$("#page9").show();
			$("#page0").hide();
    		});
		});
	});
	
</script>

</head>
<!---->
<body>
	<div class="logo">
		<img class="imglogo" src="IMG/logo2.png"/>
        <h1>Aurélie Marcuard</h1>
    </div>
	<div class="content">
	<div class='menu'>
		<ul class="menu-vertical">
       		<div class='vague'><img src='IMG/grandevague.png'></div>		
			<li class="mv-item"><a id="popup1"><h2>Works</h2></a></li>
			<li class="mv-item"><a id="popup2">- B42</a></li>
			<li class="mv-item"><a id="popup3">- Duos d'alice</a></li>
			<li class="mv-item"><a id="popup4">- Essences par </br>&nbsp;&nbsp;&nbsp;Lancôme</a></li>
			<li class="mv-item"><a id="popup5">- 24h du temps</a></li>
			<li class="mv-item"><a id="popup6">- Promenade pour </br>&nbsp;&nbsp;&nbsp;un objet d'exception</a></li>
			<li class="mv-item"><a id="popup7">- Sava Eskimo S3</a></li>
			<li class="mv-item"><a id="popup8">- Yes!*</a></li>
			<li class="mv-item"><a id="popup9">- Rapport de stage</a></li>
			<li class="mv-item"><a id="popup10">- Croquis</a></li>
            </br>
			<div class='vague'> <img src='IMG/grandevague.png'></div>
			<li class="mv-item"><a class=popup11><h2>About me</h2></a></li>
			<div class='vague'> <img src='IMG/grandevague.png'></div>
			<li class="mv-item"><a class=popup12><h2>Contact</h2></a></li>
		</ul>
	</div>
    </div>
    <!---->
    <div class='conteneur' id="page0">
	<div class="work"> 
    	<div class="lightness" id="pic1"> 
			<div class="text">
            	</br>
                </br>
    			<h5>B42</h5>
                Édition
            </div> 
		</div>
        <div class="lightness" id="pic2"> 
			<div class="text"> 
            	</br>
                </br>
    			<h5>Duos d'Alice</h5>
                Packaging
            </div> 
		</div>
        <div class="lightness" id="pic3"> 
			<div class="text">
            	</br>
                </br>
    			<h5>Essences par Lancôme</h5>
                Packaging
            </div> 
		</div>
    </div>
    <div class="work"> 
    	<div class="lightness" id="pic4"> 
			<div class="text"> 
            	</br>
                </br>
    			<h5>24H du temps</h5>
                Communication événementielle
            </div> 
		</div>
        <div class="lightness" id="pic5"> 
			<div class="text">
            	</br>
    			<h5>Promenade pour</br> un objet d'exception</h5> 
                Communication événementielle
            </div> 
		</div>
        <div class="lightness" id="pic6"> 
			<div class="text"> 
            	</br>
                </br>
    			<h5>Sava Eskimo S3</h5>
                Publicité, Croquis
            </div> 
		</div>
    </div>
    <div class="work"> 
    	<div class="lightness" id="pic7"> 
			<div class="text">
            	</br>
                </br> 
    			<h5>YES!*</h5>
                Édition (Work in progress)
            </div> 
		</div>
        <div class="lightness" id="pic8"> 
			<div class="text"> 
            	</br>
                </br>
   		 		<h5>Rapport de stage</h5>
                Édition (Work in progress)
    		</div> 
		</div>
        <div class="lightness" id="pic9"> 
			<div class="text"> 
            	</br>
                </br>
                </br>
    			<h5>Croquis</h5>
            </div> 
		</div>
    </div>
    </div>
	<div class='conteneur' id="page1">
     <img src="CONTENU/B42.png"/>
    </div>
    <div class='conteneur' id="page2">
     <img src="CONTENU/DUOS.png"/>
    </div>
    <div class='conteneur' id="page3">
     <img src="CONTENU/PROJETPRO.png"/>
    </div>
    <div class='conteneur' id="page4">
     <img src="CONTENU/24H.png"/>
    </div>
    <div class='conteneur' id="page5">
     <img src="CONTENU/PROMENADE.png"/>
    </div>
    <div class='conteneur' id="page6">
     <img src="CONTENU/SAVAESKIMO.png"/>
    </div>
    <div class='conteneur' id="page7">
     <img src="CONTENU/YES.png"/>
    </div>
    <div class='conteneur' id="page8">
     <img src="CONTENU/rapportstage.png"/>
    </div>
    <div class='conteneur' id="page9">
     <img src="CONTENU/CROQUIS.png"/>
    </div>
    <div class='conteneur' id="page10">
     <h3><a href="CONTENU/CV.pdf">Télécharger au format PDF</a></h3>
     <img src="CONTENU/cv.png"/>
    </div>
    <div class='conteneur' id="page11">
    	<?php
if (!empty($alert))
{
    echo '<p style="color:red">'.$alert.'</p>';
}
?>
 
<form action="send_email.php" method="post">
    <p>
        <label for="civilite">Civilité :</label>
        <select id="civilite" name="civilite">
            <option 
                value="mr"
                <?php 
                    if (!isset($_POST['civilite']) || $_POST['civilite'] == 'mr')
                    {
                        echo ' selected="selected"';
                    }
                ?>
            >
                Monsieur
            </option>
            <option 
                value="mme"
                <?php 
                    if (isset($_POST['civilite']) && $_POST['civilite'] == 'mme')
                    {
                        echo ' selected="selected"';
                    }
                ?>
            >
                Madame
            </option>
            <option 
                value="mlle"
                <?php 
                    if (isset($_POST['civilite']) && $_POST['civilite'] == 'mlle')
                    {
                        echo ' selected="selected"';
                    }
                ?>
            >
                Mademoiselle
            </option>
        </select>
    </p>
    <p>
        <label for="nom">Nom/Prénom :</label>
        <input type="text" id="nom" name="nom" 
        	value="<?php echo (isset($_POST['nom'])) ? $nom : '' ?>" 
        />
    </p>
    <p>
        <label for="email">E-mail :</label>
        <input type="text" id="email" name="email" 
        	value="<?php echo (isset($_POST['email'])) ? $expediteur : '' ?>"
        />
    </p>
    <p>
        <label for="sujet">Sujet :</label>
        <input type="text" id="sujet" name="sujet" 
        	value="<?php echo (isset($_POST['sujet'])) ? $sujet : '' ?>"
        />
    </p>
    <p>
        <label for="message">Message :</label>
        <textarea id="message" name="message" cols="40" rows="4">
			<?php echo (isset($_POST['message'])) ? $message : '' ?>
        </textarea>
    </p>
    <p>
        <input type="submit" name="envoye" value="Envoyer" />
    </p>
</form>
 
    </div>
    	
    </div>
</body>
</html>