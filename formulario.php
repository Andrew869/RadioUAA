<h2>Radio UAA - Administracion</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  user: <input type="text" name="user" value="<?php echo $user;?>">
  <span class="error">* <?php echo $userErr;?></span>
  <br><br>
  password: <input type="password" name="passwd" value="<?php echo $passwd;?>">
  <span class="error">* <?php echo $passwdErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>