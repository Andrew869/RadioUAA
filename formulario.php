<h2>Radio UAA - Administracion</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <label for="username">Username</label>
  <input type="text" id="username" name="username" value="<?php echo $username_input;?>">
  <span class="text-danger"><?php echo "*$userErr";?></span>
  <br><br> <!-- temporal -->
  <label for="password">Password</label>
  <input type="password" id="password" name="password">
  <span class="text-danger"><?php echo "*$passwdErr";?></span>
  <br><br> <!-- temporal -->
  <input type="submit" name="submit" value="Submit">  
</form>