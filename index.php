<?php
include 'config.php';
session_start();
// $_SESSION['email'] contains email
// $_SESSION['name'] contains name
if(isset($_SESSION['email']))
{
	$email = $_SESSION['email'];
	$que = mysql_query("SELECT * from details where email='".$email."'") or die(mysql_error());
	$arr = mysql_fetch_array($que);
	$dob = $arr[2];
	$phone = $arr[3];
	$address = $arr[4];
	$diseases = $arr[5];
	$lastUpdate = $arr[6];
	$trust = $arr[7];
}
?>
<!DOCTYPE html>
<html>
<!--image dimensions for card: 200px X 150px-->
<!--begin of head-->
<head lang="en">
    <meta charset="UTF-8">
    <meta name="author" content="Varun Bawa & Rananjay Chauhan">
	<meta name="google-signin-client_id" content="77475544713-jv9kgd58uij8cddkpjbusg3mt5nvdr96.apps.googleusercontent.com">
    <link href="css/materialize.min.css" rel="stylesheet">
    <script src="js/jquery-2.1.1.min.js"></script>
	<script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="js/materialize.min.js"></script>
    <link id="page_favicon" href="favicon.ico" rel="icon" type="image/x-icon">
    <title>Hackathon Health Manager</title>
    <style>
        .quiz_margin{
            margin: 35px 41px 7px 0px;
        }
        .content_margin{
            margin: 0px 0px 0px 11px;
        }
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        main {
            flex: 1 0 auto;
        }
    </style>
</head>
<!--end of Head-->

<!--begin of Body-->

<body>

<!--Color for day 'blue-grey darken-1'-->
<!--Color for night 'blue-grey darken-4'-->
    <!--Begin header-->
    <nav>
<!--Php Code below sets the theme color according to time of day-->
<?php
date_default_timezone_set('asia/calcutta');
$hr=date('h'); //To get hours
$ap=date('A'); //To get AM or PM
if($ap=='PM')
	$hr=$hr+12;
if($hr>=19 || $hr<=5)
{
?>
	<div class="nav-wrapper blue-grey darken-4">
<?php
}
else
{
?>
	<div class="nav-wrapper blue-grey darken-1">
<?
}
?>
            <img class="left" style="padding-left: 10px;" height="60" width="100" src="images/mii.png">
			<a href="#!" class="brand-logo">Health Manager <?php if(isset($_SESSION['name'])){ $name=$_SESSION['name']; echo "<font size='3pt'> for $name </font>";}?></a>
            <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
            <ul class="right hide-on-med-and-down">
                <li class="active"><a href="index.php">Home</a></li>
			<!--If User is Logged in Display Logout Option Else Login Option-->
            <?php
			if(empty($_SESSION['name']))
			{
			?>
		    	<li><a href="#login" class="modal-trigger">Login</a></li>
                <li><a href="register.html">Register</a></li>
				<li><a href="about.html">About</a></li>
			<?php
			}
			else
			{
			?>
				<li><a href="Tell-Us.php">Tell Us More</a></li>
				<li><a href="about.html">About</a></li>
				<li><a href="logout.php">Logout</a></li>
			<?php
			}
			?>
            </ul>
            <ul class="side-nav" id="mobile-demo">
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="#login">Login</a></li>
                <li><a href="register.html">Register</a></li>
                <li><a href="about.html">About</a></li>
            </ul>
        </div>
    </nav>
    <!--end Header-->

    <!--Begin Content-->
    <main class="container">
	<?php if(isset($_SESSION['name']))
	{
	?>
	<div class="row">
		<div class="col s12 m14">
          <div class="card blue-grey darken-1">
            <div class="center card-content white-text">
			<span class="left card-title"><?php if(isset($_SESSION['name'])){ $name=$_SESSION['name']; echo "$name's Profile";}?></span>
				<div class="right">
					<img style="border-radius: 50%;" src="<?php echo 'uploads/dp/'.$email.'.jpg';?>" height="80" width="80">
				</div>
			<br><br><br><br><hr>
			<?php $space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" ?>
			<div class="row">
			<p align="left">
				Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $space."|".$space.$name;?><br><br>
				DOB &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $space."|".$space.$dob;?><br><br>
				Phone &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $space."|".$space.$phone;?><br><br>
				Address&nbsp;&nbsp;<?php echo $space."|".$space.$address;?><br><br>
				Exercises<?php echo $space."|".$space."Jogging";?><br><br>
				
				Diseases<?php 	echo $space."|<br><br>";
								$count = substr_count($diseases, ',');
								$disarr = array();
								$disarr = (explode(",",$diseases));
								for($a=0;$a<=$count;$a++)
								{
									$localQue = mysql_query("SELECT * from cures where Diseases='".$disarr[$a]."'");
									$sol = mysql_fetch_array($localQue);
									$med = $sol[1];
									$time = $sol[2];
									$num = $sol[3];
									echo $space."&nbsp;&nbsp;&nbsp;&nbsp;Disease | ".$disarr[$a]."<br>".$space.$space.$space.$space.$space."Medicine ".$space."| &nbsp;".$med."<br>".$space.$space.$space.$space.$space."Time ".$space.$space."| &nbsp;".$time."<br>".$space.$space.$space.$space.$space."Times a Day &nbsp;| &nbsp;".$num."<br>";
								}
						?><br>
			</p><hr><hr><hr><p align="center">
					<form action="upload.php" method="post" enctype="multipart/form-data">
						Select Report Image to upload:<br><br>
							<input type="file" name="fileToUpload" id="fileToUpload"></input><br><br>
							<button class="btn waves-effect waves-light" type="submit" name="action">Submit
								<i class="mdi-content-send right"></i>
							</button>
					</form>
					<br><hr><hr>
					<form action="upload-img.php" method="post" enctype="multipart/form-data">
						Select Your Display Image to upload:<br><br>
							<input type="file" name="fileToUpload" id="fileToUpload"></input><br><br>
							<button class="btn waves-effect waves-light" type="submit" name="action">Submit
								<i class="mdi-content-send right"></i>
							</button>
					</form>
				</p><hr>
				</div>
            </div>
          </div><hr>
		  
	
        </div>
	</div>
	<?php
	}
	else
	{
	?>
	<div class="row"><br>
		<div class="col s12 m14">
          <div class="card blue-grey darken-1"><br>
			<p align="center" style="font-size: 30px; color: white;"><u>Hackathon Health Manager</u></p>
			
            <div class="center card-content white-text">
			<iframe src="with-jquery.html" width="600" height="301.5"></iframe>
			<p>Hackathon Health Manager is a Personilized Health Manager which can be used as a Personal Doctor for you and your whole Family. </p>
            </p>
			<ul><u>Features</u>
				<li>Checks Your Health Status</li>
				<li>Check Your Reports</li>
				<li>Provide Medicines</li>
			</ul>
			<ul><u>Features Yet to be Added</u>
				<li>Automatic Report Scanner</li>
				<li>Health and Diet Advisor</li>
				<li>I.O.T. Integration</li>
			</ul>
			</div>
          </div>
        </div>
	</div>
	<?php
	}
	?>
	</main>
    <!--end Content-->

    <!--Begin Footer-->
