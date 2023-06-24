
        async function toggle_status(id, val) {
            const form = document.getElementById('toggle-status-room');

            form.elements['id'].value = id;
            form.elements['status'].value = val;
            form.submit();
        };

        function add_room() {
            document.getElementById('form-room').reset();
        }

        async function edit_room(id) {
            const response = await fetch('/Hotelwebsite/admin/rooms.php?id=' + id);
            const room = await response.json();

            const form = document.getElementById('form-room');
            form.elements['id'].value = room.id;
            form.elements['name'].value = room.name;
            form.elements['area'].value = room.area;
            form.elements['price'].value = room.price;
            form.elements['quantity'].value = room.quantity;
            form.elements['adult'].value = room.adult;
            form.elements['children'].value = room.children;
            form.elements['desc'].value = room.description;

            Array.from(form.elements['features[]']).forEach(el => {
                el.checked = room.features.includes(Number(el.value));
            });

            Array.from(form.elements['facilities[]']).forEach(el => {
                el.checked = room.facilities.includes(Number(el.value));
            });
        }
   

        // Manage room images modal



        let add_image_form = document.getElementById('add_image_form');

        add_image_form.addEventListener('submit',function(e){

         e.preventDefault();
         add_image(); 
        });
         

function add_image() {
  let data = new FormData();
  data.append('image', add_image_form.elements['image'].files[0]);
  data.append('room_id', add_image_form.elements['room_id'].value);
  data.append('add_image', '');

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms.php", true);

  xhr.onload = function() {
    if (this.responseText === 'inv_img') {
      alert('error', 'Only JPG, WEBP, JPEG, and PNG images are allowed', 'image-alert');
    } else if (this.responseText === 'inv_size') {
      alert('error', 'Image should be less than 2MB', 'image-alert');
    } else if (this.responseText === 'upd_failed') {
      alert('error', 'Image upload failed. Server Down!', 'image-alert');
    } else {
      alert('success', 'New Image added', 'image-alert');
      room_images(add_image_form.elements['room_id'].value, document.querySelector("#room-images .modal-title").innerText);
      add_image_form.reset();
    }
  };

  xhr.send(data);
}

     
function room_images(id,rname)
{
document.querySelector("#room-images .modal-title").innerText = rname;
add_image_form.elements['room_id'].value = id;
add_image_form.elements['image'].value = '';


  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function() {
   document.getElementById('room-image-data').innerHTML = this.responseText;
  };

  xhr.send('get_room_images='+id);
}


function rem_image(img_id, room_id) {
  let data = new FormData();
  data.append('image_id', img_id);
  data.append('room_id', room_id);
  data.append('rem_image', '');

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms.php", true);

  xhr.onload = function() {
 if (this.responseText === '1') {
  alert('success','Image Removed', 'image-alert');
  room_images(room_id, document.querySelector("#room-images .modal-title").innerText);
} else {
  alert('error','Image removal failed', 'image-alert' );
}

  };

  xhr.onerror = function() {
    alert('error', 'An error occurred while sending the request', 'image-alert');
  };''

  xhr.send(data);
}



function thumb_image(img_id, room_id) {
  let data = new FormData();
  data.append('image_id', img_id);
  data.append('room_id', room_id);
  data.append('thumb_image', '');

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms.php", true);

  xhr.onload = function() {
    if (this.responseText === "1") {
      alert('success', 'Image Thumbnail Changed!', 'image-alert');
      room_images(room_id, document.querySelector("#room_images .modal-title").innerText);
    } else {
      alert('error', 'Thumbnail removal failed', 'image-alert');
    }
  };

  xhr.send(data);
}

function remove_room(room_id) {
  if (confirm("Are you sure you want to delete this room?")) {
    let data = new FormData();
    data.append('room_id', room_id);
    data.append('remove_room', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);

    xhr.onload = function() {
      if (this.responseText === "1") {
          alert('success', 'Room removed!');
          get_all_rooms();
      } else {
        alert('error', 'Room removal failed');
      }
    };

    xhr.send(data);
  }
}










        
