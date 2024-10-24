<?php


SetCookie('monCookie', 'Valeur du cookie', time() + 3600, '/');
if(isset($_COOKIE['monCookie'])) {
    echo htmlentities($_COOKIE['monCookie']);
}else {
    echo 'Le cookie n\'existe pas';
}
?>

