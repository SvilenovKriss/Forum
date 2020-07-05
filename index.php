<?php
  require "constants/constants.php";
  require 'database/connection.php';
  require 'routing/Request.php';
  require 'routing/Router.php';
  require 'src/user/user.service.php';
  require 'src/post/post.service.php';

  global $db;
  $router = new Router(new Request);

  $router->get('/', function() {
    return <<<HTML
    <h1>Hello world</h1>
    HTML;
  });

  $router->post('/signUp', function($request) {
    global $db;
    $body = $request->getBody();
    if(!$body['email'] || !$body['username']|| !$body['password']) {
      return 'Sign up requires email, username, passowrd, createdAt fields.';
    }

    return signUp($body['email'], $body['username'], $body['password'], $db);
  });

  $router->post('/signIn', function($request) {
    global $db;
    $body = $request->getBody();
    return signIn($body['email'], $body['password'], $db);
  });

  $router->post('/create-post', function($request) {
    global $db;
    $body = $request->getBody();
    if(!$body['post_title'] || !$body['post_content'] || !$body['userId']) {
      return 'For creating post is required title, content and userId';
    }
    return createPost($body['post_title'], $body['post_content'], $body['userId'], $db);
  });

  $router->post('/create-comment', function($request) {
    global $db;
    $body = $request->getBody();
    if(!$body['comment'] || !$body['userId'] || !$body['postId']) {
      return 'For createing comment is required the comment, userId and postId';
    }

    return createComment($body['comment'], $body['userId'], $body['postId'], $db);
  });

  $router->get('/get-comments', function() {
    global $db;
    return getComments($db);
  });
?>