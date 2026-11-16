<?php
include "db.php";

$result = $conn->query("SELECT * FROM photos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Photo Website</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>My Photo Gallery</h1>
    <p>Upload and share your photos</p>
</header>

<div class="container">

    <h2>Upload New Photo</h2>

    <form action="upload.php" method="POST" enctype="multipart/form-data">

        <input type="text" name="title" placeholder="Enter photo title" required>

        <input type="file" name="photo" accept="image/jpeg,image/png,image/webp,image/gif" required>

        <button type="submit">Upload Photo</button>

    </form>

    <h2>Latest Photos</h2>

    <div class="gallery">

        <?php while ($row = $result->fetch_assoc()) { ?>

            <div class="photo-card">

                <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Photo">

                <h3><?php echo htmlspecialchars($row['title']); ?></h3>

                <p><?php echo htmlspecialchars($row['uploaded_at']); ?></p>

            </div>

        <?php } ?>

    </div>

</div>

</body>
</html>
