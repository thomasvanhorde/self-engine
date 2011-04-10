<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr"><head>



<!--
	http://ponjoh.s3.amazonaws.com/HTML%20Templates/Simpla%20Admin/index.html#
-->
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<title>{ $title }</title>

		<!--                       CSS                       -->

		<!-- Reset Stylesheet -->
		<link rel="stylesheet" href="http://{ $HTTP_HOST }/{ $SYS_FOLDER }/themes/admin/reset.css" type="text/css" media="screen">

		<!-- Main Stylesheet -->
		<link rel="stylesheet" href="http://{ $HTTP_HOST }/{ $SYS_FOLDER }/themes/admin/style.css" type="text/css" media="screen">

        <!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
        <link rel="stylesheet" href="http://{ $HTTP_HOST }/{ $SYS_FOLDER }/themes/admin/invalid.css" type="text/css" media="screen">

        <!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
        <link rel="stylesheet" href="http://{ $HTTP_HOST }/{ $SYS_FOLDER }/themes/admin/datepicker/datepicker.css" type="text/css" media="screen">

		<!-- Colour Schemes

		Default colour scheme is green. Uncomment prefered stylesheet to use it.

		<link rel="stylesheet" href="resources/css/blue.css" type="text/css" media="screen" />

		<link rel="stylesheet" href="resources/css/red.css" type="text/css" media="screen" />

		-->


		<!--                       Javascripts                       -->

		<!-- jQuery -->
		<script type="text/javascript" src="http://{ $HTTP_HOST }/{ $SYS_FOLDER }/js/admin/jquery-1.js"></script>

		<!-- jQuery Configuration -->
		<script type="text/javascript" src="http://{ $HTTP_HOST }/{ $SYS_FOLDER }/js/admin/simpla.js"></script>

		<!-- Facebox jQuery Plugin -->
		<script type="text/javascript" src="http://{ $HTTP_HOST }/{ $SYS_FOLDER }/js/admin/facebox.js"></script>

		<!-- jQuery WYSIWYG Plugin -->
        <script type="text/javascript" src="http://{ $HTTP_HOST }/{ $SYS_FOLDER }/js/admin/jquery.js"></script>

    <script type="text/javascript" src="http://{ $HTTP_HOST }/{ $SYS_FOLDER }/js/admin/datepicker/datepicker.packed.js"></script>


	</head><body><div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->

		<div id="sidebar"><div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->

			<h1 id="sidebar-title"><a href="#">Simpla Admin</a></h1>

			<!-- Logo (221px wide) -->
			<a href="#"><img id="logo" src="http://{ $HTTP_HOST }/{ $SYS_FOLDER }/themes/admin/style/logo.png" alt="Simpla Admin logo"></a>

			<!-- Sidebar Profile links -->
			<div id="profile-links">
				Hello, <a href="#" title="Edit your profile">John Doe</a>, you have <a href="#messages" rel="modal" title="3 Messages">3 Messages</a><br>
				<br>
				<a href="#" title="View the Site">View the Site</a> | <a href="#" title="Sign Out">Sign Out</a>
			</div>

			{ $mainNav }

			<div id="messages" style="display: none;"> <!-- Messages are shown when a link with these attributes are clicked: href="#messages" rel="modal"  -->

				<h3>3 Messages</h3>

				<p>
					<strong>17th May 2009</strong> by Admin<br>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue.
					<small><a href="#" class="remove-link" title="Remove message">Remove</a></small>
				</p>

				<p>
					<strong>2nd May 2009</strong> by Jane Doe<br>
					Ut a est eget ligula molestie gravida. Curabitur massa. Donec
eleifend, libero at sagittis mollis, tellus est malesuada tellus, at
luctus turpis elit sit amet quam. Vivamus pretium ornare est.
					<small><a href="#" class="remove-link" title="Remove message">Remove</a></small>
				</p>

				<p>
					<strong>25th April 2009</strong> by Admin<br>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue.
					<small><a href="#" class="remove-link" title="Remove message">Remove</a></small>
				</p>

				<form action="" method="post">

					<h4>New Message</h4>

					<fieldset>
						<textarea class="textarea" name="textfield" cols="79" rows="5"></textarea>
					</fieldset>

					<fieldset>

						<select name="dropdown" class="small-input">
							<option selected="selected" value="option1">Send to...</option>
							<option value="option2">Everyone</option>
							<option value="option3">Admin</option>
							<option value="option4">Jane Doe</option>
						</select>

						<input class="button" value="Send" type="submit">

					</fieldset>

				</form>

			</div> <!-- End #messages -->

		</div></div> <!-- End #sidebar -->

		<div id="main-content">
            { $content }
		</div> <!-- End #main-content -->

	</div>    <div id="facebox" style="display: none;">       <div class="popup">         <table>           <tbody>             <tr>               <td class="tl"></td><td class="b"></td><td class="tr"></td>             </tr>             <tr>               <td class="b"></td>               <td class="body">                 <div class="content">                 </div>                 <div class="footer">                   <a href="#" class="close">                     <img src="themes/admin/style/closelabel.gif" title="close" class="close_image">                   </a>                 </div>               </td>               <td class="b"></td>             </tr>             <tr>               <td class="bl"></td><td class="b"></td><td class="br"></td>             </tr>           </tbody>         </table>       </div>     </div></body></html>