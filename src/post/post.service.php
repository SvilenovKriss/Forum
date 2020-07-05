<?php
  function createPost($post_title, $post_content, $userId, $db) {
    getData($userId, 'user',  $db);
    $query = "INSERT INTO post (post_title, post_content, userId, date_created)
                VALUES ('$post_title', '$post_content', '$userId', NOW())";
    $postData = $db->query($query);
    if(!$postData) {
      die("mysqli error: " .mysqli_error($db));
    }

    $msg = new class {
      public string $message = 'Post created!';
    };
    return json_encode($msg);
  }

  function createComment($comment, $userId,$postId, $db) {
    getData($userId, 'user', $db);
    getData($postId, 'post', $db);
    $query = "INSERT INTO comment (content, date_created, userId, postid)
                VALUES ('$comment', NOW(), '$userId', '$postId')";
    $commentData = $db->query($query);
    if(!$commentData) {
      die("mysqli error: " .mysqli_error($db));
    }
    $msg = new class {
      public string $message = 'Comment added!';
    };
    return json_encode($msg);
  }

  function getData($dataId, $searchingType, $db) {
    $query = "SELECT * FROM $searchingType WHERE id='$dataId'";
    $stmt = $db->query($query);
    if(!$stmt) {
      die("mysqli error: " .mysqli_error($db));
    }

    $data = $stmt->fetchAll()[0];
    return $data;
  }

  function getComments($db) {
    $comments = getData(1, "comment", $db);
    $st = new class {
      public $comment;
    };
    $st->comment = $comments;
    return json_encode($st);
  }
?>