<!--Php Code below sets the theme color for footer according to time of day-->
<?php
date_default_timezone_set('asia/calcutta');
$hr=date('h'); //To get hours
$ap=date('A'); //To get AM or PM
if($ap=='PM')
	$hr=$hr+12;
if($hr>=19 || $hr<=5)
{
?>
	<footer class="page-footer blue-grey darken-4 darken-2">
<?php
}
else
{
?>
	<footer class="page-footer blue-grey darken-1">
<?
}
?>
	    <div class="footer-copyright">
            <div class="container">
                Developed and Maintained by Team C.L.
                <a class="grey-text text-lighten-4 right" href="http://materializecss.com/" target="_blank">Developed using materializecss</a>
            </div>
        </div>
    </footer>
    <!--end Footer-->

    <!-- Login Modal Structure -->
    <div id="login" class="modal">
        <div class="modal-content">
            <h4>Login</h4>
            <div class="row">
                <form class="col s12" method="POST" action="logincheck.php">
                    <div class="row">
                        <div class="input-field col s6">
                            <i class="mdi-action-account-circle prefix"></i>
                            <input id="icon_prefix" type="text" class="validate" name="email">
                            <label for="icon_prefix">Email ID</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="mdi-action-lock prefix"></i>
                            <input id="icon_telephone" type="password" class="validate" name="password">
                            <label for="icon_telephone">Password</label>
                        </div>
                    </div>
					<div class="modal-footer">
						<button class="modal-action modal-close waves-effect waves-green btn-flat" type="submit">Login
							<i class="mdi-content-send right"></i>
						</button>
					</div>
                </form>
				<div class="g-signin2" data-onsuccess="onSignIn"></div><br>
				<div id="fb-root"></div><div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" data-auto-logout-link="false"></div>
            </div>
        </div>
    </div>
    <!--end of modal-->
</body>
<!--end of Body-->

<!--Begin of Script Section-->
<!--Google Login Function for Information Gathering -->
<script>
  function onSignIn(googleUser) {
  var profile = googleUser.getBasicProfile();
  console.log('ID: ' + profile.getId()); // Will Use an ID token instead.
  console.log('Name: ' + profile.getName());
  console.log('Image URL: ' + profile.getImageUrl());
  console.log('Email: ' + profile.getEmail());
	}
	//Not adding Token since no Active URL for Web App is present
</script>

