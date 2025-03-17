<?php
session_start();
$_SESSION['user_id']=2;
include("../includes/connection.txt");
$userId = $_SESSION['user_id'];
$sql = "Select * from posts";
$result = $pdo->query($sql);

$posts = $pdo->query("
    SELECT p.*, COUNT(l.like_id) as likeCount
    FROM posts p
    LEFT JOIN likes l ON p.post_id = l.post_id
    GROUP BY p.post_id
    ORDER BY p.created_at DESC
")->fetchAll();



// foreach ($posts as &$post) {
//     $stmt = $pdo->prepare("
//         SELECT c.*, u.name as username
//         FROM comments c
//         JOIN users u ON c.user_id = u.id
//         WHERE c.post_id = ?
//         ORDER BY c.created_at DESC
//     ");
//     $stmt->execute([$post['post_id']]);
//     //$post['comments'] = $stmt->fetchAll();
// }
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
            height: 40px; /* Adjust logo size */
            margin-right: 10px;
        }
        .nav-item {
            margin-right: 15px;
        }
        .user-dropdown img {
            height: 35px; /* Adjust profile photo size */
            width: 35px;
            border-radius: 50%;
        }
        .home{
            background-color: black;
            border-radius: 20px;
            color: lightsteelblue;
            padding-right: 10px;
            padding-left: 10px;
        }
        .home:hover{
            color: blanchedalmond;
        }
        /* Layout container */
        .main-container {
            display: flex;
            gap: 10px; /* Minor gaps between sections */
            height: calc(100vh - 56px); /* Adjusted for navbar height */
            padding: 10px;
        }

        /* Sidebar sections (Left & Right) */
        .sidebar {
            width: 24%;
            background: #f8f9fa;
            padding: 15px;
            position: sticky;
            top: 56px; /* Navbar height */
            height: calc(100vh - 56px);
            overflow-y: auto; /* Allows small scrolling if needed */
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
            min-height: auto; /* Ensures a minimum height */
            max-height: 90vh; /* Prevents excessive height */
            /* display: flex;
            flex-grow: 0;
            flex-direction: column;
            justify-content: center;
            align-items: center; */
            display: inline-block; /* Important: Makes it shrink to fit content */
            width: 100%; /* Ensure full width */
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
                        <span class="ms-2">John Doe</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>


    <div class="container-fluid main-container">
        <!-- Left Sidebar (Sticky) -->
        <div class="sidebar">
            <h5>Left Sidebar</h5>
            <p>Content goes here...</p>
        </div>

        <!-- Middle Content (Scrollable) -->
        <div class="content">
            <?php
            // while($rs=$result->fetch()){
                foreach($posts as $post){
                    $postId=$post[0];
                    
                    $stmt = $pdo->prepare("SELECT COUNT(l) FROM likes WHERE l=1 AND post_id = ?");
                    $stmt->execute([$postId]);
                    $likes = $stmt->fetch();
                    $stmt2 = $pdo->prepare("SELECT COUNT(d) FROM likes WHERE d= 1 AND post_id = ?");
                    $stmt2->execute([$postId]);
                    $dislikes = $stmt2->fetch();
            ?>
            <div class="post">
            <?//php echo $postId;?>
                <h4><?php echo $post[3];?></h4>
                <div class="dropdown">
                <a href="#" class="nav-link dropdown-toggle d-flex align-items-center user-dropdown" data-bs-toggle="dropdown">
                        
                        <span class="ms-2"><i class="fa-solid fa-ellipsis-vertical"></i></span>
                    </a>
                <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="edit_post.php?pid=<?php echo $post[0]; ?>">Edit</a></li>
                        <li><a class="dropdown-item" href="delete_post.php?pid=<?php echo $post[0]; ?>">Delete</a></li>
                        <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
                </ul>
                </div>
                 <p>
                 <?php echo $post[4];?>
                 <img src="<?php echo $post[5]; ?>" width="100px" alt="Post Image">
                </p> 
                
                <p><?php echo substr($post[6], 0, 10);?></p>
                <p><?php echo substr($post[6], 11, 5);?></p>
                <div>
                    <button class="like-btn" data-post-id="<?php echo $post['post_id']; ?>" onclick="showHint(<?php echo $post[0];?>,<?php echo $userId;?>);">
                        <i class="fas fa-thumbs-up"></i> Like 
                    </button>
                    <button class="like-btn dislike" data-post-id="<?php echo $post['post_id']; ?>" onclick="showHint1(<?php echo $post[0];?>,<?php echo $userId;?>);">
                        <i class="fas fa-thumbs-down"></i>Dislike
                    </button>
                    <span class="like-count" id="like<?php echo $post[0];?>"><?php echo ($likes[0])." Likes, Dislikes: ".$dislikes[0];?></span>
                </div>
                <div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">Post Title</h5>
        <p class="card-text">Post content goes here...</p>

        <!-- Comment Section -->
        <div class="mt-3">
            <form class="comment-form" data-post-id="1">
                <div class="mb-3">
                    <textarea class="form-control comment-text" rows="2" placeholder="Write a comment..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Post Comment</button>
            </form>

            <!-- Comments List -->
            <div class="mt-3 comments-list">
                <!-- Comments will be dynamically loaded here -->
            </div>
        </div>
    </div>
</div>



            </div>
                <?php } //} ?>
        </div>

        <!-- Right Sidebar (Sticky) -->
        <div class="sidebar">
            <h5>Right Sidebar</h5>
            <p>Content goes here...</p>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>

function showHint(x,y) {
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("like"+x).innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", "like.php?q=" + x+"&u="+y, true);
	xmlhttp.send();
}

function showHint1(x,y) {
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("like"+x).innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", "dislike.php?q=" + x+"&u="+y, true);
	xmlhttp.send();console.log(x,y);
}

// Submit Comment
document.querySelectorAll('.comment-form').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const postId = this.getAttribute('data-post-id');
        const commentText = this.querySelector('.comment-text').value;

        fetch('add_comment.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ postId: postId, commentText: commentText})
        })
        .then(response => {
    if (!response.ok) {
        return response.text().then(text => { throw new Error(text) });
    }
    return response.json();
})
        .then(data => {
            if (data.success) {
                // Clear the textarea
                this.querySelector('.comment-text').value = '';

                // Reload comments for this post
                loadComments(postId);
            }
        }).catch(error => {
            console.error('Error:', error);
        });
    });
});

