<?php
// connect to the database
$conn = mysqli_connect('localhost:3306', 'root', '???', '');
$sql = "SELECT * FROM files";
$result = mysqli_query($conn, $sql);

// $files = mysqli_fetch_all($result, MYSQLI_ASSOC);
// Uploads files
if (isset($_POST['save'])) { // if save button on the form is clicked
    // name of the uploaded file
    $filename = $_FILES['myfile']['name'];
    $expiry = $_POST['expiryDate'];

    // destination of the file on the server
    $destination = 'uploads/' . $filename;

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];
    
    if (!in_array($extension, ['html', 'pdf', 'docx', 'txt'])) {
        echo "<p style='color:red; padding-top:50px; margin-left:180px'>" . "Your file extension must be .html, .pdf, .docx or .txt" . "</p>";
    } elseif ($_FILES['myfile']['size'] > 1000000) { // file shouldn't be larger than 1Megabyte
        echo "<p style='color:red; padding-top:50px; margin-left:235px'>" . "File too large." . "</p>";
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO files (name, size, downloads, expiryDate) VALUES ('$filename', '$size', 0, '$expiry')";
            if (mysqli_query($conn, $sql)) {
            echo "<p style='color:green; padding-top:50px; margin-left:235px'>" . "File uploaded successfully." . "</p>";
            }
        } else {
            echo "<p style='color:red; padding-top:50px; margin-left:235px'>" . "Failed to upload file." . "</p>";
        }
    }
}
/* Downloads files
if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];

    // fetch file to download from database
    $sql = "SELECT * FROM files WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'uploads/' . $file['name'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('uploads/' . $file['name']));
        readfile('uploads/' . $file['name']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE files SET downloads=$newCount WHERE id=$id";
        mysqli_query($conn, $updateQuery);
        exit;
    }

}*/