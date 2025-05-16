<?php

function getAllPhData($conn) {
    $data = [];

    $sql = "SELECT * FROM `ph`";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row; // Add each row into the array
        }
    }

    return $data; // Return the array (even if empty)
} 
function getSPhData($conn,$ph_id) {
    $data = [];

    $sql = "SELECT * FROM `sph` WHERE ph_id='$ph_id' limit 4 ";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row; // Add each row into the array
        }
    }

    return $data; // Return the array (even if empty)
} 
function getAllSPhData($conn) {
    $data = [];

    $sql = "SELECT * FROM `sph`";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row; // Add each row into the array
        }
    }

    return $data; // Return the array (even if empty)
} 
function getSingleSPhData($conn,$sph_id) {
    $data = [];

    $sql = "SELECT * FROM `sph` WHERE `id`='$sph_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row; // Add each row into the array
        }
    }

    return $data; // Return the array (even if empty)
} 
function myorder($conn,$userType,$userid){
    $data = [];
    if ($userType=='ZH'){
         $sql = "SELECT o.*,o.zh_qty as quantity, sp.name as sp_name, sp.id as spid,sp.img as img, o.removed_on as rmv,u.name as u_name
                      FROM orders as o 
                      LEFT JOIN user as u on u.id=o.sh_id 
                      LEFT JOIN sph as sp on sp.id=o.sph_id  WHERE o.zh_id='$userid'";
    }
    elseif($userType=='SH'){
         $sql = "SELECT o.*,o.sh_qty as quantity, sp.name as sp_name, sp.id as spid,sp.img as img, o.removed_on as rmv,u.name as u_name
                      FROM orders as o  
                      LEFT JOIN user as u on u.id=o.ch_id 
                      LEFT JOIN sph as sp on sp.id=o.sph_id WHERE o.sh_id='$userid'";
    }
    elseif($userType=='CH'){
         $sql = "SELECT o.*,o.ch_qty as quantity, sp.name as sp_name, sp.id as spid,sp.img as img, o.removed_on as rmv,u.name as u_name
                      FROM orders as o  
                      LEFT JOIN sph as sp on sp.id=o.sph_id 
                      LEFT JOIN user as u on u.id=o.tm_id 
                      WHERE o.ch_id='$userid'";
    }
    elseif($userType=='TM'){
         $sql = "SELECT o.*,o.tm_qty as quantity, sp.name as sp_name, sp.id as spid,sp.img as img, o.removed_on as rmv,u.name as u_name
                      FROM orders as o 
                      LEFT JOIN user as u on u.id=o.se_id 
                      LEFT JOIN sph as sp on sp.id=o.sph_id WHERE o.tm_id='$userid'";
    }
    elseif($userType=='SE'){
         $sql = "SELECT o.*,o.se_qty as quantity, sp.name as sp_name, sp.id as spid,sp.img as img, o.removed_on as rmv
                      FROM orders as o 
                      
                      LEFT JOIN sph as sp on sp.id=o.sph_id WHERE o.se_id='$userid'";
    }
   
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row; // Add each row into the array
        }
    }

    return $data;
}
function getZH($conn) {
    $data = [];

    $sql = "SELECT * FROM `user` WHERE `user_type`='ZH'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row; // Add each row into the array
        }
    }

    return $data; // Return the array (even if empty)
} 
function getCH($conn) {
    $data = [];

    $sql = "SELECT * FROM `user` WHERE `user_type`='CH'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row; // Add each row into the array
        }
    }

    return $data; // Return the array (even if empty)
} 
function getSH($conn) {
    $data = [];

    $sql = "SELECT * FROM `user` WHERE `user_type`='SH'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row; // Add each row into the array
        }
    }

    return $data; // Return the array (even if empty)
} 
function getTM($conn) {
    $data = [];

    $sql = "SELECT * FROM `user` WHERE `user_type`='TM'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row; // Add each row into the array
        }
    }

    return $data; // Return the array (even if empty)
} 
function gettotalorder($conn,$userid,$userType) {
    if ($userType == "ZH") {
    $sql = "SELECT COUNT(*) AS total FROM `orders` WHERE zh_id = '$userid'";
} elseif ($userType == "CH") {
    $sql = "SELECT COUNT(*) AS total FROM `orders` WHERE ch_id = '$userid'";
} elseif ($userType == "TM") {
    $sql = "SELECT COUNT(*) AS total FROM `orders` WHERE tm_id = '$userid'";
} elseif ($userType == "SH") {
    $sql = "SELECT COUNT(*) AS total FROM `orders` WHERE sh_id = '$userid'";
} elseif ($userType == "SE") {
    $sql = "SELECT COUNT(*) AS total FROM `orders` WHERE se_id = '$userid'";
} else {
    $sql = "SELECT COUNT(*) AS total FROM `orders` WHERE zh_id is not null";// Handle invalid userType case if needed
}
    
    $result = mysqli_query($conn, $sql);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        return $row['total']; // Return the total count directly
    }

    return 0; // Return 0 if no rows found or query fails
}

