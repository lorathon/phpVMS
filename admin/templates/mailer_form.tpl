<h3>Mass Mailer</h3>
<form method="post" action="<?php echo SITE_URL ?>/admin/index.php/MassMailer">
<p>
	<strong>Subject: </strong> <input type="text" name="subject" value="" />
</p>
<p>
	<strong>Message:</strong>
</p>
<p>
	<textarea name="message" id="editor" style="width: 600px; height: 250px;">To: {PILOT_FNAME} {PILOT_LNAME}, </textarea>
</p>
<p>
	<input type="submit" name="submit" value="Send Email" />
</p>
</form>