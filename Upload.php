<?php

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST["title"]);

    if ($title === "" || !isset($_FILES["photo"])) {
        die("Please provide a title and photo.");
    }

    $file = $_FILES["photo"];

    if ($file["error"] !== UPLOAD_ERR_OK) {
        die("Photo upload failed.");
    }

    if ($file["size"] > 5 * 1024 * 1024) {
        die("Maximum photo size is 5MB.");
    }

    $allowed = [
        "image/jpeg" => "jpg",
        "image/png" => "png",
        "image/webp" => "webp",
        "image/gif" => "gif"
    ];

    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file["tmp_name"]);

    if (!isset($allowed[$mime])) {
        die("Invalid image format.");
    }

    $filename = bin2hex(random_bytes(16)) . "." . $allowed[$mime];

    $folder = __DIR__ . "/uploads/";

    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }

    $destination = $folder . $filename;

    if (move_uploaded_file($file["tmp_name"], $destination)) {

        $stmt = $conn->prepare(
            "INSERT INTO photos (title, image) VALUES (?, ?)"
        );

        $stmt->bind_param("ss", $title, $filename);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        }

        unlink($destination);
        die("Could not save photo information.");

    } else {
        die("Could not upload photo.");
    }
}

?>
