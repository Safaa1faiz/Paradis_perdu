<?php
require('inc/essentials.php');
require('inc/db_config.php');
adminLogin();

// Ajax get request 
if (isset($_GET['id'])) {
    $room = mysqli_fetch_assoc(select("SELECT * FROM `rooms` WHERE `id`=?", [$_GET['id']], 'i'));
    $features = [];
    $facilities = [];

    $features_res = select("SELECT * FROM `room_features` WHERE `room_id`=?", [$_GET['id']], 'i');
    if (mysqli_num_rows($features_res) > 0) {
        while ($feature = mysqli_fetch_assoc($features_res)) {
            array_push($features, $feature['features_id']);
        }
    }

    $facilities_res = select("SELECT * FROM `room_facilities` WHERE `room_id`=?", [$_GET['id']], 'i');
    if (mysqli_num_rows($facilities_res) > 0) {
        while ($facility = mysqli_fetch_assoc($facilities_res)) {
            array_push($facilities, $facility['facilities_id']);
        }
    }

    header("Content-Type: application/json");
    echo json_encode(array(
        ...$room,
        "features" => $features,
        "facilities" => $facilities
    ));
    exit();
}

if (isset($_POST['toggle_status'])) {
    update("UPDATE `rooms` SET `status`=? WHERE `id`=?", [$_POST['status'], $_POST['id']], 'ii');
}

