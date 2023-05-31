<?php
include "cgi-bin/config.php";
include "include/header.php";
?>
<div style="font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif;">
<?php
if ($loggedin == "1") {
	if (filter_input ( INPUT_POST, 'user', FILTER_SANITIZE_STRING )) {
		$user = filter_input ( INPUT_POST, 'user', FILTER_SANITIZE_STRING );
		$stmt = $db->prepare ( "SELECT userid FROM users WHERE id=?" );
		$stmt->execute ( array (
				$user
		) );
		$row = $stmt->fetch ();
		if ($row) {
			$userid = $row ['userid'];
			echo "<form action='users.php' method='post'>\n";
			echo "User id: <input type='text' name='userid' value='$userid' /><br />\n";
			echo "Password: <input type='password' name='pass' /><br />\n";
			echo "Delete this user: <input type='checkbox' name='deluser' value='1' /><br />\n";
			echo "<input type='hidden' name='edituser' value='$user' /><input type='submit' value=' Make changes ' /></form>";
		}
	}

	if (filter_input ( INPUT_POST, 'edituser', FILTER_SANITIZE_STRING )) {
		$id = filter_input ( INPUT_POST, 'edituser', FILTER_SANITIZE_STRING );
		$userid = filter_input ( INPUT_POST, 'userid', FILTER_SANITIZE_STRING );
		$pass = filter_input ( INPUT_POST, 'pass', FILTER_SANITIZE_STRING );
		$deluser = filter_input ( INPUT_POST, 'deluser', FILTER_SANITIZE_NUMBER_INT );
		$hidepwd = md5 ( "$salt1$pass$salt2" );
		if ($deluser == "1") {
			$stmt = $db->prepare ( "DELETE FROM users WHERE id=?" );
			$stmt->execute ( array (
					$id
			) );
			echo "User deleted...";
		} else {
			if ($id == "new") {
				$stmt = $db->prepare ( "INSERT INTO users VALUES" . "(NULL,?,?,'0','0')" );
				$stmt->execute ( array (
						$userid,
						$hidepwd
				) );
				echo "User added...";
			} else {
				if ($userid) {
					$stmt = $db->prepare ( "UPDATE users SET userid=? WHERE id=?" );
					$stmt->execute ( array (
							$userid,
							$id
					) );
				}
				if ($pass) {
					$stmt = $db->prepare ( "UPDATE users SET pwd=? WHERE id=?" );
					$stmt->execute ( array (
							$hidepwd,
							$id
					) );
				}
			}
		}
	}
}
?>
</div>
<?php
include "include/footer.php";