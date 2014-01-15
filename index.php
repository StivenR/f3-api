<?php

$f3=require('framework/base.php');

$f3->set('DEBUG',1);
if ((float)PCRE_VERSION<7.9)
	trigger_error('PCRE version is out of date');

$f3->config('api/configs/config.ini');
$f3->config('api/configs/routes.ini');

$f3->route('GET /',
	function($f3) {
?>
<script type="text/javascript">
    function getUserById() {
    	var id = document.getElementById('input_user').value;
    	if(id.length > 0){
        	window.location.href="v1/users/" + id;
        }
     return false;
    }

    function getMovieById() {
    	var id = document.getElementById('input_movie').value;
    	if(id.length > 0){
        	window.location.href="v1/movies/" + id;
        }
     return false;
    }
</script>
<body>
		<ul>Users
			<li><a href="v1/users">Get All</a></li>
			<li><span>Get One User</span>
				<form onsubmit="return getUserById()">
					<input required type="text" id="input_user" name="input_user" maxlength="6" value="" placeholder="Par exemple : 1"/><br />
					<input type="submit" value="Get One User"/>
				</form>
			</li>
			<li><span>Create</span>
				<form action="v1/users" method="post">
					<label for="input_username">Name</label>
					<input required type="text" id="input_username" name="name" value=""/><br />
					<label for="input_userfirstname">Firstname</label>
					<input required type="text" id="input_userfirstname" name="firstname" value=""/><br />
					<label for="input_useremail">Email</label>
					<input required type="text" id="input_useremail" name="email" value="" placeholder="exemple@domain.com"/><br />
					<label for="input_userpass">Password</label>
					<input required type="password" id="input_userpass" name="pass" maxlength="32" value="" /><br />
					<input type="submit" value="Create"/>
				</form>
			</li>
			<li><a href="">Update</a></li>
			<li><a href="">Delete</a></li>
		</ul>
		<ul>Movies
			<li><a href="v1/movies">Get All</a></li>
			<li><span>Get One Film</span>
				<form onsubmit="return getMovieById()">
					<input required type="text" id="input_movie" name="input_movie" max="6" value="" placeholder="Par exemple : 1"/><br />
					<input type="submit" value="Get One Movie"/>
				</form>
			</li>
			<li>
				<span>Create</span>
				<form action="v1/movies" method="post">
					<label for="input_moviename">Name</label>
					<input required type="text" id="input_moviename" name="name" value=""/><br />
					<label for="input_movierelease">Release</label>
					<input required type="date" id="input_movierelease" name="release" value=""/><br />
					<label for="input_moviesynopsis">Synopsis</label><br />
					<textarea rows="4" cols="30" required id="input_moviesynopsis" name="synopsis" value=""></textarea><br />
					<input type="submit" value="Create"/>
				</form>
			</li>
			<li><a href="">Update</a></li>
			<li><a href="">Delete</a></li>
		</ul>
	</body>
<?php
	}
);

$f3->run();

