<?php
if(!session_id()){
	session_start();
}
include_once(dirname(__FILE__) . '/db.php');
$con = new DB_con();
if(isset($_POST['login'])){
	$username = $con->escape($_POST['username']);
	$password = $con->escape($_POST['password']);
	$sql = $con->cek_login($username,$password);
	if (!$sql) {
		die("Error: Data not found..");
	}
	$result = mysqli_num_rows($sql);
	$data = mysqli_fetch_array($sql);
	if($result == 1){
		$_SESSION['id_user'] = $data['id_user'];
		$_SESSION['username'] = $data['username'];
		$_SESSION['password'] = $data['password'];
		header('Location: setting_header.php');
	}
}

?>
<div class="header">
	<img src="/uploadslogo.png" alt="logo" width="100" height="50" />
</div>
<form action="" method="post">
	<table>
		<tr> 
			<td valign="top"><label>Nama Login</label></td>
			<td valign="top">:</td>
			<td><input placeholder="Username" type="text" name="username" required></td>
		</tr>
		<tr> 
			<td valign="top"><label>Kata Sandi</label></td>
			<td valign="top">:</td>
			<td><input placeholder="Password" type="password" name="password" required></td>
		</tr>
		<tr>
			<td colspan="3" align="right"><button type="submit" name="login" value="1">Login</button></td>
		</tr>
	</table>
</form>
<?php
include_once 'footer.php';


