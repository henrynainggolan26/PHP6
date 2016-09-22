<?php
include_once('header.php');
include_once 'db.php';
session_start();
//set session when logout 
if($_SESSION['username'] == ""){
	header('Location: login.php');
}

$con = new DB_con();
$datecreate = " ";
if(isset($_GET['edit_id'])){
	$editid = $_GET['edit_id'];
	$sql = $con->select_update_comment($editid);
	$result = mysqli_fetch_array($sql);
	if (!$sql) {
		die("Error: Data not found..");
	}
	$reply=$result['reply'] ;
	?>
	<form action="" method="post">
		<table align="center" >
			<tr> 
				<td valign="top"><label>Comment Reply</label></td>
				<td valign="top">:</td>
				<td><textarea name="reply" rows="5" cols="50" placeholder="Your Comment Reply" required ><?php echo $reply?></textarea><br><br></td>
			</tr>
			<tr>
				<td colspan="3" align="right"><button type="submit" name="save">Save</button></td>
			</tr>
		</table>
	</form>
	<?php
}

?>

<?php 
//show data
$result = $con->select_comment();
echo "<table border='1' cellpadding='5' align='center'>"; 
echo "<tr> <th> ID </th> <th> Name </th>  <th> Email </th> <th> Comment at </th><th> Reply </th><th> Action </th></tr>";
while ($test = mysqli_fetch_array($result)) {
	$id = $test['id'];
	echo "<tr>";	
	echo"<td>" .$test['id']."</td>";
	echo"<td>" .$test['name']."</td>";
	echo"<td>". $test['email']. "</td>";
	echo"<td>". $test['comment']. "</td>";
	echo"<td>". $test['reply']. "</td>";	
	echo"<td> <a href ='setting_comment.php?edit_id=$id'><center>Edit</center></a> <a href ='setting_comment.php?delete_id=$id'><center>Delete</center></a>";
	echo "</tr>";
}
echo "</table>";

//edit data
if(isset($_POST['save'])){
	$reply = $con->escape($_POST['reply']);
	if($reply != ""){
		$con->update_comment($reply, $editid);
		header('Location: setting_comment.php');
	}
	else{
		echo "Correct input";
	}	
}

//delete data
if(isset($_GET['delete_id'])){
	$id = $_GET['delete_id'];
	$res = $con->delete($id);
	header('Location: setting_header.php');
}
include_once 'footer.php';