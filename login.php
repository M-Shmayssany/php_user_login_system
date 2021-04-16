<?php
    include('./view/header.php'); // Include the headers

    //Check if form is submited
    if (isset($_POST['submit']))
    {
        // Import connection settings.
        include('./config/connection.php');

        // Getting and sanitizing data from form
        $email = filter_var($_POST["Email"],FILTER_SANITIZE_EMAIL);
        $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);

        // Declaring errors massages variables
        $email_err_message = "";
        $password_err_message = "";
        $sql_massage = "";
        $err_state = 0;

        // Check if email if empty or valid format
        if (empty($email))
        {
            $email_err_message = "<span>Email address can't be empty!!</span>";
            $err_state++;
        }
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $email_err_message = "<span>Invalid email address!</span>";
            $err_state++;
        }

        // Check if password if empty
        if (empty($password))
        {
            $password_err_message = "<span>Password can't be empty!</span>";
            $err_state++;
        }

        // Check error state if any
        if ($err_state == 0)
        {
            // Check if email exist in database
            try {
                $stmt = $conn->prepare('SELECT * FROM users WHERE email=? LIMIT 1');
                $stmt->bindParam(1, $email, PDO::PARAM_STR);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$row)
                {
                    $sql_massage = "<span>Account did not exist!</span>";
                }
                else
                {
                    // If email exist get data
                    $firstname = $row['firstname'];
                    $lastname = $row['lastname'];
                    $hash_password = $row['password'];
                    
                    // Check if password match
                    if (!password_verify($password, $hash_password))
                    {
                        $sql_massage = "<span>Incorrect password</span>";
                    }
                    else
                    {
                        $_SESSION['firstname'] = $firstname;
                        $_SESSION['lastname'] = $lastname;
                        $_SESSION['email'] = $email;
                        header('Location: index.php');
                    }
                }
            } catch(PDOException $e) {
                $sql_massage = '<span>' . $e->getMessage(). '</span>';
                $err_state++;
            }
        }
        // Close connection
        $conn = null;
    }
?>
<form action="" method="post">
    <?php echo (isset($_POST["submit"])) ? $conn_massage : "" ?>
    <?php echo (isset($_POST["submit"])) ? $sql_massage : "" ?>
  <h2>Sign In</h2>
		<p>
			<label for="Email" class="floatLabel">Email</label>
			<input id="Email" name="Email" type="text" value="<?php echo (isset($_POST["submit"])) ? $email : "" ?>">
            <?php echo (isset($_POST["submit"])) ? $email_err_message : "" ?>
		</p>
		<p>
			<label for="password" class="floatLabel">Password</label>
			<input id="password" name="password" type="password">
            <?php echo (isset($_POST["submit"])) ? $password_err_message : "" ?>
		</p>
		<p>
			<input type="submit" name="submit" value="Sign In" id="submit">
		</p>
	</form>

<?php
    include('./view/footer.php');
?>