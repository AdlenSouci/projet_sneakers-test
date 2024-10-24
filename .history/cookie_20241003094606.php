<?php


SetCookie('monCookie', 'Valeur du cookie', time() + 3600, '/');
//=> cookie dans response header
if(isset($_COOKIE['monCookie'])) {
    echo htmlentities($_COOKIE['monCookie']);
}else {
    echo 'Le cookie n\'existe pas';
}
?>
echo 
