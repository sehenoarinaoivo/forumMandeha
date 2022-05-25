<?php
//Cette page permet de modifier l'ordre des categories
include('config.php');
if(isset($_GET['id'], $_GET['action']) and ($_GET['action']=='up' or $_GET['action']=='down'))
{
$id = intval($_GET['id']);
$action = $_GET['action'];
$dn1 = mysqli_fetch_array(mysqli_query($conn,'select count(c.id) as nb1, c.position, count(c2.id) as nb2 from categories as c, categories as c2 where c.id="'.$id.'" group by c.id'));
if($dn1['nb1']>0)
{
if(isset($_SESSION['username']) and $_SESSION['username']==$admin)
{
	if($action=='up')
	{
		if($dn1['position']>1)
		{
			if(mysqli_query('update categories as c, categories as c2 set c.position=c.position-1, c2.position=c2.position+1 where c.id="'.$id.'" and c2.position=c.position-1'))
			{
				header('Location: '.$url_home);
			}
			else
			{
				echo 'Une erreur s\'est produite lors du déplacement de la catégorie.';
			}
		}
		else
		{
			echo '<h2>L\'action que vous désirez effectuer est impossible.</h2>';
		}
	}
	else
	{
		if($dn1['position']<$dn1['nb2'])
		{
			if(mysqli_query($conn,'update categories as c, categories as c2 set c.position=c.position+1, c2.position=c2.position-1 where c.id="'.$id.'" and c2.position=c.position+1'))
			{
				header('Location: '.$url_home);
			}
			else
			{
				echo 'Une erreur s\'est produite lors du déplacement de la catégorie.';
			}
		}
		else
		{
			echo '<h2>L\'action que vous désirez effectuer est impossible.</h2>';
		}
	}
}
else
{
	echo '<h2>Vous devez être connecté en tant qu\'administrateur pour accéder à cette page: <a href="login.php">Connexion</a> - <a href="signup.php">Inscription</a></h2>';
}
}
else
{
	echo '<h2>La catégorie que vous désirez déplacer n\'existe pas.</h2>';
}
}
else
{
	echo '<h2>L\'identifiant de la catégorie ou la direction du déplacement ne sont pas définis.</h2>';
}
?>