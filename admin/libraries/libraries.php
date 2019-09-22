<?php
require ( 'sql.class.php' );
require ( 'sql_helper.class.php' );
require ( 'mail.class.php' );
require ( 'string.class.php' );
require ( 'helper.class.php' );
require ( 'scaffold.class.php' );
require ( 'hash_crypt.class.php' );
require ( 'image.class.php' );
require ( 'file.class.php' );

$db = new db(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
$sql_helper = new SQLHelper(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
$mail = new PHPMailer;
$string = new String;
$helper = new Helper;
$scaffold = new Scaffold;
$crypt = new hash_encryption(ENCRYPT_KEY);
$image = new Image;
$file = new File;
?>