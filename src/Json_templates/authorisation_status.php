<?php
if ($status === "success") {
    $res = [
        "status" => "success",
        "link" => $link
    ];
} else {
    $res = [
        "status" => "error",
        "title" => $error,
        "description" => $description
    ];
}
echo json_encode($res);
