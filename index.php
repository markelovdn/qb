<?php
include  'functions.php';
$db = include  'database/start.php';

dd($db->getAll('active'));



