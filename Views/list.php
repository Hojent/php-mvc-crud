
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>User's tasks</title>
<style type="text/css">
	table.tasks {
	width: 100%;
	}

	table.tasks thead {
	background-color: #eee;
	text-align: left;
	}

	table.tasks thead th {
	border: solid 1px #fff;
	padding: 3px;
	}

	table.tasks tbody td {
	border: solid 1px #eee;
	padding: 3px;
	}

	a, a:hover, a:active, a:visited {
	color: blue;
	text-decoration: underline;
}
</style>
</head>

<body>
<div><a href="index.php?op=new">Add new task</a></div>
<?php
//var_dump($tasks); die();
?>
<table border="0" cellpadding="0" cellspacing="0" class="tasks">
    <thead>
        <tr>
            <th><a href="?orderby=name">Name</a></th>
            <th><a href="?orderby=email">Email</a></th>
            <th>Text</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?php print htmlentities($task['name'], ENT_QUOTES); ?></td>
                <td><?php print htmlentities($task['email'], ENT_QUOTES); ?></td>
                <td><?php print htmlentities ($task['task']); ?> </td>
                <td><a href="index.php?op=edit&id=<?php echo $task['id']; ?>">edit</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
