<?php
session_start();
include 'dbconnect.php';

if (isset($_SESSION['user_data'])) {
    $email = $_SESSION['user_data']['email'];

    $query = "SELECT id, heading, body, timestamp FROM blogs WHERE email = ? ORDER BY timestamp DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Writer's Haven</title>
    <link rel="stylesheet" href="homepage.css">
    <style>
        .full-text {
            display: none;
        }
        .close{
            color: red;
            margin-left: 15px;
            cursor: pointer;
        }
        .close:hover{
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); 
            cursor: pointer;
        }
        .read-more{
            cursor: pointer;
            color: green;
            text-decoration: none;
        }
        .trash-icon {
            width: 40px; 
            height: auto; 
            vertical-align: middle; 
            margin-left: 30px;
            cursor: pointer;
            transition: transform 0.2s; /
        }
        .delete-button:hover .trash-icon {
            transform: scale(1.1); 
        }

        .blog-post p {
            text-align: justify;
        }
        .no-posts {
            text-align: center;
            color: #666;
            font-size: 20px;
            margin-top: 50px;
        }
    </style>
</head>
<body>
<header>
    <nav>
        <div class="logo">Writer's Haven</div>
        <ul style="display: flex; align-items: center; justify-content: center; list-style-type: none; padding: 0; margin: 0;">
            <li>
                <h4 style="margin: 0;">
                    Hello, <?php echo isset($_SESSION['user_data']) ? htmlspecialchars($_SESSION['user_data']['name']) : 'Guest'; ?>
                </h4>
            </li>
            <li style="margin-left: 20px;"><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<main>
    <h1>Latest from Writer's Haven</h1>
    <button class="post-button" onclick="openPopup()">New Post</button>

    <div class="blog-container">
        <?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $heading = htmlspecialchars($row['heading']);
        $body = htmlspecialchars($row['body']);
        $timestamp = htmlspecialchars($row['timestamp']);
        $id = htmlspecialchars($row['id']); // Get the post ID for deletion
        $truncated_body = substr($body, 0, 150) . '...';
        echo "<div class='blog-post'>";
        echo "<h2><b>$heading</b><span class='delete-button' onclick='deletePost($id)'><img src='trash-bin.png' alt='Delete' class='trash-icon'></span></h2>";
        echo "<p class='truncated'>$truncated_body <span class='read-more' onclick='toggleText(this)'>Read More</span></p>";
        echo "<p class='full-text'>$body <span class='close' onclick='toggleText(this)'>✖</span></p>";
        echo "<small>Posted on: $timestamp</small>";
        echo "</div>";
    }
} else {
    echo "<p class='no-posts'></p>";
}
?>
    </div>
</main>

<div class="popup-container hidden" id="popup">
    <div class="popup-box animate-popup">
        <h2>New Post</h2>
        <form method="post" action="save_post.php">
            <input type="text" placeholder="Enter Heading" name="post_heading" required>
            <textarea placeholder="Enter Body" name="post_body" required></textarea>
            <div class="buttons">
                <button type="submit" class="post-button">Post</button>
                <button type="button" class="close-button" onclick="closePopup()">Close</button>
            </div>
        </form>
    </div>
</div>

<footer>
    <p>&copy; Asif Bhuiyan 2024. All rights reserved.</p>
</footer>

<script src="homepage.js"></script>
<script>
    function toggleText(element) {
        const fullText = element.closest('.blog-post').querySelector('.full-text');
        const truncatedText = element.closest('.blog-post').querySelector('.truncated');

        if (fullText.style.display === 'none' || fullText.style.display === '') {
            fullText.style.display = 'block';
            truncatedText.style.display = 'none';
        } else {
            fullText.style.display = 'none';
            truncatedText.style.display = 'block';
        }
    }

    function deletePost(postId) {
        if (confirm("Are you sure you want to delete this post?")) {
            window.location.href = 'delete_post.php?id=' + postId;
        }
    }
</script>
</body>
</html>
