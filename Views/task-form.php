<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>
        Edit task
    </title>
</head>
<body>
    <form method="POST" action="">
		    <label for="name">Name:</label><br/>
		    <input type="text" name="name" value="<?php print htmlentities($name); ?>"/>
		    <br/>

		    <label for="email">Email:</label><br/>
		    <input type="text" name="email" value="<?php print htmlentities($email); ?>" />
		    <br/>
		    <label for="text">Text:</label><br/>
		    <textarea name="task"><?php print htmlentities($task); ?></textarea>
		    <br/>
		    <input type="hidden" name="form-submitted" value="1" />
		    <input type="submit" value="Submit" />
		</form>

</body></html>