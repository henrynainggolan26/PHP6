<?php
session_start();
include_once 'db.php';
include_once 'header_frontend.php';
$count_sidebar = isset($_SESSION['count_sidebar']) ? $_SESSION['count_sidebar'] : null; 
$con = new DB_con();
$sql = $con->select_title();
while($result = mysqli_fetch_array($sql)){
	$content_temp= $result['content'];
	$content_new[] = $result['content'];
	$createat[] =  $result['create_at'];
	$updateat[] =  $result['update_at'];
	$title[] = $result['title'];
	$id_post[] = $result['id_post'];
	if(strlen($content_temp)>=20){
		$content[] = substr($content_temp,0, 20);
	}
	else{
		$content[] = $content_temp;
	}
}


if(!$sql) {
	die("Error: Data not found..");
}

$editid = 0;
if(isset($_GET['id'])){
	$editid = $_GET['id']; 
}
echo "<table align='left' width='70%'>";
echo "<tr >";	
echo"<td> Title : " .$title[$editid]."</td>";
echo "</tr>";
echo "<tr>";
echo"<td> Content : " .$content_new[$editid]."</td>";
echo "</tr>";
echo "</tr>";
echo"<td> Create at : " .$createat[$editid]." ||
Create at : " .$updateat[$editid]."</td>" ;
echo "</tr>";
echo "</table>";

if($count_sidebar < 5){
	echo "<table align='right' width='30%'>";
	echo "<tr>5 Latest Blog :";
	for($i=0;$i<5;$i++)
	{
		echo "<td> <a href ='index.php?id=$i'>" .$content[$i]. "</td>";
		echo "</tr>";
	}echo "</table>";
}
else{
	echo "<table>";
	echo "<tr>". $count_sidebar ." Latest Blog :";
	for($i=0;$i<$count_sidebar;$i++)
	{
		echo "<td> <a href ='index.php?id=$i'>" .$content[$i]. "</td>";
		echo "</tr>";
	}
	echo "</table>";
}

$query = $con->select_comment();
while($result = mysqli_fetch_array($query)){
	$name= $result['name'];
	$email= $result['email'];
	$time= $result['time'];
	$comment= $result['comment'];
	$reply = $result['reply'];
	echo "<table align='left' width='100%'>";
	echo "<tr >";	
	echo"<td>Name : " .$name."</td>";
	echo "</tr>";
	echo "<tr>";
	echo"<td> Email : " .$email."</td>";
	echo "</tr>";
	echo "</tr>";
	echo"<td> Create at : " .$time."</td>" ;
	echo "</tr>";
	echo "<tr>";
	echo"<td> Comment : " .$comment."</td>";
	echo "</tr>";
	echo "<tr>";
	echo"<td> Reply : " .$reply."</td>";
	echo "</tr>";
	echo "</table>";
}

?>

<form action="" method="post">
	<table>
		<th valign="top"><label>Leave a Comment</label></th>
		<tr> 
			<td valign="top"><label>Your Name</label></td>
			<td valign="top">:</td>
			<td><input placeholder="Your name" size="30" type="text" name="name" required></td>
		</tr>
		<tr> 
			<td valign="top"><label>Your Email</label></td>
			<td valign="top">:</td>
			<td><input placeholder="Your email" size="30" type="email" name="email" required></td>
		</tr>
		<tr> 
			<td valign="top"><label>Your Comment</label></td>
			<td valign="top">:</td>
			<td><textarea name="comment" rows="5" cols="50" placeholder="Your Comment" required ></textarea><br><br></td>
		</tr>
		<tr>
			<td colspan="3" align="right"><button type="submit" name="sendmessage">Send</button></td>
		</tr>
	</table>
</form>
<?php
if(isset($_POST['sendmessage'])){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$time = date("Y-m-d H:i:s");
	$comment = $_POST['comment'];
	if($name && $email && $comment != ""){
		$con->insert_comment($name, $email, $time, $comment);
		header('Location: index.php');
	}
	else{
		echo "Correct input";
	}	
}
include_once('footer.php');
