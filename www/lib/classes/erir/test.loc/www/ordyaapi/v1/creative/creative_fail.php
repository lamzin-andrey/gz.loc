<?php
// contract validation error
header("HTTP/1.1 422 Unprocessable Entity");
header('Content-Type: application/json');
echo '{
  "detail": [
    {
      "loc": [
        "string",
        0
      ],
      "msg": "string",
      "type": "string"
    }
  ]
}';
