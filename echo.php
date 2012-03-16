<html>

<head>
<title>Squire</title>
</head>

<body>
  <p>Greetings, <?php echo htmlspecialchars($_POST['name']); ?>.</p>
  <p><?php echo $_POST['history']; ?><?php echo $_POST['message']; ?></p>
  <form id="echoForm" action="echo.php" method="post">
    <input type="hidden" name="name" value="<?php echo htmlspecialchars($_POST['name']); ?>" />
    <input type="hidden" name="history" value="<?php echo htmlspecialchars($_POST['history']); ?><?php echo htmlspecialchars($_POST['message']); ?><br>" />
    <p>Message: <input id="message" type="text" name="message" /></p>
    <p><input type="submit" /></p>
  </form>
</body>

<script type="text/javascript">
  document.echoForm.message.focus();
</script>

</html>