// form submit for add & edit 
if (isset($_POST['form_room'])) {
    $is_add = isset($_POST['id']) && empty($_POST['id']);

    if ($is_add) {
        insert(
            "INSERT INTO `rooms` (`name`, `area`, `price`, `quantity`, `adult`, `children`, `description`) VALUES (?,?,?,?,?,?,?)",
            [$_POST['name'], $_POST['area'], $_POST['price'], $_POST['quantity'], $_POST['adult'], $_POST['children'], $_POST['desc']],
            'siiiiis'
        );

        $room_id = mysqli_insert_id($con);
    } else {
        $room_id = $_POST['id'];

        update(
            "UPDATE `rooms` SET `name`=?,`area`=?,`price`= ?,`quantity`=?,`adult`=?,`children`=?,`description`=? WHERE `id`=?",
            [$_POST['name'], $_POST['area'], $_POST['price'], $_POST['quantity'], $_POST['adult'], $_POST['children'], $_POST['desc'], $room_id],
            'siiiiisi'
        );
    }

    // delete all features && facilities
    delete("DELETE FROM `room_facilities` WHERE `room_id`=?",  [$room_id], 'i');
    delete("DELETE FROM `room_features` WHERE `room_id`=?",  [$room_id], 'i');

    foreach ($_POST['facilities'] as $id) {
        insert(
            "INSERT INTO `room_facilities`(`room_id`, `facilities_id`) VALUES (?,?)",
            [$room_id, $id],
            'ii'
        );
    }

    foreach ($_POST['features'] as $feature) {
        insert(
            "INSERT INTO `room_features`(`room_id`, `features_id`) VALUES (?,?)",
            [$room_id, $feature],
            'ii'
        );
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - ROOM</title>
    <?php require('inc/links.php'); ?>
</head>

<body class="bg-light">
    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">ROOMS</h3>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <button type="button" class="btn btn-dark shadow-none btn-sm" onclick="add_room()" data-bs-toggle="modal" data-bs-target="#modal-form-room"><i class="bi bi-plus-square"></i>
                                Add
                            </button>
                        </div>
                        <div class="table-responsive-lg" style="height: 450px; overflow-y: scroll;">

                            <?php $allRooms = selectAll('rooms'); ?>

                            <table class="table table-hover border text-center">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Area</th>
                                        <th scope="col">Guests</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <?php $i = 0;
                                while ($room = mysqli_fetch_assoc($allRooms)) { ?>
                                    <tr class='align-middle'>
                                        <td><?php echo ++$i ?></td>
                                        <td><?php echo $room['name'] ?></td>
                                        <td><?php echo $room['area'] ?> sq. ft.</td>
                                        <td>
                                            <span class='badge rounded-pill bg-light text-dark'>
                                                Adult: <?php echo $room['adult'] ?>
                                            </span>
                                            <span class='badge rounded-pill bg-light text-dark'>
                                                Children: <?php echo $room['children'] ?>
                                            </span>
                                        </td>
                                        <td><?php echo $room['price'] ?> DH</td>
                                        <td><?php echo $room['quantity'] ?></td>
                                        <td>
                                            <?php if ($room['status'] == 1) { ?>
                                                <button onclick="toggle_status(<?php echo $room['id'] ?>, 0)" class='btn btn-dark btn-sm shadow-none'>active</button>
                                            <?php } else { ?>
                                                <button onclick="toggle_status(<?php echo $room['id'] ?>, 1)" class='btn btn-warning btn-sm shadow-none'>inactive</button>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <button type='button' onclick="edit_room(<?php echo $room['id'] ?>)" class='btn btn-primary shadow-none btn-sm' data-bs-toggle="modal" data-bs-target="#modal-form-room">
                                                <i class='bi bi-pencil-square'></i>
                                            </button>
                                            <button type="button" onclick="room_images('<?php echo $room['id']; ?>', '<?php echo $room['name']; ?>')" class="btn btn-info shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#room-images">
                                            <i class="bi bi-images"></i>
                                           </button>
                                           <button type="button" onclick="remove_room('<?php echo $room['id']; ?>')" class="btn btn-danger shadow-none btn-sm">
                                            <i class="bi bi-trash"></i>
                                            </button>

                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <div class="modal fade" id="modal-form-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="form-room" autocomplete="off" method="post">
                <input type="hidden" name="form_room">
                <input type="hidden" name="id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">room</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <input type="text" name="name" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Area</label>
                                <input type="number" min="1" name="area" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Quantity</label>
                                <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Price</label>
                                <input type="number" min="1" name="price" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Adult (Max.)</label>
                                <input type="number" min="1" name="adult" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Children (Max.)</label>
                                <input type="number" min="1" name="children" class="form-control shadow-none" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Features</label>
                                <div class="row">
                                    <?php
                                    $features = SelectAll('features');
                                    while ($feature = mysqli_fetch_assoc($features)) { ?>
                                        <div class='col-md-3 mb-1'>
                                            <label>
                                                <input type='checkbox' name='features[]' value="<?php echo $feature['id'] ?>" class='form-check-input shadow-none'>
                                                <?php echo $feature['name'] ?>
                                            </label>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Facilities</label>
                                <div class="row">
                                    <?php
                                    $facilities = SelectAll('facilities');
                                    while ($facility = mysqli_fetch_assoc($facilities)) { ?>
                                        <div class='col-md-3 mb-1'>
                                            <label>
                                                <input type='checkbox' name='facilities[]' value="<?php echo $facility['id'] ?>" class='form-check-input shadow-none'>
                                                <?php echo $facility['name'] ?>
                                            </label>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="desc" rows="4" class="form-control shadow-none" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <form id="toggle-status-room" autocomplete="off" method="post">
        <input type="hidden" name="toggle_status">
        <input type="hidden" name="status">
        <input type="hidden" name="id">
    </form>
  


    <!-- Manage room images modal -->

<div class="modal fade" id="room-images" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Room Name</h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="image-alert"></div>
      <div class="border-bottom border-3 pb-3 mb-3">
        <form id="add_image_form">
          <label class="form-label fw-bold">Add Image</label>
          <input type="file" name="image"  accept="[.jpg, .png, .webp, .jpeg]" class="form-control shadow-none mb-3" required>
          <button  class="btn custom-bg text-white shadow-none">ADD</button>
          <input type="hidden" name="room_id">
        </form>
      </div>
       <div class="table-responsive-lg" style="height: 450px; overflow-y: scroll;">
        <table class="table table-hover border text-center">
            <thead>
            <tr class="bg-dark text-light sticky-top">
            <th scope="col" width="60%">Image</th>
            <th scope="col">Thumb</th>
            <th scope="col">Delete</th>
          </tr>
        </thead>
      <tbody id="room-image-data">
      </tbody>
     </table>
     </div>
    </div>
   </div>
 </div>
</div>




    <?php require('inc/scripts.php'); ?>

<script src="scripts/rooms.js"></script>    
</body>

</html>