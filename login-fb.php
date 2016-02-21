<?php

$fb = new Facebook\Facebook([
  'app_id' => '1708173519404671', // Replace {app-id} with your app id
  'app_secret' => '31fb6f7eafa9c14ab986be020f682906',
  'default_graph_version' => 'v2.5',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://example.com/fb-callback.php', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';

?>