<!-- Adding The Facebook Login Script to Gather Information Using Access Tokens -->
		<script>
			(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=1708173519404671";
			fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>    
		
		<script>

        //responsive initialization
        $(".button-collapse").sideNav();

        //Tooltip initialization
        $(document).ready(function(){
            $('.tooltipped').tooltip({delay: 50});
        });

        //Modal Initialization
        $(document).ready(function(){
            // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
            $('.modal-trigger').leanModal();
        });
    </script>
	<script>
		// This is called with the results from from FB.getLoginStatus().
		var _0xcff5=["\x73\x74\x61\x74\x75\x73\x43\x68\x61\x6E\x67\x65\x43\x61\x6C\x6C\x62\x61\x63\x6B","\x6C\x6F\x67","\x73\x74\x61\x74\x75\x73","\x63\x6F\x6E\x6E\x65\x63\x74\x65\x64","\x6E\x6F\x74\x5F\x61\x75\x74\x68\x6F\x72\x69\x7A\x65\x64","\x69\x6E\x6E\x65\x72\x48\x54\x4D\x4C","\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x42\x79\x49\x64","\x50\x6C\x65\x61\x73\x65\x20\x6C\x6F\x67\x20","\x69\x6E\x74\x6F\x20\x74\x68\x69\x73\x20\x61\x70\x70\x2E","\x69\x6E\x74\x6F\x20\x46\x61\x63\x65\x62\x6F\x6F\x6B\x2E","\x67\x65\x74\x4C\x6F\x67\x69\x6E\x53\x74\x61\x74\x75\x73","\x66\x62\x41\x73\x79\x6E\x63\x49\x6E\x69\x74","\x7B\x79\x6F\x75\x72\x2D\x61\x70\x70\x2D\x69\x64\x7D","\x76\x32\x2E\x35","\x69\x6E\x69\x74","\x73\x63\x72\x69\x70\x74","\x66\x61\x63\x65\x62\x6F\x6F\x6B\x2D\x6A\x73\x73\x64\x6B","\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x73\x42\x79\x54\x61\x67\x4E\x61\x6D\x65","\x63\x72\x65\x61\x74\x65\x45\x6C\x65\x6D\x65\x6E\x74","\x69\x64","\x73\x72\x63","\x2F\x2F\x63\x6F\x6E\x6E\x65\x63\x74\x2E\x66\x61\x63\x65\x62\x6F\x6F\x6B\x2E\x6E\x65\x74\x2F\x65\x6E\x5F\x55\x53\x2F\x73\x64\x6B\x2E\x6A\x73","\x69\x6E\x73\x65\x72\x74\x42\x65\x66\x6F\x72\x65","\x70\x61\x72\x65\x6E\x74\x4E\x6F\x64\x65","\x57\x65\x6C\x63\x6F\x6D\x65\x21\x20\x20\x46\x65\x74\x63\x68\x69\x6E\x67\x20\x79\x6F\x75\x72\x20\x69\x6E\x66\x6F\x72\x6D\x61\x74\x69\x6F\x6E\x2E\x2E\x2E\x2E\x20","\x2F\x6D\x65","\x53\x75\x63\x63\x65\x73\x73\x66\x75\x6C\x20\x6C\x6F\x67\x69\x6E\x20\x66\x6F\x72\x3A\x20","\x6E\x61\x6D\x65","\x54\x68\x61\x6E\x6B\x73\x20\x66\x6F\x72\x20\x6C\x6F\x67\x67\x69\x6E\x67\x20\x69\x6E\x2C\x20","\x21","\x61\x70\x69"];function statusChangeCallback(_0xec0fx2){console[_0xcff5[1]](_0xcff5[0]);console[_0xcff5[1]](_0xec0fx2);if(_0xec0fx2[_0xcff5[2]]===_0xcff5[3]){testAPI()}else {if(_0xec0fx2[_0xcff5[2]]===_0xcff5[4]){document[_0xcff5[6]](_0xcff5[2])[_0xcff5[5]]=_0xcff5[7]+_0xcff5[8]}else {document[_0xcff5[6]](_0xcff5[2])[_0xcff5[5]]=_0xcff5[7]+_0xcff5[9]}}}function checkLoginState(){FB[_0xcff5[10]](function(_0xec0fx2){statusChangeCallback(_0xec0fx2)})}window[_0xcff5[11]]=function(){FB[_0xcff5[14]]({appId:_0xcff5[12],cookie:true,xfbml:true,version:_0xcff5[13]});FB[_0xcff5[10]](function(_0xec0fx2){statusChangeCallback(_0xec0fx2)})};(function(_0xec0fx4,_0xec0fx5,_0xec0fx6){var _0xec0fx7,_0xec0fx8=_0xec0fx4[_0xcff5[17]](_0xec0fx5)[0];if(_0xec0fx4[_0xcff5[6]](_0xec0fx6)){return};_0xec0fx7=_0xec0fx4[_0xcff5[18]](_0xec0fx5);_0xec0fx7[_0xcff5[19]]=_0xec0fx6;_0xec0fx7[_0xcff5[20]]=_0xcff5[21];_0xec0fx8[_0xcff5[23]][_0xcff5[22]](_0xec0fx7,_0xec0fx8)}(document,_0xcff5[15],_0xcff5[16]));function testAPI(){console[_0xcff5[1]](_0xcff5[24]);FB[_0xcff5[30]](_0xcff5[25],function(_0xec0fx2){console[_0xcff5[1]](_0xcff5[26]+_0xec0fx2[_0xcff5[27]]);document[_0xcff5[6]](_0xcff5[2])[_0xcff5[5]]=_0xcff5[28]+_0xec0fx2[_0xcff5[27]]+_0xcff5[29]})}
	</script>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<!--End of Script Section-->
</html>