<?php

function redirect($location)
{

    header("Location:" . $location);
    exit;

}

function confirmQuery($result)
{
    global $connection;
    if (!$result) {
        die("query failed. " . mysqli_error($connection));
    }
}
function insert_categories()
{
    global $connection;
    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];

        if (empty($cat_title)) {
            echo "<h4>This field cannot not be empty</h4>";
        } else {
            $query = "SELECT *FROM categories WHERE cat_title = '$cat_title'";
            $result = mysqli_query($connection, $query);
            confirmQuery($result);

            if (mysqli_num_rows($result) > 0) {

                echo "category exist";

            } else {

                echo "Added";
                $query = "INSERT INTO categories(cat_title)";
                $query .= "VALUES ('{$cat_title}')";
                $create_category_query = mysqli_query($connection, $query);
                if (!$create_category_query) {
                    die('query failed' . mysqli_error($connection));
                }

            }

        }

    }
}

function finaAllCategories()
{
    global $connection;

    $query = "SELECT *FROM categories";
    $select_categories = mysqli_query($connection, $query);
    //fetch all record using associative array from categories table
    while ($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a class='btn btn-primary' href ='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "<td><a class ='btn btn-danger' href ='categories.php?delete={$cat_id}'>Delete</a></td>";

        echo "</tr>";
    }
}

function deleteCategories()
{
    global $connection;
    if (isset($_GET['delete'])) {
        $the_cat_id = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";
        $delete_query = mysqli_query($connection, $query);
        header("Location: categories.php");
    }
}

function username_exists($username)
{

    global $connection;

    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    if (mysqli_num_rows($result) > 0) {

        return true;

    } else {

        return false;

    }
}

function email_exists($email)
{

    global $connection;

    $query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    if (mysqli_num_rows($result) > 0) {

        return true;

    } else {

        return false;

    }

}

function register_user($username, $email, $password)
{

    global $connection;

    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);

    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

    $query = "INSERT INTO users (username, user_password, user_firstname, user_lastname, user_email, user_role)";
    $query .= "VALUES('{$username}', '{$password}', '','', '{$email}','subscriber')";
    $register_user_query = mysqli_query($connection, $query);

    confirmQuery($register_user_query);

}

function login_user($username, $password)
{
    global $connection;

    $username = trim($username);
    $password = trim($password);

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT *FROM users WHERE username='{$username}'";
    $select_user_query = mysqli_query($connection, $query);
    if (!$select_user_query) {
        die("Query failed" . mysqli_error($connection));
    }

    //mysqli_fetch_assoc
    while ($row = mysqli_fetch_array($select_user_query)) {
        $db_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];

    }

    if (password_verify($password, $db_user_password)) {
        $_SESSION['username'] = $db_username;
        $_SESSION['firstname'] = $db_user_firstname;
        $_SESSION['lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;

        redirect("/cms/admin");

    } else {
        redirect("/cms/index.php");

    }

}
