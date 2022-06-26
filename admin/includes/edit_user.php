<?php

if (isset($_GET['edit_user'])) {
    $the_user_id = $_GET['edit_user'];

    $query = "SELECT *FROM users WHERE user_id = $the_user_id";
    $select_users_query = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_users_query)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_role = $row['user_role'];
    }

}
//update user
if (isset($_POST['edit_user'])) {

    $username = $_POST['username'];
    $user_password = $_POST['user_password'];
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_email = $_POST['user_email'];
    $user_role = $_POST['user_role'];

    if (!empty($user_password)) {

        $query_password = "SELECT user_password FROM users WHERE user_id =  $the_user_id";
        $get_user_query = mysqli_query($connection, $query_password);
        confirmQuery($get_user_query);

        $row = mysqli_fetch_array($get_user_query);

        $db_user_password = $row['user_password'];

        if ($db_user_password != $user_password) {

            $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));

        }

        $query = "UPDATE users SET ";
        $query .= "username  = '{$username}', ";
        $query .= "user_password = '{$hashed_password}', ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_email   = '{$user_email}', ";
        $query .= "user_role = '{$user_role}' ";
        $query .= "WHERE user_id ={$the_user_id} ";

        $edit_user_query = mysqli_query($connection, $query);

        confirmQuery($edit_user_query);
        echo "<p><h3>User Updated</h3></p>";
        echo "<p><a class='btn btn-primary' href ='./users.php'>Edit other user</a></p>";

    }
}

?>
<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">First Name</label>
        <input value="<?php echo $user_firstname; ?>" type="text" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="title">Last Name</label>
        <input value="<?php echo $user_lastname; ?>" type="text" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">
        <select name="user_role" id="">
            <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>

            <?php

if ($user_role == 'admin') {

    echo "<option value='subscriber'>subscriber</option>";

} else {

    echo "<option value='admin'>admin</option>";

}

?>


        </select>
    </div>



    <div class="form-group">
        <label for="username">Username</label>
        <input value="<?php echo $username; ?>" type="text" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input value="<?php echo $user_email; ?>" type="email" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input autocomplete= "off"  type="password" class="form-control" name="user_password">
    </div>


    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_user" value="Update User">
    </div>


</form>