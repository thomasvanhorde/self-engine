<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>{ $title }</title>
		<link href="{ $SYS_FOLDER }themes/ac_login.css" type="text/css" media="screen" rel="stylesheet" />
	</head>
	<body id="login">

		<div id="wrappertop"></div>
			<div id="wrapper">
                <div id="content">
                    <div id="header">
                        try admin/admin <br />
                        <span style="color:red;">{ $return_access }</span>
                    </div>
                    <div id="darkbanner" class="banner320">
                        <h2>Login</h2>
                    </div>
                    <div id="darkbannerwrap">
                    </div>
                    <form method="post" action="">

                    <fieldset class="form">
                        <input type="hidden" name="todo" value="access_control[connect]" />
                        <p>
                            <label for="user_name">Username:</label>
                            <input name="user_name" id="user_name" type="text" value="" />

                        </p>
                        <p>
                            <label for="user_password">Password:</label>
                            <input name="user_password" id="user_password" type="password" />
                        </p>
                        <button type="submit" class="positive" name="Submit">
                            <img src="{ $SYS_FOLDER }themes/ac_login/key.png" alt="Announcement"/>Login
                        </button>
                        <a href="{ $SYS_FOLDER }ac_login/disconnect/">Disconnect</a>
                      </fieldset>
                    </form>
                </div>
			</div>
    </body>
</html>