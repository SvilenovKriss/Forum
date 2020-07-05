<?php
  function jwtTokenEncode($email, $userId) {
    $header = json_encode([
      'typ' => 'JWT',
      'alg' => 'HS256'
    ]);
    $payload = json_encode([
      'user_id' => $userId,
      'email' => $email,
      'exp' => 1593828222
    ]);
    // Encode Header
    $base64UrlHeader = base64UrlEncode($header);
    // Encode Payload
    $base64UrlPayload = base64UrlEncode($payload);
    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'VeryS3cret!', true);
    // Encode Signature to Base64Url String
    $base64UrlSignature = base64UrlEncode($signature);
    // Create JWT
    $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

    return $jwt;
  }

  function base64UrlEncode($text) {
    return str_replace(
        ['+', '/', '='],
        ['-', '_', ''],
        base64_encode($text)
    );
  }
?>