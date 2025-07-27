function onclick_eys(){
    var image = document.getElementById("icon-eys");
    event.preventDefault();

    // Kiểm tra src hiện tại của hình ảnh
    if (image.src.endsWith("eye-slash-solid.svg")) {
      // Nếu src hiện tại là "eye-solid.svg", thay đổi thành hình ảnh khác
      var change_input = document.querySelector('.pass .passw_ac input');
      image.src = "./imge/eye-solid.svg";
      change_input.type="text";
      
    } else {
      // Ngược lại, nếu src hiện tại là hình ảnh khác, thay đổi lại thành "eye-solid.svg"\
      var change_input = document.querySelector('.pass .passw_ac input');
      image.src = "./imge/eye-slash-solid.svg";
      change_input.type="password";
    }
  }