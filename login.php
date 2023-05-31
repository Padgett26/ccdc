<?php
include "cgi-bin/config.php";
include "include/header.php";
?>
<div style="color:#000000; font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif;">
<form action="index.php" method="post">
Lets get you logged in:<br />
<input type="text" name="userid" maxlength="20" /><br />
<input type="password" name="pass" maxlength="20" /><br />
<input type="hidden" name="login" value="1" />
<input type="submit" value=" Log In " />
</form>
</div>

<?php
include "include/footer.php";