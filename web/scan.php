<?php
    $master_config = parse_ini_file("../etc/master.ini");
    $scanning_library = $_REQUEST['library'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Awesome Box Barcode Scan</title> 

<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
<link href="images/favicon.ico" rel="shortcut icon">
<style>
body {
  background-image:url('images/awesome.png');
  background-repeat: no-repeat;
}

h1 {
  color: #11cbf7;
}

#innerlay {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 3px solid #bee620;
    border-radius: 3px 3px 3px 3px;
    height: 230px;
    margin: 80px auto 0;
    padding: 30px;
    width: 580px;
}
#barcode {
	border: solid 1px #bee620;
	font-size:24px;
	width:375px;
	padding:10px;
	margin-top:25px;
}

#scanning_library {
	border: solid 1px #bee620;
	font-size:18px;
	width:125px;
	padding:0px;
	height:28px;
}

#scanned_at {
  margin: 25px auto 0;
  font-size:14px;
  width:205px;
  padding-left:375px;
}

.added-title {
  margin-left:8px;
}

.bar {
  width:10%;
}
</style>
<script type="text/javascript">
var barcode_method = "<?php echo $master_config["BARCODE_METHOD"]; ?>";
</script>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/scan.js">
</script>
</head>
<body>
<div id="innerlay">
	<h1>Awesome Box Barcode Scan</h1>
	<form id="lookup">
    <input type="text" id="barcode" />
    <input type="submit" value="submit" id="submit" style="display:none;" />
  </form>
  <div class="progress" style="display:none;">
    <div class="bar" style="width: 10%;"></div>
  </div>
  <div class="alert alert-error" style="display:none;"></div>
  <div class="alert alert-success" style="display:none;">
    <h4 class="alert-heading">Awesome!</h4>
    <span class="label label-success"><i class="icon-ok-sign icon-white"></i> Added</span> <span class="added-title">
  </div>
</div>
<div id="scanned_at">
    Scanned at 
    <select id="scanning_library">
      <?php 
        foreach($master_config['LIBRARIES'] as $code => $library) {
          if($scanning_library == $code) $selected = 'selected';
          else $selected = '';
          echo "<option value='$code' $selected>$library</option>";
        }
      ?>
    </select>
    </div>
</body>
</html>