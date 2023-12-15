<?php
if (isset($_GET['filename'])) {
    $filename = $_GET['filename'];

    // Set headers for file download
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename=' . $filename);
    header('Content-Length: ' . filesize($filename));

    // Read and output the file content
    readfile($filename);

    // Delete the file after download (optional)
    unlink($filename);
    exit;
} else {
    // Redirect to the order page if filename is not provided
    header('Location: order.php');
    exit;
}
?>
