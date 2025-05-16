<?php
      session_start();
      include "conn.inc.php";
      $conn = openConnection();
      $counter = 1;
      $userid = $_SESSION['user_id'];
      $user_type = $_SESSION['user_type'];

      if ($user_type == "ZH") {
          $getdata = "SELECT o.*, u.name as username, sp.name as sp_name, sp.id as spid,sp.img as img, o.removed_on as rmv
                      FROM orders as o 
                      LEFT JOIN user as u on u.id=o.sh_id 
                      LEFT JOIN sph as sp on sp.id=o.sph_id 
                      WHERE (o.zh_id='$userid' or u.zh_id='$userid') ORDER BY o.id desc";
      } elseif ($user_type == "SH") {
          $getdata = "SELECT o.*, u.name as username, sp.name as sp_name, sp.id as spid,sp.img as img, o.removed_on as rmv 
                      FROM orders as o 
                      LEFT JOIN user as u on u.id=o.ch_id 
                      LEFT JOIN sph as sp on sp.id=o.sph_id 
                      WHERE (o.sh_id='$userid' or u.sh_id='$userid') ORDER BY o.id desc";
      } elseif ($user_type == "TM") {
          $getdata = "SELECT o.*, u.name as username, sp.name as sp_name, sp.id as spid,sp.img as img, o.removed_on as rmv 
                      FROM orders as o 
                      LEFT JOIN user as u on u.id=o.se_id 
                      LEFT JOIN sph as sp on sp.id=o.sph_id 
                      WHERE (o.tm_id=$userid or u.tm_id=$userid) ORDER BY o.id desc";
      } elseif ($user_type == "CH") {
          $getdata = "SELECT o.*, u.name as username, sp.name as sp_name, sp.id as spid,sp.img as img, o.removed_on as rmv
                      FROM orders as o 
                      LEFT JOIN user as u on u.id=o.tm_id 
                      LEFT JOIN sph as sp on sp.id=o.sph_id 
                      WHERE (o.ch_id=$userid or u.ch_id=$userid) ORDER BY o.id desc";
      } elseif ($user_type == "SE") {
          $getdata = "SELECT o.*, sp.name as sp_name, sp.id as spid,sp.img as img, o.removed_on as rmv 
                      FROM orders as o 
                      LEFT JOIN sph as sp on sp.id=o.sph_id 
                      WHERE o.se_id='$userid' ORDER BY o.id desc";
      } else {
          $getdata = "SELECT o.*, u.name as username, sp.name as sp_name,sp.img as img, sp.id as spid, o.removed_on as rmv
                      FROM orders as o 
                      LEFT JOIN user as u on u.id=o.zh_id 
                      LEFT JOIN sph as sp on sp.id=o.sph_id 
                      WHERE o.zh_id IS NOT NULL  ORDER BY o.id desc";
      }

      $result = mysqli_query($conn, $getdata);

      if ($result && mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              $u_name = $row['username'] ?? "NA";
              $imagePath = !empty($row['img']) ? 'config/upload/' . $row['img'] : 'config/upload/default.jpg';
              echo '<div class="col-md-6">';
              //echo $imagePath;
              echo '<div class="card shadow-sm h-100 p-3 b-none">';
              echo '<h5>'. $row['sp_name'] . '</h5>';
              echo '<div class="d-flex flex-inline gap-3"><div><img src="'.$imagePath.'" alt="Item Image" class="img-thumbnail" style="width: 150px; height: 100%; object-fit: cover;"></div><div>';
              echo '<p><strong>Quantity:</strong> ' . $row['qty'] . '</p>';
              echo '<p><strong>Address:</strong> ' . $row['address'] . '</p>';

              if ($user_type != 'SE') {
                  echo '<p><strong>Subordinate:</strong> ' . $u_name . '</p>';
              }

              if ($user_type != "SE" && $user_type != "RQ") {
                  if ((($user_type == "ZH" && $row['zh_id'] == null) ||
                      ($user_type == "SH" && $row['sh_id'] == null) ||
                      ($user_type == "TM" && $row['tm_id'] == null) ||
                      ($user_type == "CH" && $row['ch_id'] == null)) && $row['rmv'] == null) {
                      echo '<div class="d-flex gap-2">';
                      echo '<button class="btn btn-primary allow-btn" data-id="' . $row['id'] . '" data-action="allow">Allow</button>';
                      echo '<button class="btn btn-danger disallow-btn" data-id="' . $row['id'] . '" data-action="disallow">Disallow</button>';
                      echo '</div>';
                  } elseif ($row['rmv'] == null) {
                      echo '<span class="badge bg-success">Approved</span>';
                  } else {
                      echo '<span class="badge bg-danger">Not Approved</span>';
                  }
              }

              echo '</div></div></div></div>';
          }
      } else {
          echo '<div class="col-12"><div class="alert alert-warning text-center">No records found</div></div>';
      }
      ?>