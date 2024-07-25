<?php

// Function to sanitize file names
function sanitizeFileName($filename)
{
    return preg_replace('/[^a-zA-Z0-9\._-]/', '_', $filename);
}

// Function to validate image files
function isValidImage($file)
{
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    return in_array($file['type'], $allowedTypes);
}

if (is_array($_FILES)) {
    if (is_uploaded_file($_FILES['userImage']['tmp_name'])) {
        if (isValidImage($_FILES['userImage'])) {
            $sourcePath = $_FILES['userImage']['tmp_name'];
            $targetPath = "asset/photo/" . sanitizeFileName($_FILES['userImage']['name']);
            if (move_uploaded_file($sourcePath, $targetPath)) {
?>
                <img class="image-preview" src="<?php echo $targetPath; ?>" class="upload-preview" />
<?php
            } else {
                echo "Failed to move uploaded file.";
            }
        } else {
            echo "Invalid file type. Only JPG, PNG, and GIF files are allowed.";
        }
    } else {
        echo "No file was uploaded.";
    }
}

?>