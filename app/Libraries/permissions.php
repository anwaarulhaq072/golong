<?php

namespace App\Libraries;
use DateTime;

class permissions{

    public function checksessionadmin()
    {
        session_start();
        if (isset($_SESSION['email']) && $_SESSION['user_data']['userTypeId'] == 1) {
            return true;
        } else {
            return false;
        }
    }
    public function checksessionuser()
    {
        session_start();
        if (isset($_SESSION['email']) && $_SESSION['user_data']['userTypeId'] == 2 || $_SESSION['user_data']['userTypeId'] == 4) {
            return true;
        } else {
            return false;
        }
    }

}



?>