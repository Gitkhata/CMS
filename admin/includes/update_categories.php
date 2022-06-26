<form action="" method="post">
    <div class="form-group">
        <label for="cat-title"> Edit Category</label>
        <?php

if (isset($_GET['edit'])) {
    $cat_id = $_GET['edit'];
    $query = "SELECT *FROM categories WHERE cat_id = $cat_id";
    $select_categories_id = mysqli_query($connection, $query);
    //fetch all record using associative array from categories table
    while ($row = mysqli_fetch_assoc($select_categories_id)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];?>

        <input value="<?php if (isset($cat_title)) {
            echo $cat_title;
        }?>" type="text" class="form-control" name="cat_title">

        <?php
}
}?>

        <?php
//update query
if (isset($_POST['update_category'])) {
    $the_cat_title = $_POST['cat_title'];
    $query = "SELECT *FROM categories WHERE cat_title = '$cat_title'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    if (mysqli_num_rows($result) > 0) {

        echo "category exist";

    } else {

        $query = "UPDATE categories SET cat_title = '{$the_cat_title}' WHERE cat_id = {$cat_id}";
        $update_query = mysqli_query($connection, $query);

        if (!$update_query) {
            die("update query failed" . mysqli_error($connection));
        }
        echo "Updated";
        header("Location: categories.php");
    }

}

?>



    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">

    </div>
</form>