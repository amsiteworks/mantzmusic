<?php #Admin page to add images on mantzmusic.com
	require ('config.php');
	$page_title="Mantz Music - Add Image (Admin)";
	require(MYSQL);
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Main conditional
		$errors = array();
		
		if(!empty($_POST['image_name'])) { // Validate image name
			$in = trim($_POST['image_name']);
		} else {
			$errors[] = 'Please enter a name for the image';
		}
		
		if (is_uploaded_file($_FILES['image']['tmp_name'])) { // Check for successful upload
			$temp = '../../mantzmusic_imguploads/' . md5($_FILES['image']['name']);
			if (move_uploaded_file($_FILES['image']['tmp_name'], $temp)) {
				echo '<p>The file has successfully uploaded!</p>';
				$i = $_FILES['image']['name'];
			} else {
				$errors[] = 'The file could not be moved.';
				$temp = $_FILES['image']['tmp_name'];
			} 
		} else {
			$errors[] = 'No file file was uploaded';
			$temp = NULL;
		}
		
		$c = (!empty($_POST['caption'])) ? trim($_POST['caption']) : NULL; // Checks for an optional caption
		
		if (empty($errors)) {
			// Query to add image to database
			$q = 'INSERT INTO entity_images (image_caption, image_image, image_name) VALUES (?, ?, ?)';
			$stmt = mysqli_prepare($dbc, $q);
			mysqli_stmt_bind_param($stmt, 'sss', $c, $i, $in);
			mysqli_stmt_execute($stmt);
		
			// Verify addition to database
			if (mysqli_stmt_affected_rows($stmt) == 1) {
				echo '<p>The image has been added!</p>';
				$id = mysqli_stmt_insert_id($stmt); // Get image id
				rename ($temp, '../../mantzmusic_imguploads/$id');
				$_POST = array(); // Clears the POST array
			} else {
				echo '<p style="color: #c00">Your image could not be processed due to a system error.</p>';
			}
			
			mysqli_stmt_close($stmt);
		} // End errors conditional
		if (isset($temp) && file_exists($temp) && is_file($temp)) { // Delete temporary file
			unlink ($temp);
		}
	} // End Main Conditional
	
	if (!empty($errors) && is_array($errors)) {
		echo '<h1>Error!</h1><p style="color: #c00">The following error(s) occured:<br />';
		foreach ($errors as $msg) {
			echo " - $msg<br />\n";
		}
		echo 'Please reselect the image and try again.</p>';
	}
?>
<h1>Add Image</h1>
<form enctype="multipart/form-data" action="add_image.php" method="post">
	<input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
    <fieldset><legend>Please enter the following information:</legend>
    <p><b>Image Name:</b><input type="text" name="image_name" size="30" maxlength="45" value="<?php if(isset($_POST['image_name'])) echo htmlspecialchars($_POST['image_name']); ?>" /></p>
    <p><b>Image:</b><input type="file" name="image" /></p>
    <p><b>Caption:</b> <textarea name="caption" cols="50" rows="5"><?php if(isset($_POST['caption'])) echo $_POST['caption'];?></textarea>(optional)</p>
    </fieldset>
    <input type="submit" name="submit" value="Submit" />
</form>
