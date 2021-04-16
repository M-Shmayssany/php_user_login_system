<?php
    include('./view/header.php');
    if (isset($_POST['submit']))
    {
        include('./config/connection.php');
        $submit = $_POST['submit'];
        $firstName = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
        $familyName = filter_var($_POST["familyName"],FILTER_SANITIZE_STRING);
        $email = filter_var($_POST["Email"],FILTER_SANITIZE_EMAIL);
        $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
        $rePassword = filter_var($_POST["confirm_password"], FILTER_SANITIZE_STRING);
        $err_state = 0;
        $firstName_err_message = "";
        $familyName_err_message = "";
        $email_err_message = "";
        $password_err_message = "";
        $rePassword_err_message = "";
        $sql_massage = "";
        if (empty($firstName))
        {
            $firstName_err_message = "<span>First name can't be empty!</span>";
            $err_state++;
        }
        
        if (empty($familyName))
        {
            $familyName_err_message = "<span>Last name can't be empty!</span>";
            $err_state++;
        }
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
        else
        {
            try {
                $stmt = $conn->prepare('SELECT * FROM users WHERE email=?');
                $stmt->bindParam(1, $email, PDO::PARAM_STR);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if($row)
                {
                    $email_err_message = '<span>Email alredy exist</span>';
                    $err_state++;
                }
            } catch(PDOException $e) {
                $sql_massage = '<span>' . $e->getMessage(). '</span>';
                $err_state++;
            }

        }
        if (strlen($password) < 8)
        {
            $password_err_message = "<span>Password cannot be less than 8 characters</span>";
            $err_state++;
        }
        elseif ($password != $rePassword)
        {
            $rePassword_err_message = "<span>Your passwords do not match</span>";
            $err_state++;
        }
        else
        {
            $hash_password = password_hash( $password, PASSWORD_DEFAULT);
        }

        if ($err_state == 0)
        {
            try{
                $sql = "INSERT INTO users (`firstname`, `lastname`, `email`, `password`) VALUES ('$firstName', '$familyName', '$email', '$hash_password' );";
                $conn->exec($sql);
                $sql_massage = "<span style='background-color: #7fc781;'>New record created successfully</span>";
                $_SESSION['firstname'] = $firstname;
                $_SESSION['lastname'] = $lastname;
                $_SESSION['email'] = $email;
            } catch(PDOException $e) {
                $sql_massage = "<span>" . $sql . "<br>" . $e->getMessage() . "</span>";
            }
        }
        $conn = null;
    }
?>
<form action="" method="post">
    <?php echo (isset($_POST["submit"])) ? $conn_massage : "" ?>
    <?php echo (isset($_POST["submit"])) ? $sql_massage : "" ?>
  <h2>Sign Up</h2>
        <p>
			<label for="name" class="floatLabel">First name</label>
			<input id="name" name="name" type="text" value="<?php echo (isset($_POST["submit"])) ? $firstName : "" ?>">
            <?php echo (isset($_POST["submit"])) ? $firstName_err_message : "" ?>
		</p>		<p>
			<label for="familyName" class="floatLabel">Last name</label>
			<input id="familyName" name="familyName" type="text" value="<?php echo (isset($_POST["submit"])) ? $familyName : "" ?>">
            <?php echo (isset($_POST["submit"])) ? $familyName_err_message : "" ?>
		</p>
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
			<label for="confirm_password" class="floatLabel">Confirm Password</label>
			<input id="confirm_password" name="confirm_password" type="password">
            <?php echo (isset($_POST["submit"])) ? $rePassword_err_message : "" ?>
		</p>
		<p>
			<input type="submit" name="submit" value="Sign Up" id="submit">
		</p>
	</form>

<?php
    include('./view/footer.php');
?>