<?php
include("../header.php");
include("../includes/dbConnection.inc.php");
$sql = "SELECT * FROM categories";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
?>

<!-- add categories-->
<form action="../includes/addcategories.inc.php" method="post" enctype="multipart/form-data">
    <div class="">

        <label>categories</label>
        <input type="text" name="categories" placeholder="categories" required><br />
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </div>
</form>




<div class="">
    <form action="../includes/deletecategories.inc.php" method="post">
        <!-- deleted id-->


        <?php
                if ($resultCheck > 0) {
                    ?>
        <select name="did">
            <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id= $row["categories_id"];
                ?>







            <option value="<?php echo $id ?>"><?php echo $row['categories'] ?></option>




            <?php
                    }
                    ?>

        </select>
        <button type="submit" name="submit">Delete</button>
        <?php
                }
                else{
                ?>
        <h1>This is no data on the option</h1>
        <?php
}
        ?>

    </form>





</div>
<?php
include("../footer.php");
?>