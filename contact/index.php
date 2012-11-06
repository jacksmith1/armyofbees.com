<?php

// Initialize variables
$email_errors = array();
$email_sent = false;

// Check if post request
if ( $_POST ) {

	// Check for errors
	if ( empty( $_POST["name"] ) )
		$errors["name"] = true;
	if ( empty( $_POST["email"] ) )
		$errors["email"] = true;
	if ( empty( $_POST["scope"] ) )
		$errors["scope"] = true;
	if ( empty( $_POST["budget"] ) )
		$errors["budget"] = true;
	if ( empty( $_POST["description"] ) )
		$errors["description"] = true;

	// Found errors?
	if ( !$errors ) {

		// Build email
		$from = $_POST["name"]." <".$_POST["email"].">";
		$to = "Army of Bees Contact <info@armyofbees.com>";
		$subject = "ARMYOFBEES: Incoming contact form!";
		$message = <<<EOT
Name: {$_POST["name"]}
Company: {$_POST["company"]}
Email: {$_POST["email"]}
Scope: {$_POST["scope"]}
Budget: {$_POST["budget"]}
Description:
{$_POST["description"]}
EOT;

		// Send email
		$headers = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-type: text/plain; charset=iso-8859-1";
		$headers[] = "From: {$from}";
		$headers[] = "Reply-To: {$from}";
		$headers[] = "Subject: {$subject}";
		$headers[] = "X-Mailer: PHP/".phpversion();
		$headers = implode( "\r\n", $headers );
		$email_sent = mail( $to, $subject, $message, $headers );

		// Erase input on success
		if ( $email_sent ) {
			$_POST["name"] = "";
			$_POST["company"] = "";
			$_POST["email"] = "";
			$_POST["scope"] = "";
			$_POST["budget"] = "";
			$_POST["description"] = "";
		}


	}

}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Contact Us / Army of Bees</title>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="en-us" />

<meta name="language" content="en-CA, English" />
<meta name="description" content="We are a premium web design and development firm based in Atlanta, Georgia." />

<link rel="shortcut icon" href="../favicon.ico" />
<link rel="stylesheet" media="screen" href="../styles/style.css" type="text/css" />

<!--[if IE 8]>
<link rel="stylesheet" media="screen" href="../styles/ie8.css" type="text/css" />
<![endif]-->

</head>

<body id="contact">
	<div id="header">
		<div class="wrapper">

			<h1 class="logo">
				<a href="../">Army of Bees</a>
			</h1>

			<ul class="nav">
				<li><a href="../about/">About</a></li>
				<li><a href="../services/">Services</a></li>
				<li><a href="../portfolio/">Portfolio</a></li>
				<li><a href="#" class="sel">Contact</a></li>
			</ul>

		</div>
	</div>	<!-- end header DIV -->

	<div id="title">
		<div class="wrapper">
			<h2>get in <em>contact</em></h2>
		</div>
	</div>

	<div class="content">
		<div class="wrapper">

			<div class="sidebar">
				<div class="box">
					<h3>Alternate Methods</h3>
					<ul>
						<li class="email"><a href="mailto:info@armyofbees.com">info@armyofbees.com</a>
						<li class="snail">PO Box 78779<br />Atlanta, GA 30357</li>
					</ul>
				</div>

				<div class="box">
					<h3>Already a Client?</h3>
					<ul>
						<li class="basecamp"><a href="https://launchpad.37signals.com">Basecamp Projects</a>
						<li class="freshbooks"><a href="https://armyofbees.freshbooks.com">Freshbooks Invoicing</a></li>
					</ul>
				</div>
			</div>

			<?php if ( $_POST && $email_sent ) : ?>
					<div class="message success">
						<strong>Thanks for reaching out!</strong> We'll get back to you within 2 business days.
					</div>
			<?php elseif ( $_POST && $errors ) : ?>
					<div class="message error">
						<strong>Oops!</strong> Looks like you missed some fields. Check the errors below and try again.
					</div>
			<?php else: ?>
				<p class="form-description">Have a potential project for us? Just fill out the form below and let's see if we're a good fit.</p>
			<?php endif; ?>

			<form name="form" method="post" action="" onsubmit="return CheckData();">

				<div class="form-item <?= ( $errors["name"] ? "errors" : "" ) ?>">
					<label for="name"><em class="required">*</em> Your Name</label>
					<input id="name" class="form-text" type="text" name="name" value="<?= $_POST["name"] ?>" tabindex="1" />
				</div>

				<div class="form-item <?= ( $errors["company"] ? "errors" : "" ) ?>">
					<label for="company">Company Name</label>
					<input id="company" class="form-text" type="text" name="company" value="<?= $_POST["company"] ?>" tabindex="1" />
				</div>

				<div class="form-item <?= ( $errors["email"] ? "errors" : "" ) ?>">
					<label for="email"><em class="required">*</em> Email Address</label>
					<input id="email" class="form-text large" type="text" name="email" value="<?= $_POST["email"] ?>" tabindex="2" />
				</div>

				<div class="form-item <?= ( $errors["scope"] ? "errors" : "" ) ?>">
					<label for="scope"><em class="required">*</em> Project Scope</label>
					<select id="scope" name="scope" tabindex="3">
						<option value="" selected="selected">Choose one...</option>
						<?php
						$options = array(
							"Design Services",
							"Small Website",
							"Large Website",
							"Custom Web Application",
							"Consultation",
							"Other",
						);
						foreach( $options as $option ) {
							$selected = ( $_POST["scope"] == $option ? "selected" : "" );
							echo "<option value=\"{$option}\" {$selected}>{$option}</option>";
						}
						?>
					</select>
				</div>

				<div class="form-item <?= ( $errors["budget"] ? "errors" : "" ) ?>">
					<label for="budget"><em class="required">*</em> Project Budget</label>
					<select id="budget" name="budget" tabindex="4">
						<option value="" selected="selected">Choose one...</option>
						<?php
						$options = array(
							"$1000-$1999",
							"$2000-$4999",
							"$5000-$9999",
							"$10000+",
						);
						foreach( $options as $option ) {
							$selected = ( $_POST["scope"] == $option ? "selected" : "" );
							echo "<option value=\"{$option}\" {$selected}>{$option}</option>";
						}
						?>
					</select>
				</div>

				<div class="form-item <?= ( $errors["description"] ? "errors" : "" ) ?>">
					<label for="description"><em class="required">*</em> Project Description</label>
					<textarea id="description" name="description" rows="8" cols="40" tabindex="5"><?= $_POST["description"] ?></textarea>
				</div>

				<div class="form-actions">
					<input type="submit" class="form-submit" value="Send It" />
				</div>

			</form>
		</div>
	</div>	<!-- end content DIV -->

	<div id="footer">
		<div class="wrapper">

				<ul class="info">
					<li><small>Email -</small> <a href="mailto:info@armyofbees.com">info@armyofbees.com</a></li>
					<li><small>Twitter -</small> <a href="https://twitter.com/armyofbees" target="_blank">@armyofbees</a></li>
					<li><small>Facebook -</small> <a href="https://www.facebook.com/aobwebdesign" target="_blank">Army Of Bees</a></li>
				</ul>

				<span class="logo"></span>
				<span class="bees"></span>

		</div>
	</div>	<!-- end footer DIV -->

</body>
</html>