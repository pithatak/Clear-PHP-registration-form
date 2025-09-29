<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

<h2>Account information</h2>
<p><strong>Name: </strong><?= htmlspecialchars($userData['first_name']) ?></p>
<p><strong>Last name: </strong><?= htmlspecialchars($userData['last_name']) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($userData['email']) ?></p>
<p><strong>Phone:</strong> <?= htmlspecialchars($userData['phone']) ?></p>

<a href="/logout" class="btn btn-danger">Log out of your account</a>
</body>
</html>
