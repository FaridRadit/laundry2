<?php
include ("connectdb_php");
session_start();
session_destroy();
header("location:index.php");
?>