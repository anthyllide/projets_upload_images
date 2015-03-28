<?php
class Image {

	public function __construct () 
	{
	}
	
	
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
				$path = IMAGE_DIR_PATH.$donnees['filename'];
				
				if (file_exists($path))
				{
		
				$images [$i] ['filename'] = $donnees ['filename'];
		
				$image_data = $this->getImageData($donnees ['filename']);
				
				$images [$i] ['title'] = $image_data['title'];
				$images [$i] ['description'] = $image_data['description'];
				$i++;
				}
				
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
	
	//créations des images miniatures
	public function createThumbnail ($filename)
	{
		$image = IMAGE_DIR_PATH.$filename;
		$vignette = THUMB_DIR_PATH.$filename;
		
		$image_type = exif_imagetype($image);
 
		
		if($image_type == IMAGETYPE_JPEG)
		{
		$source = imagecreatefromjpeg ($image);
		}
		elseif ($image_type == IMAGETYPE_PNG)
		{
		$source = imagecreatefrompng ($image);
		}
		elseif($image_type == IMAGETYPE_GIF)
		{
		imagegif($destination, $vignette);
		}
		
		$largeur_source = imagesx($source);
		$hauteur_source = imagesy($source);
		
		$largeur_destination_max = 200;
		$hauteur_destination_max = 150;
		
		//on vérifie que l'image source ne soit pas plus petite que l'image de destination
		if ($largeur_source > $largeur_destination_max || $hauteur_source > $hauteur_destination_max)
		{
				//la plus grande des dimensions est la référence
				if($hauteur_source <= $largeur_source)
				{
					$ratio = $largeur_destination_max / $largeur_source; 
				}
				else
				{
					$ratio = $hauteur_destination_max / $hauteur_source; 
				}
		}
		else
		{
			$ratio = 1;
		}
		
		$destination = imagecreatetruecolor(round($largeur_source*$ratio),round($hauteur_source*$ratio));
		
		//création de la vignette
		
		imagecopyresampled ($destination, $source, 0, 0 , 0, 0, round($largeur_source*$ratio),round($hauteur_source*$ratio), $largeur_source, $hauteur_source);
		
		if($image_type == IMAGETYPE_JPEG)
		{
		imagejpeg($destination, $vignette);
		}
		elseif($image_type == IMAGETYPE_PNG)
		{
		imagepng($destination, $vignette);
		}
		elseif($image_type == IMAGETYPE_GIF)
		{
		imagegif($destination, $vignette);
		}
	}
		
			
	
	// upload des serveurs dans le répertoires images du serveur, puis insertion dans la BDD
	public function upload($files)
	{
		
		print_r($files);
		
		foreach ($files ['tmp_name'] as $key => $tmp_name)
		{
		
		$type = $files ['type'][$key];
		$error = $files ['error'][$key];
		$name = $files ['name'][$key];
		
		$extension_autorisees = array (
									'jpg',
									'jpeg',
									'png',
									'gif'
									);
									
		$extension = basename($type);
		print_r($extension);
	
		
			if (in_array($extension, $extension_autorisees))
			{
			
				$images_size = getimagesize($tmp_name);
			
				if(($images_size[0] < MAX_WIDTH) OR ($images_size[1] < MAX_HEIGHT))
				{
					if ($error == 0) 
					{
					
						
					//Déplacer le fichier
					$upload_dir = IMAGE_DIR_PATH;
					
					$moveImage = move_uploaded_file ($tmp_name, $upload_dir.'/'.$name);
					
						if ($moveImage === true)
						{
				
						$descr = '';
						$title = '';
				
						$insertImage = $this -> insertImage ($title, $descr, $name);
						
							if ($insertImage == true)
							{
							$this-> createThumbnail ($name);
							$msg_success = true;
							continue;
							}
							else
							{
							$msg_error [$key]= 'L\'image n\'a pas pu être enregistrée.';
							continue;
							}
						}	
						else
						{
						$msg_error [$key] = 'L\'image n\'a pas pu être téléchargée.';
						continue;
						}
					
					}
					else
					{
					$msg_error [$key] = 'Une erreur s\'est produite lors du téléchargement.';
					continue;
					}
					
				}
				else
				{
				$msg_error [$key] = 'Les dimensions de l\'image sont trop grandes.';
				continue;
				}
			}
			else
			{
			$msg_error [$key] = 'Format non accepté';
			continue;
			}
		
		}
		
		if((isset($msg_success)) AND (isset($msg_error)))
		{
		return $msg_error ; //tableau des différentes erreurs
		}
		
		elseif (isset($msg_success))
		{
		return true; //renvoie true 
		}
		
		elseif (isset ($msg_error))
		{
		return $msg_error; //tableau des différentes erreurs
		}
		
	}
	
	
	
	
}