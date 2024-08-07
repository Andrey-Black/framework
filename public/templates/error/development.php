<?php

/**
 * @var string $errStr
 * @var string $errFile
 * @var string $errLine
 * @var string $response
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="PROJECT">
  <link rel="stylesheet" href="css/style.min.css">
  <link rel="stylesheet" href="icons/favicon.png">
  <title>Development</title>
</head>
<body>

<h3>Error code: <code><?php echo htmlspecialchars($response); ?></code></h3>
<h3>Description: <code><?php echo htmlspecialchars($errStr); ?></code></h3>
<h3>File path: <code><?php echo htmlspecialchars($errFile); ?></code></h3>
<h3>Line: <code><?php echo htmlspecialchars($errLine); ?></code></h3>

<script src="js/script.min.js"></script>
</body>
</html>
