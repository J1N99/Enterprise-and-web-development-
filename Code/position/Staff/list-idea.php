<?php
include("../../header.php");
include("../../includes/dbConnection.inc.php");
?>

<link rel="stylesheet" href="../../style.css">

<div class="d-flex" id="wrapper">

    <!--sidebar-->
    <div class="bg-white" id="sidebar-wrapper">
        <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">
            <i class="fas fa-user-secret me-2"></i>Test
        </div>

        <div class="list-group list-group-flush my-3">

            <a href="./dashboard.php" class="list-group-item list-group-item-action second-text fw-bold active">
                <i class="fas fa-sharp fa-solid fa-lightbulb me-2"></i>Ideas
            </a>

            <a href="../login.html" class="list-group-item list-group-item-action second-text fw-bold">
                <i class="fas fa-sharp fa-regular fa-right-from-bracket me-2"></i>LogOut
            </a>

        </div>
    </div>

    <!--navbar header-->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                <h2 class="fs-2 m-0">Ideas</h2>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle primary-text fw-bold" href="#" id="navbarDropdownMenuLink"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-2"></i>Staff Name
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">LogOut</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <!--Content-->

        <?php
        if (isset($_GET['view'])) {
            $sql = "SELECT idea.idea_id, idea.document_url,idea.submitDate,idea.title,idea.description,sum(t_up),sum(t_down),categories.categories,department.department,idea.a_status,user.name FROM idea
                    LEFT JOIN likepost ON idea.idea_id= likepost.idea_id 
                    LEFT JOIN categories ON idea.categories_id= categories.categories_id 
                    LEFT JOIN user ON idea.user_id= user.user_id
                    LEFT JOIN department ON user.department= department.department_id
                    group by idea.idea_id ORDER BY views DESC";
        } else if (isset($_GET['tup'])) {
            $sql = "SELECT idea.idea_id, idea.document_url,idea.submitDate,idea.title,idea.description,sum(t_up),sum(t_down),categories.categories,department.department,idea.a_status,user.name FROM idea 
                    LEFT JOIN likepost ON idea.idea_id= likepost.idea_id 
                    LEFT JOIN categories ON idea.categories_id= categories.categories_id 
                    LEFT JOIN user ON idea.user_id= user.user_id
                    LEFT JOIN department ON user.department= department.department_id
                    group by idea.idea_id ORDER BY t_up DESC";
        } else if (isset($_GET['tdown'])) {
            $sql = "SELECT idea.idea_id, idea.document_url,idea.submitDate,idea.title,idea.description,sum(t_up),sum(t_down),categories.categories,department.department,idea.a_status,user.name FROM idea 
                      LEFT JOIN likepost ON idea.idea_id= likepost.idea_id 
                    LEFT JOIN categories ON idea.categories_id= categories.categories_id 
                    LEFT JOIN user ON idea.user_id= user.user_id
                    LEFT JOIN department ON user.department= department.department_id
                    group by idea.idea_id ORDER BY t_down DESC";
        } else if (isset($_GET['idea'])) {
            $sql = "SELECT idea.idea_id, idea.document_url,idea.submitDate,idea.title,idea.description,sum(t_up),sum(t_down),categories.categories,department.department,idea.a_status,user.name FROM idea 
                      LEFT JOIN likepost ON idea.idea_id= likepost.idea_id 
                    LEFT JOIN categories ON idea.categories_id= categories.categories_id 
                    LEFT JOIN user ON idea.user_id= user.user_id
                    LEFT JOIN department ON user.department= department.department_id
                    group by idea.idea_id ORDER BY submitDate DESC";
        } else if (isset($_GET["comment"])) {
            // pending comment
            $sql = "SELECT idea.idea_id, idea.document_url,idea.submitDate,idea.title,idea.description,sum(t_up),sum(t_down) FROM idea 
                    LEFT JOIN likepost ON idea.idea_id= likepost.idea_id 
                    LEFT JOIN comment ON idea.idea_id=comment.idea_id
                    group by idea.idea_id ORDER BY comment.commentDate DESC";
        } else {
            $sql = "SELECT idea.idea_id, idea.document_url, idea.submitDate, idea.title, idea.description, sum(t_up),sum(t_down), categories.categories,department.department,idea.a_status,user.name FROM idea
                    LEFT JOIN likepost ON idea.idea_id= likepost.idea_id 
                    LEFT JOIN categories ON idea.categories_id= categories.categories_id 
                    LEFT JOIN user ON idea.user_id= user.user_id
                    LEFT JOIN department ON user.department= department.department_id
                    group by idea.idea_id";
        }
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        ?>

        <select class="btn btn-secondary ms-5 mt-4 select" aria-label="Default select example"
            onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
            <option default>Select Filter</option>
            <option value="list-idea.php?view=true">Most View</option>
            <option value="list-idea.php?tup=true">Most Like</option>
            <option value="list-idea.php?tup=false">Most Dislike</option>
            <option value="list-idea.php?idea=true">Latest Ideas</option>
            <option value="list-idea.php?comment=true">Latest Comment</option>
        </select>

        <div class="container-fluid px-5 mt-4">

            <div class="card mt-4">
                <h5 class="card-header">Idea Title</h5>
                <div class="card-body">
                    <h5 class="card-text">This is the idea description</h5>
                    <p class="card-text fs-6">Posted by: anonymously / XXXX
                        <br>Category: XXXX
                        <br>Department: xxxx
                    </p>
                    <a href="#" class="btn btn-secondary">Read More</a>
                </div>
            </div>

            <?php
            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['idea_id'];
                    $url = $row['document_url'];
                    $submitDate = $row['submitDate'];
                    $title = $row['title'];
                    $t_up = $row['sum(t_up)'];
                    $t_down = $row['sum(t_down)'];
                    $description = $row['description'];
                    $astatus = $row['a_status'];
                    $categories = $row['categories'];
                    $department = $row['department'];
                    $name = $row['name'];


            ?>
            <div class="card mt-4">
                <h5 class="card-header"><?php echo $title ?></h5>
                <div class="card-body">
                    <h5 class="card-text"><?php echo $description ?></h5>
                    <p class="card-text fs-6"><?php echo "Posted by:";
                                                        if ($astatus == 0) {
                                                            echo $name;
                                                        } else if ($astatus == 1) {
                                                            echo "Anonymous";
                                                        } ?>
                        <br><?php echo "Category:" . $categories ?>
                        <br><?php echo "Department:" . $department ?>
                    </p>
                    <a href="../../listdetails.php?id=<?php echo $id?>" class="btn btn-secondary">Read More</a>
                </div>
            </div>
            <?php
                }
            }
            ?>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
</script>
<script src="../../script.js"></script>


<?php
include("../../footer.php");
?>