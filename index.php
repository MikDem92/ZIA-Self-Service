<!DOCTYPE html>
<html>
  <head>
    <title>Request Access Form</title>
  </head>
  <body>
    <form action="https://test.org" method="post">
      <label for="user">User:</label>
      <input type="text" id="user" name="user" value="<?php echo htmlspecialchars($_GET['user']); ?>"><br><br>
      <label for="site">Site:</label>
      <input type="text" id="site" name="site" value="<?php echo htmlspecialchars($_GET['url']); ?>"><br><br>
      <button type="submit">Request access</button>
    </form>
  </body>
</html>