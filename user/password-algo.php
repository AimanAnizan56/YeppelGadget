<?php
/* Get instance of mysqli object */
$db = Database::getInstance();

/* Check if user click confirm button */
if(isset($_POST['confirm'])):
    /* Get username and escape */
    $username = $db -> real_escape_string($_SESSION['username']);
    /* Get hashed password */
    if($result = $db -> query("SELECT password FROM user WHERE username='$username'")):
        /* Check row retrieved */
        if($result -> num_rows === 1):
            /* Get data from row and store as array */
            $data = $result -> fetch_assoc();
            
            /* Verify current password */
            if(password_verify($_POST['current_password'],$data['password'])):
                /* Get new password and password confirmation */
                $newPassword = $db ->  real_escape_string($_POST['new_password']);
                $confirmPassword = $db ->  real_escape_string($_POST['confirm_password']);

                // check if new and confirm password is same
                if($newPassword===$confirmPassword):
                    // hash password and escape before inserting
                    $hash = $db -> real_escape_string(password_hash($newPassword,PASSWORD_DEFAULT));
                    // begin query -- update password
                    if($db-> query("UPDATE user SET password = '$hash' WHERE username = '$username'")){
                        // check if there is affected rows
                        if($db->affected_rows===1){
                            $updated = true;
                        }
                    }
                endif;
            else:
                // show error popup (password verify failed) -- password incorrect
                $error = true;
            endif;
        endif; // end if for num of row retrieve
    endif; // endif for query
endif; // endif for get
?>