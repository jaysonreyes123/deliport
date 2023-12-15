<?php
$upload_folder = 'upload/';
$uploaded_file = $upload_folder . basename($_FILES["myfile"]["name"]);

if (file_exists($uploaded_file)) {
    $response = ['success' => false, 'message' => 'The file already exists.'];
} elseif (move_uploaded_file($_FILES["myfile"]["tmp_name"], $uploaded_file)) {
    $response = ['success' => true, 'message' => 'File has been successfully uploaded.'];
} else {
    $response = ['success' => false, 'message' => 'Error in uploading file!'];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
