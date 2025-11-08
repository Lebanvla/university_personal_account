<?php
var_export($_SESSION);
session_destroy();
header("Location: http://localhost/");
exit;
