<?php

if (isset($_POST['create_user'])) {
    $username = ($_POST['username']);
    $user_password = ($_POST['user_password']);
    $user_firstname = ($_POST['user_firstname']);
    $user_lastname = ($_POST['user_lastname']);
    $user_email = ($_POST['user_email']);
    $user_role = ($_POST['user_role']);

    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));

    $query = "INSERT INTO users(username, user_password, user_firstname, user_lastname, user_email, user_role) ";
    $query .= "VALUES('{$username}','{$user_password}','{$user_firstname}','{$user_lastname}','{$user_email}','{$user_role}') ";
    $create_user_query = mysqli_query($connection, $query);
    confirmQuery($create_user_query);

    echo "<p><h3>User Created</h3></p>";
    echo "<p><a class='btn btn-primary' href ='./users.php'>View User</a></p>";

}

?>
<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">First Name</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="title">Last Name</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">
        <select name="user_role" id="">
            <option value="subscriber">Select Options</option>
            <option value="admin">Admin</option>
            <option value="Subscriber">Subscriber</option>

        </select>
    </div>

    <?php
// $query = "SELECT *FROM users";
// $select_users = mysqli_query($connection, $query);

// confirmQuery($select_users);

// while ($row = mysqli_fetch_assoc($select_users)) {
//     $user_id = $row['user_id'];
//     $user_role = $row['user_role'];
//     echo "<option value='$user_id'>{$user_role}</option>";
// }

?>

    <!-- </select>
    </div> -->


    <!-- <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div> -->

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>



    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
    </div>


</form>