<?php
session_start();
$_SESSION['user_id']=1;
include("../includes/connection.txt");

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
                <img src="logo.png" alt="Logo"> 
                <span class="fw-bold">Alumni Connect</span>
            </a>

            <!-- Right Side -->
            <div class="d-flex align-items-center">
                <!-- Home Icon -->
                <a href="#" class="nav-item nav-link home">
                    <i class="fas fa-home text-white"></i> Home
                </a>

                <!-- Notification Icon -->
                <a href="#" class="nav-item nav-link">
                    <i class="fas fa-bell"></i>
                </a>

                <!-- User Profile Dropdown -->
                <div class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle d-flex align-items-center user-dropdown" data-bs-toggle="dropdown">
                        <img src="user-photo.jpg" alt="User"> 
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
            ?>
            <div class="post">
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
                    <button class="like-btn" data-post-id="<?php echo $post['post_id']; ?>">
                        <i class="fas fa-thumbs-up"></i> Like (<span class="like-count">0</span>)
                    </button>
                    <button class="like-btn dislike" data-post-id="<?php echo $post['post_id']; ?>">
                        <i class="fas fa-thumbs-down"></i>Dislike (<span class="dislike-count">0</span>)
                    </button>
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


setInterval(function(){ t(); }, 3000);

function load_assgn(x){
	
	window.location.href = x;
}


function t(){

var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange=function(){
	if (this.readyState == 4 && this.status == 200){
	document.getElementById("demo").innerHTML = this.responseText;
	document.getElementById("rcount1").innerHTML="[Students Loggedin="+document.getElementById("rcount").innerHTML+"]  <a href=lreset.php?id=a>[RESET ALL]</a>";
	}
};
xhttp.open("GET", "ajax_like.php", true);
xhttp.send();
}

// Like Button
document.querySelectorAll('.like-btn').forEach(button => {
    button.addEventListener('click', function () {
        const postId = this.getAttribute('data-post-id');
        fetch('like_post.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ postId: postId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const likeCount = this.querySelector('.like-count');
                likeCount.textContent = data.likeCount;
            }
        });
    });
});

// Dislike Button
document.querySelectorAll('.dislike').forEach(button => {
    button.addEventListener('click', function () {
        const postId = this.getAttribute('data-post-id');
        fetch('dislike_post.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ postId: postId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const dislikeCount = this.querySelector('.dislike-count');
                dislikeCount.textContent = data.dislikeCount;
            }
        });
    });
});
</script>
</body>
</html>
