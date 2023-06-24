<?php
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

if(isset($_POST['add_image']))
{
   $frm_data = filteration($_POST);
   $img_r = uploadImage($_FILES['image'], ROOMS_FOLDER);

   if($img_r == 'inv_img'){
      echo $img_r;
   }
   else if($img_r == 'inv_size'){
      echo $img_r;
   }
   else if($img_r == 'upd_failed'){
      echo $img_r;
   }
   else{
      $q = "INSERT INTO `room_images`(`room_id`, `image`) VALUES (?,?)";
      $values = [$frm_data['room_id'], $img_r];
      $res = insert($q, $values, 'is');
      echo $res;
   }
}

if(isset($_POST['get_room_images']))
{
   $frm_data = filteration($_POST);
   $res = select("SELECT * FROM `room_images`  WHERE `room_id`=?",[$frm_data['get_room_images']],'i');


   $path = ROOMS_IMG_PATH;

   while($row = mysqli_fetch_assoc($res))
   {
    if($row['thumb']==1){
       $thumb_btn = "<i class='bi bi-check-lg text-light bg-success px-2 py-1 rounded fs-5'></i>";
      }
      else {
        $thumb_btn = "<button onclick='thumb_image($row[sr_no],$row[room_id])' class='btn btn-secondary btn-sm shadow-none'>
         <i class='bi bi-check-lg'></i>
        </button>";
      }
    
     echo <<<data
       <tr class='align-middle'>
       <td><img src='{$path}{$row['image']}' class='img-fluid'></td>
       <td>$thumb_btn</td>
       <td>
        <button onclick='rem_image($row[sr_no],$row[room_id])' class='btn btn-danger btn-sm shadow-none'>
         <i class='bi bi-trash'></i>
        </button>
       </td>
       </tr>
      data;
   }
}

if(isset($_POST['rem_image']))
{
   $frm_data = filteration($_POST);
   $values = [$frm_data['image_id'],$frm_data['room_id']];

   $pre_q = "SELECT * FROM `room_images` WHERE `sr_no`=?  AND `room_id`=?";
   $res = select($pre_q, $values, 'ii');
   $img = mysqli_fetch_assoc($res);

   if(deleteImage($img['image'], ROOMS_FOLDER)){
     $q = "DELETE FROM `room_images` WHERE `sr_no`=? AND `room_id`=?";
     $res = delete($q, $values, 'ii');
     echo $res;
   }
   else{
      echo 0;
   }
}

if(isset($_POST['thumb_image']))
{
   $frm_data = filteration($_POST);
   
   $pre_q = "UPDATE `room_images` SET `thumb`=? WHERE `room_id`=?";
   $pre_v = [0,$frm_data['room_id']];
   $pre_res = update($pre_q,$pre_v,'ii');


   $q = "UPDATE `room_images` SET `thumb`=? WHERE `sr_no`=? AND `room_id`=?";
   $v = [1,$frm_data['image_id'],$frm_data['room_id']];
   $res = update($q,$v,'iii');


  echo $res;

}

if (isset($_POST['remove_room'])) {
    $frm_data = filteration($_POST);

    $res1 = select("SELECT * FROM `room_images` WHERE `room_id`=?", [$frm_data['room_id']], 'i');
    while ($row = mysqli_fetch_assoc($res1)) {
        deleteImage($row['image'], ROOMS_FOLDER);
    }

    $res2 = delete("DELETE FROM `room_images` WHERE  `room_id`=?", [$frm_data['room_id']], 'i');
    $res3 = delete("DELETE FROM `room_features` WHERE  `room_id`=?", [$frm_data['room_id']], 'i');
    $res4 = delete("DELETE FROM `room_facilities` WHERE  `room_id`=?", [$frm_data['room_id']], 'i');
    $res5 = update('UPDATE `rooms` SET `removed` = ? WHERE `id` = ?', array('1', $frm_data['room_id']), 'ii');

    if ($res2 || $res3 || $res4 || $res5) {
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['get_all_rooms'])) {
    $res = select("SELECT * FROM `rooms` WHERE `removed`=?", [0], 'i');
    $i = 1;
    $data = "";

    echo $data;
}

?>
