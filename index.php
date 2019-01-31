 <?php
require_once("dbcontroller.php");
$db_handle = new DBController();
$query ="SELECT * FROM country";
$results = $db_handle->runQuery($query);
if(isset($_POST['save']))
{
	$a=$_POST["name"];
	$b=$_POST["address"];
	$sql="INSERT INTO `user`(`name`,`address`) VALUES ('$a','$b')";
	$result=$db_handle->runQuery($query);
	header("Location:view.php");
}
?> 
<html>
<head>
<TITLE>Countries and States</TITLE>
<head>
<style>
body{width:610px;font-family:calibri;}
.frmDronpDown {border: 1px solid #7ddaff;background-color:#C8EEFD;margin: 2px 0px;padding:40px;border-radius:4px;}
.demoInputBox {padding: 10px;border: #bdbdbd 1px solid;border-radius: 4px;background-color: #FFF;width: 50%;}
.row{padding-bottom:15px;}
</style>
<script src="jquery-3.2.1.min.js" type="text/javascript"></script>
<script>
function getState(val) {
	$.ajax({
	type: "POST",
	url: "getState.php",
	data:'country_id='+val,
	success: function(data){
		$("#state-list").html(data);
		getCity();
	}
	});
}


function getCity(val) {
	$.ajax({
	type: "POST",
	url: "getCity.php",
	data:'state_id='+val,
	success: function(data){
		$("#city-list").html(data);
	}
	});
}

</script>
</head>
<body>
<div class="frmDronpDown">
<div class="row">
<label>Name:</label> 
<input type="text" name="name"/><br><br>
<label>Address:</label> 
<input type="text" name="address"/><br><br>
<label>Country:</label><br/> 
<select name="country" id="country-list" class="demoInputBox" onChange="getState(this.value);">
<option value disabled selected>Select Country</option>
<?php
foreach($results as $country) {
?>
<option value="<?php echo $country["countryID"]; ?>"><?php echo $country["country_name"]; ?></option>
<?php
}
?>
</select>
</div>
<div class="row">
<label>State:</label><br/>
<select name="state" id="state-list" class="demoInputBox" onChange="getCity(this.value);">
<option  value="">Select State</option>
</select>
</div>
<div class="row">
<label>District:</label><br/>
<select name="city" id="city-list" class="demoInputBox">
<option value="">Select District</option>
</select><br><br><br>
<input style="color:red" type="submit" value="save" name="save"/>
</div>
</div>
</body>
</html>