function getcompletedorder($conn,$userid,$userType) {
    if ($userType == "ZH") {
    $sql = "SELECT COUNT(*) AS total 
            FROM `dispatch` AS d 
            JOIN `orders` AS o ON o.id = d.order_id 
            WHERE o.zh_id = '$userid'";
} elseif ($userType == "CH") {
    $sql = "SELECT COUNT(*) AS total 
            FROM `dispatch` AS d 
            JOIN `orders` AS o ON o.id = d.order_id 
            WHERE o.ch_id = '$userid'";
} elseif ($userType == "TM") {
    $sql = "SELECT COUNT(*) AS total 
            FROM `dispatch` AS d 
            JOIN `orders` AS o ON o.id = d.order_id 
            WHERE o.tm_id = '$userid'";
} elseif ($userType == "SH") {
    $sql = "SELECT COUNT(*) AS total 
            FROM `dispatch` AS d 
            JOIN `orders` AS o ON o.id = d.order_id 
            WHERE o.sh_id = '$userid'";
} elseif ($userType == "SE") {
    $sql = "SELECT COUNT(*) AS total 
            FROM `dispatch` AS d 
            JOIN `orders` AS o ON o.id = d.order_id 
            WHERE o.se_id = '$userid'";
} else {
    return 0; // Invalid user type
}

    
    $result = mysqli_query($conn, $sql);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        return $row['total']; // Return the total count directly
    }

    return 0; // Return 0 if no rows found or query fails
}
function getrequests($conn,$userid,$userType) {
    $data = [];
    if ($userType == "ZH") {
    $sql = "SELECT o.*,o.sh_qty as quantity,o.zh_id as user_id,u.zh_id, sp.name as sp_name, sp.id as spid,sp.img as img, o.removed_on as rmv,u.name as u_name from orders AS o LEFT JOIN user AS u on u.id=o.sh_id LEFT JOIN sph as sp on sp.id=o.sph_id where u.zh_id='$userid'";
} elseif ($userType == "CH") {
    $sql = "SELECT o.*,o.tm_qty as quantity,o.ch_id as user_id, u.ch_id, sp.name as sp_name, sp.id as spid,sp.img as img, o.removed_on as rmv,u.name as u_name from orders AS o LEFT JOIN user AS u on u.id=o.tm_id LEFT JOIN sph as sp on sp.id=o.sph_id where u.ch_id='$userid'";
} elseif ($userType == "TM") {
    $sql = "SELECT o.*,o.se_qty as quantity,o.tm_id as user_id, u.tm_id, sp.name as sp_name, sp.id as spid,sp.img as img, o.removed_on as rmv,u.name as u_name from orders AS o LEFT JOIN user AS u on u.id=o.se_id LEFT JOIN sph as sp on sp.id=o.sph_id where u.tm_id='$userid'";
} elseif ($userType == "SH") {
    $sql = "SELECT o.*,o.ch_qty as quantity,o.sh_id as user_id,u.sh_id, sp.name as sp_name, sp.id as spid,sp.img as img, o.removed_on as rmv,u.name as u_name from orders AS o LEFT JOIN user AS u on u.id=o.ch_id LEFT JOIN sph as sp on sp.id=o.sph_id where u.sh_id='$userid'";
} elseif ($userType == "RQ") {
    $sql = "SELECT o.*,o.zh_qty as quantity,o.zh_id as user_id,u.zh_id, sp.name as sp_name, sp.id as spid,sp.img as img, o.removed_on as rmv,u.name as u_name from orders AS o LEFT JOIN user AS u on u.id=o.sh_id LEFT JOIN sph as sp on sp.id=o.sph_id where o.zh_id is NOT null";
} else {
    $sql = ""; // Handle invalid userType case if needed
}
    
   $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row; // Add each row into the array
        }
    }

    return $data; // Return the array (even if empty)
}
function gettotalitem($conn) {
   $sql="select count(*) as total from sph";
    
    $result = mysqli_query($conn, $sql);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        return $row['total']; // Return the total count directly
    }

    return 0; // Return 0 if no rows found or query fails
}
function gettotaldispatch($conn) {
   $sql="select count(*) as total from dispatch";
    
    $result = mysqli_query($conn, $sql);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        return $row['total']; // Return the total count directly
    }

    return 0; // Return 0 if no rows found or query fails
}
function gettotalcost($conn) {
   $sql="select sum(total_cost) as total from dispatch";
    
    $result = mysqli_query($conn, $sql);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        return $row['total']; // Return the total count directly
    }

    return 0; // Return 0 if no rows found or query fails
}

?>