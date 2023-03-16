<!DOCTYPE html>
<?php

function get_domain_name($url) {
  $parsed_url = parse_url($url);
  $domain_parts = explode('.', $parsed_url['host']);
  $domain_name = $domain_parts[count($domain_parts) - 2] . '.' . $domain_parts[count($domain_parts) - 1];
  return $domain_name;
}
?>

<html>
  <head>
    <title>Request Access Form</title>
  </head>
  <body>
    <form action="https://test.org" method="post">
      <label for="user">User:</label>
      <input type="text" id="user" name="user" value="<?php echo htmlspecialchars($_GET['user']); ?>"><br><br>
      <label for="site">Site:</label>
      <input type="text" id="url" name="url" value="<?php echo htmlspecialchars(get_domain_name($_GET['url'])); ?>"><br><br>
      <button type="submit">Request access</button>
    </form>
  </body>
</html>