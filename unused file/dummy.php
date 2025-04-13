<?php
session_start();
$user_id = $_SESSION['user_id'];
// echo $user_id;
include("../includes/connection.txt");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Layout</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .navbar-brand img {
            height: 40px;
            /* Adjust logo size */
            margin-right: 10px;
        }

        .nav-item {
            margin-right: 15px;
        }

        .user-dropdown img {
            height: 35px;
            /* Adjust profile photo size */
            width: 35px;
            border-radius: 50%;
        }

        .home {
            background-color: black;
            border-radius: 20px;
            color: lightsteelblue;
            padding-right: 10px;
            padding-left: 10px;
        }

        .home:hover {
            color: blanchedalmond;
        }

        /* Layout container */
        .main-container {
            display: flex;
            gap: 10px;
            /* Minor gaps between sections */
            height: calc(100vh - 56px);
            /* Adjusted for navbar height */
            padding: 10px;
        }

        /* Sidebar sections (Left & Right) */
        .sidebar {
            width: 24%;
            background: #f8f9fa;
            padding: 15px;
            position: sticky;
            top: 56px;
            /* Navbar height */
            height: calc(100vh - 56px);
            overflow-y: auto;
            /* Allows small scrolling if needed */
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Scrollable middle section */
        .content {
            width: 48%;
            background: white;
            padding: 15px;
            overflow-y: auto;
            height: calc(100vh - 56px);
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            gap: 10px;

            scroll-snap-type: y mandatory;
            -webkit-overflow-scrolling: touch;
        }

        .content::-webkit-scrollbar {
            display: none;
        }

        .content {
            scrollbar-width: none;
        }

        /* Each post behaves like a snap point */
        .post {
            min-height: auto;
            /* Ensures a minimum height */
            max-height: 90vh;
            /* Prevents excessive height */
            /* display: flex;
            flex-grow: 0;
            flex-direction: column;
            justify-content: center;
            align-items: center; */
            display: inline-block;
            /* Important: Makes it shrink to fit content */
            width: 100%;
            /* Ensure full width */
            text-align: center;
            border-bottom: 1px solid #ddd;
            scroll-snap-align: start;
            font-size: 24px;
            font-weight: bold;
            color: black;
        }

        /* Different post background colors */
        /* .post:nth-child(1) { background: #ff5733; }
        .post:nth-child(2) { background: #33a1ff; }
        .post:nth-child(3) { background: #28a745; } */


        .testimonial-carousel {
            width: 100%;
            border: 1px solid #ddd;
            padding: 10px;
            overflow: hidden;
            height: 120px;
            position: relative;
            background-color: #f9f9f9;
        }

        .testimonial-slide {
            transition: opacity 0.5s ease-in-out;
            opacity: 0;
            position: absolute;
            width: 100%;
        }

        .testimonial-slide.active {
            opacity: 1;
            position: relative;
        }

        .post-options {
            display: none;
            position: absolute;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            padding: 5px;
            border-radius: 5px;
        }

        .post-options button {
            background: none;
            border: none;
            color: #007bff;
            cursor: pointer;
            padding: 5px;
            width: 100%;
        }

        .post-options button:hover {
            background-color: #f1f1f1;
        }
    </style>

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <!-- Left Side: Logo & Name -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <!-- <img src="logo.png" alt="Logo">  -->
                <span class="fw-bold">Alumni Connect</span>
                <?php echo $user_id . "is the user id."; ?>
            </a>

            <!-- Right Side -->
            <div class="d-flex align-items-center">
                <!-- Home Icon -->
                <a href="#" class="nav-item nav-link home">
                    <!-- <i class="fas fa-home text-white"></i> Home -->
                </a>

                <!-- Notification Icon -->
                <a href="#" class="nav-item nav-link">
                    <i class="fas fa-bell"></i>
                </a>

                <!-- User Profile Dropdown -->
                <div class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle d-flex align-items-center user-dropdown" data-bs-toggle="dropdown">
                        <!-- <img src="user-photo.jpg" alt="User">  -->
                        <span class="ms-2"><?php echo $_SESSION['username'] ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="academic.php">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item text-danger" href="../includes/logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>


    <div class="container-fluid main-container">
        <!-- Left Sidebar (Sticky) -->
        <div class="sidebar">
            <!-- Filter Form -->
            <form id="event-filter-form" style="margin-bottom: 20px;">
                <input type="date" name="event_date">

                <select name="category">
                    <option value="">All Categories</option>
                    <option value="Tech">Tech</option>
                    <option value="Cultural">Cultural</option>
                    <option value="Workshop">Workshop</option>
                </select>

                <input type="text" name="search" placeholder="Search events...">

                <button type="submit">Filter</button>
                <!-- Event Results will appear here -->
                <div id="event-results">
                    <!-- Initially loaded via PHP or AJAX -->
                </div>

            </form>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function() {
                    function loadEvents() {
                        $.ajax({
                            url: "fetch_events_ajax.php",
                            type: "GET",
                            data: $("#event-filter-form").serialize(),
                            success: function(response) {
                                $("#event-results").html(response);
                            }
                        });
                    }

                    // Load initially
                    loadEvents();

                    // On form submit
                    $("#event-filter-form").on("submit", function(e) {
                        e.preventDefault();
                        loadEvents();
                    });

                    // Optional: live typing for search
                    $('input[name="search"]').on("input", function() {
                        loadEvents();
                    });
                });
            </script>



            <?php

            $stmt = $pdo->prepare("SELECT * FROM events ORDER BY event_date DESC, event_time DESC");
            $stmt->execute();
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <h2>Upcoming Events</h2>
            <?php if (count($events) > 0): ?>
                <?php foreach ($events as $event): ?>
                    <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 10px;">
                        <h3><?= htmlspecialchars($event['event_name']) ?></h3>
                        <p><strong>Date:</strong> <?= date("F j, Y", strtotime($event['event_date'])) ?></p>
                        <p><strong>Time:</strong> <?= date("g:i A", strtotime($event['event_time'])) ?></p>
                        <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
                        <p><?= nl2br(htmlspecialchars($event['event_description'])) ?></p>
                        <?php if (!empty($event['image_url'])): ?>
                            <img src="../admin/<?= $event['image_url'] ?>" alt="Event Image" style="max-width: 200px;">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No events posted yet. Stay tuned!</p>
            <?php endif; ?>

        </div>

        <!-- Middle Content (Scrollable) -->
        <div class="content">
            <?php
            $stmt = $pdo->prepare("SELECT p.*, u.username FROM posts p JOIN users u ON p.user_id = u.user_id WHERE p.status = 'approved' ORDER BY p.created_at DESC");
            $stmt->execute();
            $approvedPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <?php if (count($approvedPosts) === 0): ?>
                <p>No approved posts available yet.</p>
            <?php else: ?>
                <?php foreach ($approvedPosts as $post): ?>
                    <div class="post" id="post-<?php echo $post['post_id']; ?>">
                        <div class="post-header">
                            <h3><?php echo htmlspecialchars($post['title']); ?></h3>

                            <?php if ($post['user_id'] == $user_id) { ?>
                                <!-- Dropdown Button for Edit/Delete -->
                                <div class="dropdown" data-post-id="<?php echo $post['post_id']; ?>">
                                    <i class="fa fa-ellipsis-v"></i>
                                </div>

                                <!-- Hidden Dropdown Menu -->
                                <div class="post-options" id="post-options-<?php echo $post['post_id']; ?>" style="display: none;">
                                    <button onclick="editPost(<?php echo $post['post_id']; ?>)">Edit</button>
                                    <button onclick="deletePost(<?php echo $post['post_id']; ?>)">Delete</button>
                                </div>
                            <?php } ?>
                        </div>
                        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                    </div>



                    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
                        <strong>User:</strong> <?= htmlspecialchars($post['username']) ?><br>
                        <strong>Title:</strong> <?= htmlspecialchars($post['title']) ?><br>
                        <strong>Type:</strong> <?= $post['post_type'] ?><br>
                        <strong>Content:</strong> <?= nl2br(htmlspecialchars($post['content'])) ?><br>
                        <?php if ($post['post_type'] === 'image' && $post['media_path']): ?>
                            <img src="<?= htmlspecialchars($post['media_path']) ?>" style="max-width:200px;"><br>
                        <?php endif; ?>
                        <em>Posted on: <?= date("d M Y, h:i A", strtotime($post['created_at'])) ?></em>
                        <!-- Like/Dislike Section -->
                        <div class="interaction">
                            <button onclick="reactToPost(<?= $post['post_id'] ?>, 'like')">👍 Like (<span id="like-count-<?= $post['post_id'] ?>"></span>)</button>
                            <button onclick="reactToPost(<?= $post['post_id'] ?>, 'dislike')">👎 Dislike (<span id="dislike-count-<?= $post['post_id'] ?>"></span>)</button>
                        </div><br>
                        <!-- Comment Form -->
                        <div class="comment-section">
                            <form onsubmit="submitComment(event, <?= $post['post_id'] ?>, null)">
                                <textarea id="comment-text-<?= $post['post_id'] ?>" placeholder="Write a comment..." required></textarea><br>
                                <button type="submit">Post Comment</button>
                            </form>
                            <!-- Comments List -->
                            <div id="comments-<?= $post['post_id'] ?>"></div>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            loadReactionCounts(<?= $post['post_id'] ?>);
                        });
                    </script>
                    <script>
                        function submitComment(event, postId, parentId = null) {
                            event.preventDefault();
                            const textareaId = parentId ? `reply-text-${parentId}` : `comment-text-${postId}`;
                            const content = document.getElementById(textareaId).value;

                            fetch('submit_comment.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded'
                                    },
                                    body: `post_id=${postId}&content=${encodeURIComponent(content)}&parent_id=${parentId ?? ''}`
                                })
                                .then(res => res.text())
                                .then(() => {
                                    loadComments(postId);
                                    document.getElementById(textareaId).value = '';
                                });
                        }

                        function loadComments(postId) {
                            fetch(`fetch_comments.php?post_id=${postId}`)
                                .then(res => res.text())
                                .then(html => {
                                    document.getElementById(`comments-${postId}`).innerHTML = html;
                                });
                        }
                    </script>
                    <script>
                        function deleteComment(commentId, postId) {
                            if (confirm("Are you sure you want to delete this comment and all its replies?")) {
                                fetch('delete_comments.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded'
                                        },
                                        body: 'comment_id=' + encodeURIComponent(commentId) // Ensure the right comment ID is sent
                                    })
                                    .then(res => res.text())
                                    .then(response => {
                                        alert(response); // See the server response
                                        location.reload(); // Refresh the page
                                    })
                                    .catch(error => {
                                        console.error("Error:", error);
                                    });
                            }
                        }
                    </script>

                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            loadComments(<?= $post['post_id'] ?>);
                        });
                    </script>


                <?php endforeach; ?>
            <?php endif; ?>

            <script>
                // Function to handle like/dislike and neutral (no reaction)
                function reactToPost(postId, type) {
                    fetch('like_dislike_handler.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `post_id=${postId}&type=${type}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update the like/dislike counts
                                document.getElementById(`like-count-${postId}`).innerText = data.likes;
                                document.getElementById(`dislike-count-${postId}`).innerText = data.dislikes;

                                // Optionally, update any neutral state or handle UI changes for the reaction button
                                if (type === 'like') {
                                    document.getElementById(`like-button-${postId}`).classList.add('active'); // Mark like as active
                                    document.getElementById(`dislike-button-${postId}`).classList.remove('active'); // Remove active from dislike
                                } else if (type === 'dislike') {
                                    document.getElementById(`dislike-button-${postId}`).classList.add('active'); // Mark dislike as active
                                    document.getElementById(`like-button-${postId}`).classList.remove('active'); // Remove active from like
                                } else {
                                    // Remove both active states if neutral (no reaction)
                                    document.getElementById(`like-button-${postId}`).classList.remove('active');
                                    document.getElementById(`dislike-button-${postId}`).classList.remove('active');
                                }
                            } else {
                                alert(data.message);
                            }
                        });
                }

                // Function to load like/dislike counts and neutral reaction if any
                function loadReactionCounts(postId) {
                    fetch(`get_like_dislike_counts.php?post_id=${postId}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById(`like-count-${postId}`).innerText = data.likes;
                            document.getElementById(`dislike-count-${postId}`).innerText = data.dislikes;

                            // Update the neutral button if necessary (if your UI has one)
                            if (data.likes === 0 && data.dislikes === 0) {
                                document.getElementById(`neutral-button-${postId}`).classList.add('active');
                            }
                        });
                }
            </script>



        </div>

        <!-- Right Sidebar (Sticky) -->
        <div class="sidebar">
            <h5>Your Profile</h5>
            <?php
            $sql_stmt = $pdo->prepare("Select * from users where user_id = :userid");
            $sql_stmt->bindParam(":userid", $user_id, PDO::PARAM_INT);
            $sql_stmt->execute();
            $user = $sql_stmt->fetch(PDO::FETCH_ASSOC);

            $sql_pic = $pdo->prepare("Select profile_pic_path from user_info1 where user_id = :userid");
            $sql_pic->bindParam(":userid", $user_id, PDO::PARAM_INT);
            $sql_pic->execute();
            $pfp = $sql_pic->fetch(PDO::FETCH_ASSOC);

            ?>
            <p><img src=<?php echo $pfp['profile_pic_path']; ?> width="100px" alt="Profile Picture"></p>
            <p>PRN : <?php echo htmlspecialchars($user['user_prn']); ?></p>
            <p>Name : <?php echo htmlspecialchars($user['uname']); ?></p>
            <p>Batch Year and Month: <?php echo htmlspecialchars($user['batch_year']);
                                        echo " - ";
                                        echo htmlspecialchars($user['month_section']); ?></p>
            <a href="post_create.php"><button>Create New Post</button></a><br>
            <a href="testimonial_submit.php"><button>Add Testimonial</button></a>

            <div id="testimonialCarousel" class="testimonial-carousel">
                <div class="testimonial-slide">Loading testimonials...
                    <script>
                        $(document).ready(function() {
                            $.ajax({
                                url: "fetch_testimonials.php", // path based on location
                                method: "GET",
                                dataType: "json",
                                success: function(testimonials) {
                                    if (testimonials.length > 0) {
                                        var html = '';
                                        testimonials.forEach(function(t, index) {
                                            html += `<div class="testimonial-slide ${index === 0 ? 'active' : ''}">
                                        <p>"${t.message}"</p>
                                        <small>- ${t.username}</small><br>
                                        ${t.image_url ? `<img src="../users/${t.image_url}" style="max-width:50px;">` : ''}
                                    </div>`;
                                        });
                                        $('#testimonialCarousel').html(html);

                                        let current = 0;
                                        setInterval(function() {
                                            const slides = $(".testimonial-slide");
                                            slides.removeClass("active");
                                            current = (current + 1) % slides.length;
                                            slides.eq(current).addClass("active");
                                        }, 5000); // 5 seconds
                                    } else {
                                        $('#testimonialCarousel').html("<p>No testimonials available.</p>");
                                    }
                                }
                            });
                        });
                    </script>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </script>

    <!-- Edit Post Modal -->
    <div id="edit-post-modal" style="display:none; position:fixed; top:10%; left:50%; transform:translateX(-50%); background:#fff; padding:20px; border-radius:10px; z-index:9999;">
        <h3>Edit Post</h3>
        <form id="edit-post-form">
            <input type="hidden" id="edit-post-id" name="post_id">
            <input type="text" id="edit-post-title" name="title" placeholder="Title" required><br><br>
            <textarea id="edit-post-content" name="content" placeholder="Content" required></textarea><br><br>
            <button type="submit">Update Post</button>
            <button type="button" onclick="closeModal()">Cancel</button>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Toggle dropdowns
            document.querySelectorAll(".dropdown").forEach(dropdown => {
                dropdown.addEventListener("click", function() {
                    const postId = this.dataset.postId;
                    const menu = document.getElementById(`post-options-${postId}`);
                    if (menu) {
                        menu.style.display = (menu.style.display === "block") ? "none" : "block";
                    }
                });
            });

            // Edit Post Modal submit
            const editForm = document.getElementById("edit-post-form");
            if (editForm) {
                editForm.addEventListener("submit", function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);

                    fetch("update_post.php", {
                            method: "POST",
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                alert("Post updated and sent for admin approval.");
                                closeModal();
                                location.reload();
                            } else {
                                alert("Failed to update post.");
                            }
                        });
                });
            }
        });

        // Load post data into modal
        function editPost(postId) {
            const modal = document.getElementById("edit-post-modal");
            if (!modal) {
                console.error("Modal not found");
                return;
            }
            modal.style.display = "block";

            fetch(`edit_post.php?post_id=${postId}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById("edit-post-id").value = postId;
                    document.getElementById("edit-post-title").value = data.title;
                    document.getElementById("edit-post-content").value = data.content;
                });

        }

        // Close modal
        function closeModal() {
            document.getElementById("edit-post-modal").style.display = "none";
        }

        // Delete post
        function deletePost(postId) {
            if (confirm("Are you sure you want to delete this post?")) {
                fetch("delete_post.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: `post_id=${postId}`
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById(`post-${postId}`).remove();
                        } else {
                            alert("Failed to delete post.");
                        }
                    });
            }
        }
    </script>

</body>

</html> 