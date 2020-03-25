<?php
// composer.json register
//composer dump-autoload

function gravatar($email)
{

    $email = md5($email);

    return "https://gravatar.com/avatar/{$email}?d=https://iupac.org/wp-content/uploads/2018/05/default-avatar.png";
}

?>