// Load Comments
function loadComments(postId) {
    fetch('get_comments.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ postId: postId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const commentsList = document.querySelector(`.comments-list[data-post-id="${postId}"]`);
            commentsList.innerHTML = data.comments.map(comment => `
                <div class="mb-3 comment" data-comment-id="${comment.id}">
                    <strong>${comment.username}</strong>
                    <p>${comment.comment_text}</p>
                    <small class="text-muted">${comment.created_at}</small>

                    <!-- Reply Form -->
                    <form class="reply-form mt-2">
                        <div class="mb-2">
                            <textarea class="form-control reply-text" rows="1" placeholder="Reply to ${comment.username}..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-secondary btn-sm">Reply</button>
                    </form>

                    <!-- Replies -->
                    <div class="mt-2 replies-list">
                        ${comment.replies.map(reply => `
                            <div class="mb-2 reply">
                                <strong>${reply.username}</strong>
                                <p>${reply.comment_text}</p>
                                <small class="text-muted">${reply.created_at}</small>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `).join('');
        }
    });
}

// Submit Reply
document.addEventListener('submit', function (e) {
    if (e.target.classList.contains('reply-form')) {
        e.preventDefault();
        const commentId = e.target.closest('.comment').getAttribute('data-comment-id');
        const replyText = e.target.querySelector('.reply-text').value;

        fetch('add_comment.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ postId: postId, commentText: replyText, parentCommentId: commentId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Clear the reply textarea
                e.target.querySelector('.reply-text').value = '';

                // Reload comments for this post
                loadComments(postId);
            }
        });
    }
});


// setInterval(function(){ t(); }, 3000);

// function load_assgn(x){
	
// 	window.location.href = x;
// }



</script>
</body>
</html>
