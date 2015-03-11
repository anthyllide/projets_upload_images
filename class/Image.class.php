<?php
class Image {

	public function __construct () 
	{
	}
	
	/* Ouvre le répertoire où sont stockés les images, puis il les lit. Ensuite, tant que $entry est vraie,
	alors on crée un tableau associatif $images en récupérant les données title et description dans la table 
images 	*/
	
	public function getImages ()
	{
	$i=0;

	try 
		{
		$bdd = new PDO('mysql:host=localhost; dbname=projet_image', 'root', '');
		$bdd->exec("SET NAMES 'UTF8'");
		}
		catch (Exception $e)
		{
		die ('Erreur : '. $e -> getMessage());
		}
		
		$rep = $bdd -> query ('SELECT filename FROM images ');
		
		if ($rep == true)
		{
		
			while ($donnees = $rep -> fetch())
			{
			
		
				$images [$i] ['filename'] = $donnees ['filename'];
		
				$image_data = $this->getImageData($donnees ['filename']);
				
				$images [$i] ['title'] = $image_data['title'];
				$images [$i] ['description'] = $image_data['description'];
				$i++;
				
			}
		
			return $images;
		}
		else
		{
		$msg_error = 'Une erreur est survenue lors de la répération des données.';
		return $msg_error;
		}
	}
	
	// Insertion d'une image dans la table images
	public function insertImage ($title, $descr, $filename)
	{
		try 
		{
		$bdd = new PDO('mysql:host=localhost; dbname=projet_image', 'root', '');
		$bdd->exec("SET NAMES 'UTF8'");
		}
		catch (Exception $e)
		{
		die ('Erreur : '. $e -> getMessage());
		}
		
		$rep = $bdd -> prepare('INSERT INTO images (title,description,filename) VALUES (:title,:descr,:filename)');
		$rep -> execute(array(
							':title' => $title,
							':descr'=> $descr,
							':filename' => $filename
							)
						);
						
		$rep -> closeCursor();
		
		if ($rep == true)
		{
			return true;
		}
		else
		{
			$msg_error ='Une erreur est survenue lors de l\'insertion des données dans la base.';
			return $msg_error;
		}
	}
	
	// Récupère le title et la description d'une image à partir de son nom.jpg
	public function getImageData ($filename)
	{
		try 
		{
		$bdd = new PDO('mysql:host=localhost; dbname=projet_image', 'root', '');
		$bdd->exec("SET NAMES 'UTF8'");
		}
		catch (Exception $e)
		{
		die ('Erreur : '. $e -> getMessage());
		}
		
		$rep = $bdd -> prepare('SELECT * FROM images WHERE filename=?');
		$rep->execute(array($filename));
		
		if (!$rep)
		{
			$msg_error = 'Une erreur est survenue lors de la mise à jour des données.';
			return $msg_error;
		}
		else
		{
			$donnees = $rep -> fetch();
			
			$image_data ['id']=$donnees['id'];
			$image_data ['title']=$donnees['title'];
			$image_data ['description']=$donnees['description'];
			$image_data ['filename']=$donnees['filename'];
			
			return $image_data;
		}
	}

	//Si une image est déjà enregistrée dans la table image, cette méthode permet de modifier son contenu
	public function updateImageData ($title, $descr, $filename)
	{
	
		try 
		{
		$bdd = new PDO('mysql:host=localhost; dbname=projet_image', 'root', '');
		$bdd->exec("SET NAMES 'UTF8'");
		}
		catch (Exception $e)
		{
		die ('Erreur : '. $e -> getMessage());
		}
		
		
			$update_image = $bdd-> prepare('UPDATE images SET title=:title, description=:descr WHERE filename=:filename');
			$update_image -> execute(array(
										':title' => $title,
										':descr'=> $descr,
										':filename' => $filename
											));
			if ($update_image == true)
			{
				return true;
				$update_image -> closeCursor();
			}
			else
			{
				
				$table_error = $update_image->errorInfo();
				$msg_error = 'Une erreur est survenue lors de la mise à jour des données.';
				
				return $msg_error.' :'.$table_error [2];
				
			}
	}		
		public function upload($files)
		{
		$files = $_FILES['upload'];
		$filesError = $_FILES['upload']['error'];
		
			//verification si les fichiers sont bien uploadés
			foreach ($filesError as $key => $error)
			{
				
				if ($error['$key'] == 2)
				{
				$msg_error_weight = 'Le fichier dépasse 30Mo.';
				return $msg_error_weight;
				}
				elseif (!$error['$key'] == 0)
				{
				return false;
				}
			}
					
		//vérification extension
		$extension_autorisees = array (
									'jpg',
									'jpeg',
									'png',
									'gif'
									);
									
		$filesExtension = $_FILES['upload']['type'];
			
			foreach ($filesExtension as $key => $type)
			{
			$extension = basename($type);
			
			$result = in_array($extension, $extension_autorisees);
			
				if ($result == false)
				{
				$msg_error_extension = 'Format non accepté';
				return $msg_error_extension;
				}
				
			}
			
		//vérification dimensions images
		$images_tmp = $_FILES['upload']['tmp_name'];
			
		$maxwidth = 300;
		$maxheight = 400;
			
			foreach ($images_tmp as $key => $tmp)
			{
			$images_size = getimagesize($tmp);
			
				if(($images_size[0] > $maxwidth) OR ($images_size[1] > $maxheight))
				{
				$msg_error_size = 'Les dimensions de l\'image sont trop grandes.';
				return $msg_error_size;
				}
			
			}
		
		
		//Déplacer le fichier
		$upload_dir =IMAGE_DIR_PATH;
		$images_tmp = $_FILES['upload']['tmp_name'];
		$images_name = $_FILES['upload']['name'];
		
		print_r($_FILES['upload']);
		foreach ($images_tmp as $key => $tmp_name)
		{
			$name = $images_name [$key];
			
		    $moveImage = move_uploaded_file ($tmp_name, $upload_dir.'/'.$name);
			
				if ($moveImage == true)
				{
				$descr = '';
				$title = '';
				
				$insertImage = $this -> insertImage ($title, $descr, $name);
				
				}
			
		}
		
		
		}
		
			
	
}