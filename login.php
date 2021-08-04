<?php include "globals/header.php";
if (isset($_POST) && !empty($_POST['email'])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $result = crud("SELECT * FROM `filmincubator_expert_registration` WHERE email = '$email' AND password = '$password'","sql",1);
    if (!empty($result)) {
        $_SESSION['expert'] = $result;
        echo "
        <script>
            location.href = 'profile.php';
        </script>";
    } else {
        echo "
	<script>
		alert('Your email and password are not match');
		location.href = location.href;
	</script>";
    }
}
?>
<link rel="stylesheet" href="css/login.css">
<div class="login">
    <h1>Login</h1>
    <form method="post" action="">
        <input type="text" name="email" placeholder="Email" required="required" />
        <input type="password" name="password" placeholder="Password" required="required" />
        <button type="submit" class="btn btn-primary btn-block btn-large">Go...</button>
    </form>
</div>
