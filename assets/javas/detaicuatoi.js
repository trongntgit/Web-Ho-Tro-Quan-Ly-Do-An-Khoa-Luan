var hoten = localStorage.getItem('hoten');
document.getElementById('hoten').innerText = hoten;

var email = localStorage.getItem('email');
console.log(email);
document.getElementById('email').innerText= email;

var vaitro = localStorage.getItem('quyen');
var vaitro2="";
if (vaitro == 'giangvien'){
    vaitro2 = "Giảng viên";
}
else if(vaitro == 'sinhvien'){
    vaitro2 = "Sinh viên";
}
else if(vaitro == 'giaovu'){
    vaitro2 = "Giáo vụ"
}
else if(vaitro == 'lanhdao'){
    vaitro2 = "Trưởng khoa"
}
else if(vaitro == 'quantri'){
    vaitro2 = "Quản trị"
}

document.getElementById('vaitro').innerText =vaitro2 ;

document.addEventListener("DOMContentLoaded", function() {
    const viewButtons = document.querySelectorAll('.view-btn');
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const madetai = this.getAttribute('data-madt');
            showRegistrationDialog(madetai); // Gọi hàm hiển thị dialog
        });
    });
});


// Hủy đăng ký đề tài
// Hủy đăng ký đề tài
function huyDangKy(button) {
    var madetai = button.getAttribute('data-madt');
    var masv = button.getAttribute('data-masv');

    // Xác nhận trước khi xóa
    var confirmation = confirm("Bạn có chắc chắn muốn hủy đăng ký đề tài này không?");
    
    if (confirmation) {
        // Gửi yêu cầu AJAX để xóa dữ liệu từ dangkydetai và giảm soluongdk trong detai
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "./xulyhuydangky2.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText); // Parse JSON response
                if (response.success) {
                    hienThiThongBao("thanhcong", "Hủy đăng ký đề tài thành công");
                    // button.style.display = 'none'; // Ẩn nút sau khi hủy
                    
                    // Tìm phần tử dòng chứa nút này và xóa nó
                    var row = button.closest('tr'); // Giả sử nút Hủy đăng ký nằm trong <tr> (dòng bảng)
                    row.parentNode.removeChild(row); // Xóa dòng khỏi bảng
                } else {
                    hienThiThongBao("thatbai", "Hủy đăng ký đề tài thất bại: " + response.message);
                }
            }
        };

        // Truyền dữ liệu vào body của yêu cầu
        xhr.send("madetai=" + madetai + "&masv=" + masv);
    } else {
        // Nếu người dùng không xác nhận, không làm gì cả
        return;
    }
}


var madot = 0;
function showRegistrationDialog(madetai) {
    localStorage.setItem("madetai-chon",madetai);
    fetch('xemdangky.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ madetai: madetai })
    })
    .then(response => response.json())
    .then(students => {
        const tbody = document.getElementById('student-tbody');
        tbody.innerHTML = ''; // Xóa nội dung cũ

        students.forEach(student => {
            const row = document.createElement('tr');
            // Kiểm tra nếu student.quantri == 0 thì ghi chú để rỗng, nếu không thì ghi "Gán QT"
            const ghiChu = student.quantri === 0 ? '' : 'Gán QT';
            madot = student.dotdangky;
        
            // Kiểm tra trạng thái của student.trangthai
            const buttonHtml = student.trangthai === "Chấp nhận" 
                ? `<button onclick="huyChapNhan('${student.masv}', '${madetai}', '${student.dotdangky}')" class="button lb">Hủy chấp nhận</button>` 
                : `
                    <button onclick="removeStudent('${student.masv}', '${madetai}', '${student.dotdangky}')" class="button lb">Từ chối</button>
                    <button onclick="chapnhanStudent('${student.masv}', '${madetai}', '${student.dotdangky}')" class="button lb">Chấp nhận</button>
                `;
            
            row.innerHTML = `
                <td>${student.masv}</td>
                <td>${student.hoten}</td>
                <td>${student.diemtichluy}</td>
                <td>${student.ngaydangky}</td>
                <td>${ghiChu}</td>
                <td>
                    ${buttonHtml}
                </td>
            `;
            tbody.appendChild(row);
        });
        
        

        document.getElementById('dialog-xemdk').style.display = 'block'; // Hiện modal
    })
    .catch(error => console.error('Error:', error));
}


function removeStudent(masv, madetai, dotdangky) {
    // Gửi yêu cầu đến PHP để loại bỏ sinh viên
    fetch('./xulytuchoi.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ masv: masv, madetai: madetai, dotdangky: dotdangky })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cập nhật danh sách sinh viên
            showRegistrationDialog(madetai);
            hienThiThongBao("thanhcong","Từ chối thành công") ;
        } else {
            hienThiThongBao("thatbai","Từ chối thất bại") ;
        }
    })
    .catch(error => console.error('Error:', error));
}

function chapnhanStudent(masv, madetai, dotdangky) {
    // Gửi yêu cầu đến PHP để loại bỏ sinh viên
    fetch('./xulychapnhan.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ masv: masv, madetai: madetai, dotdangky: dotdangky })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cập nhật danh sách sinh viên
            showRegistrationDialog(madetai);
            hienThiThongBao("thanhcong","Chấp nhận thành công") ;
        } else {
            hienThiThongBao("thatbai","Chấp nhận thất bại") ;
        }
    })
    .catch(error => console.error('Error:', error));
}

function huyChapNhan(masv, madetai, dotdangky) {
    // Gửi yêu cầu đến PHP để loại bỏ sinh viên
    fetch('./xulyhuychapnhan.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ masv: masv, madetai: madetai, dotdangky: dotdangky })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cập nhật danh sách sinh viên
            showRegistrationDialog(madetai);
            hienThiThongBao("thanhcong","Hủy chấp nhận thành công") ;
        } else {
            hienThiThongBao("thatbai","Hủy chấp nhận thất bại") ;
        }
    })
    .catch(error => console.error('Error:', error));
}

function acceptRegistration() {
    const madetai = localStorage.getItem("madetai-chon");
    const sol = document.getElementById(madetai).getAttribute('data-sol');
    const solmax = document.getElementById(madetai).getAttribute('data-solmax');
    
    if (sol > 0) {
        fetch('./xulychapnhandangky.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ madetai: madetai , madot : madot})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                hienThiThongBao("thanhcong", "Đề tài đã được chuyển trạng thái thực hiện");
                
                // Tạo file PHP sau khi xác nhận thành công
                fetch('./taofiledetai.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({ madetai: madetai })
                })
                .then(response => response.json())
                .then(fileData => {
                    if (fileData.success) {
                        hienThiThongBao("thanhcong", "File đã được tạo thành công");
                        closeDialog(); // Đóng hộp thoại
                    } else {
                        hienThiThongBao("thatbai", fileData.message);
                    }
                })
                .catch(error => console.error('Error creating file:', error));
            } else {
                hienThiThongBao("thatbai", "Có lỗi xảy ra");
                console.log(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    } else {
        hienThiThongBao("thatbai", "Vẫn chưa có sinh viên nào đăng ký đề tài");
    }
}

function closeDialog() {
    document.getElementById('dialog-xemdk').style.display = 'none'; // Ẩn modal
    location.reload();
}







function hienThiThongBao(loai, noiDung) {
    let dialog;
    
    // Xác định dialog dựa trên loại thông báo
    switch (loai) {
        case 'thongbao':
            dialog = document.getElementById("dialog-thongbao");
            document.getElementById("dialog-thongbao-message").innerText = noiDung;
            break;
        case 'thanhcong':
            dialog = document.getElementById("dialog-thanhcong");
            document.getElementById("dialog-thanhcong-message").innerText = noiDung;
            break;
        case 'thatbai':
            dialog = document.getElementById("dialog-thatbai");
            document.getElementById("dialog-thatbai-message").innerText = noiDung;
            break;
        default:
            console.error('Loại thông báo không hợp lệ!');
            return; // Dừng hàm nếu loại không hợp lệ
    }

    // Hiển thị dialog và tự động ẩn sau 3 giây
    dialog.classList.add("show");
    setTimeout(() => {
        dialog.classList.remove("show");
    }, 2000); // Thay đổi thời gian tại đây nếu cần
}


// Hàm xóa đề tài
function xoadetai(madetai) {
    if (confirm("Bạn có chắc chắn muốn xóa đề tài này không?")) {
        // Gửi dữ liệu qua AJAX
        fetch("./delete_item.php", { 
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ madetai: madetai }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message); // Thông báo xóa thành công
                // Xóa dòng đề tài trên giao diện (nếu có bảng)
                const row = document.getElementById(madetai).closest("tr");
                if (row) {
                    row.remove();
                }
            } else {
                alert("Lỗi: " + data.error);
            }
        })
        .catch(error => {
            console.error("Lỗi trong quá trình xử lý:", error);
            alert("Đã xảy ra lỗi, vui lòng thử lại!");
        });
    }
}





// Hàm Duyệt
function duyetdetai(madetai) {
    console.log("Duyệt đề tài:", madetai);
    fetch("./xulyduyet.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "madetai=" + encodeURIComponent(madetai) + "&action=approve"
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Hiển thị thông báo từ PHP
        location.reload();
        console.log(data);
        // Cập nhật giao diện nếu cần
    })
    .catch(error => {
        console.error("Lỗi:", error);
    });
}

// Hàm Không Duyệt
function khongduyet(madetai) {
    console.log("Không duyệt đề tài:", madetai);
    var confirmAction = confirm("Bạn chắc chắn không duyệt đề tài này?");
    if (confirmAction) {
        fetch("./xulyduyet.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "madetai=" + encodeURIComponent(madetai) + "&action=reject"
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Hiển thị thông báo từ PHP
            location.reload();
            console.log(data);
        })
        .catch(error => {
            console.error("Lỗi:", error);
        });
    } else {
        alert("Hành động đã bị hủy.");
    }
}















// Hiển thị loading khi trang bắt đầu tải
window.addEventListener('load', () => {
    showLoading();
});

// Hiển thị loading khi thực hiện một hành động (ví dụ: tải lại trang hoặc gửi form)
function showLoading() {
    const loadingOverlay = document.getElementById('loading-overlay');
    loadingOverlay.style.display = 'block'; // Hiển thị overlay

    // Ẩn overlay sau 2 giây
    setTimeout(() => {
        loadingOverlay.style.display = 'none';
    }, 1200);
}

function hideLoading() {
    document.getElementById('loading-overlay').style.display = 'none';
}

// Gọi showLoading() trước khi tải lại trang hoặc gửi form
document.querySelector('form').addEventListener('submit', (event) => {
    showLoading();
});

// Ẩn overlay sau khi hành động kết thúc
window.addEventListener('DOMContentLoaded', hideLoading);



function chamdiemDoan(masv,tendetai, madetai, manguoicham, tennguoicham,vaitrodt) {
    document.getElementById('modalMadt').textContent = madetai;
    document.getElementById('modalTen').textContent = tennguoicham;
    document.getElementById('modalTen').dataset.manguoicham = manguoicham;
    document.getElementById('modalTendetai').textContent = tendetai;
    document.getElementById("modalTendetai").dataset.vaitro = vaitrodt; 
    document.getElementById('chamdiemModal').style.display = 'flex';
}


function closeModalChamDiem() {
    document.getElementById('chamdiemModal').style.display = 'none';
}

document.getElementById("btnSaveChamDiem").addEventListener("click", function () {
    // Lấy dữ liệu từ các trường trong form
    const diem = document.getElementById("diem").value;
    const nhanxet = document.getElementById("nhanxet").value;
    const magv = document.getElementById("modalTen").dataset.manguoicham; // Gán mã người chấm từ dataset
    const madetai = document.getElementById("modalMadt").innerText; // Lấy mã đề tài từ nội dung
  
    const vaitrodt = document.getElementById("modalTendetai").dataset.vaitro;
    console.log(vaitrodt);
    console.log(magv);

    // Kiểm tra các trường dữ liệu
    if (!magv || !madetai) {
        alert("Thiếu thông tin mã người chấm hoặc mã đề tài!");
        return;
    }

    // Tạo đối tượng dữ liệu để gửi
    const data = {
        magv: magv,
        madetai: madetai,
        diem: diem,
        nhanxet: nhanxet,
        vaitro : vaitrodt,
    };

    // Gửi dữ liệu qua AJAX
    fetch("./luuchamdiem.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
    })
        .then((response) => response.json())
        .then((result) => {
            if (result.success) {
                alert("Lưu điểm thành công!");
                closeModalChamDiem();
                location.reload();
                // Có thể đóng modal hoặc làm mới giao diện
            } else {
                alert("Lưu điểm thất bại: " + result.message);
            }
        })
        .catch((error) => {
            console.error("Lỗi:", error);
            alert("Đã xảy ra lỗi trong quá trình lưu.");
        });
});




function suadiemDoan(phieudiem_id, tendt, madt, tennguoi, diem, nhanxet, vaitro) {
    // Gán dữ liệu vào modal
    document.getElementById("modalSuaTendetai").textContent = tendt;
    document.getElementById("modalSuaMadt").textContent = madt;
 
    document.getElementById("modalSuaTen").textContent = tennguoi;
    document.getElementById("suaDiem").value = diem;
    document.getElementById("suaNhanxet").value = nhanxet;

    // Hiển thị modal
    document.getElementById("suadiemModal").style.display = "flex";

    // Lưu `phieudiem_id` để sử dụng khi gửi yêu cầu
    document.getElementById("suadiemModal").setAttribute("data-phieudiem-id", phieudiem_id);
}

function closeModalSuaDiem() {
    document.getElementById("suadiemModal").style.display = "none";
}

function submitSuaDiem() {
    // Lấy dữ liệu từ modal
    const phieudiem_id = document.getElementById("suadiemModal").getAttribute("data-phieudiem-id");
    const diem = document.getElementById("suaDiem").value;
    const nhanxet = document.getElementById("suaNhanxet").value;
   

    // Kiểm tra dữ liệu đầu vào
    if (!diem ) {
        alert("Vui lòng nhập điểm");
        return;
    }

    // Gửi dữ liệu qua AJAX
    fetch('./suadiem.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ phieudiem_id, diem, nhanxet})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Cập nhật thành công!");
            closeModalSuaDiem();
            location.reload(); // Tải lại trang sau khi lưu
        } else {
            alert("Lỗi: " + data.message);
        }
    })
    .catch(error => console.error("Lỗi khi gửi dữ liệu:", error));
}





// Hàm gửi yêu cầu tổng hợp điểm
function tongHopDiem(madt, loai) {
    alert(loai);
    // Gửi AJAX đến PHP để thực hiện tổng hợp điểm
    var xhr = new XMLHttpRequest();
    xhr.open('POST', './tonghopdiemkhoaluan.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Dữ liệu gửi đi
    var data = 'madt=' + encodeURIComponent(madt) + '&loai=' + encodeURIComponent(loai);

    // Xử lý kết quả trả về từ PHP
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = xhr.responseText;
            alert(response);  // Hiển thị kết quả
            location.reload();
        } else {
            alert("Lỗi khi tổng hợp điểm.");
        }
    };

    // Gửi dữ liệu
    xhr.send(data);
}



// Hàm tổng hợp điểm cho đề tài đồ án
function tongHopDiemDoan(madt, loai) {
    alert(loai);
    // Gửi AJAX request đến PHP để tổng hợp điểm
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./tonghopdiemdoan.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Dữ liệu gửi đi
    var data = 'madt=' + encodeURIComponent(madt) + '&loai=' + encodeURIComponent(loai);

    // Gửi madetai và loai qua POST
    xhr.send(data);

    // Xử lý kết quả trả về từ PHP
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = xhr.responseText;
            alert(response);  // Hiển thị thông báo kết quả
            location.reload();
        } else {
            alert("Lỗi khi tổng hợp điểm.");
        }
    };
}



// Gửi yêu cầu AJAX để công bố điểm
function congBoDiem(madetai) {
    
    fetch('./congboketqua.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=congbo&madetai=${encodeURIComponent(madetai)}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Hiển thị kết quả từ PHP
        location.reload(); // Tải lại trang
    })
    .catch(error => console.error('Lỗi:', error));
}

// Gửi yêu cầu AJAX để hủy công bố điểm
function huyCongBo(madetai) {
    fetch('./congboketqua.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=huycongbo&madetai=${encodeURIComponent(madetai)}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Hiển thị kết quả từ PHP
        location.reload(); // Tải lại trang
    })
    .catch(error => console.error('Lỗi:', error));
}


function suadiemKetQua(madetai, diemGVHD, diemGVPB, diemChuTich) {
    console.log("Mã đề tài:", madetai);
    console.log("Điểm GVHD:", diemGVHD);
    console.log("Điểm GVPB:", diemGVPB);
    console.log("Điểm Chủ tịch:", diemChuTich);

    // Gán giá trị vào modal
    document.getElementById('modalSuaTenDeTaiKetQua').innerText = `Đề tài ${madetai}`;
    document.getElementById('modalSuaMaDeTaiKetQua').innerText = madetai;
    document.getElementById('inputDiemGVHD').value = diemGVHD || '';
    document.getElementById('inputDiemGVPB').value = diemGVPB || '';
    document.getElementById('inputDiemChuTich').value = diemChuTich || '';

    // Hiển thị modal
    document.getElementById('modalSuaDiemKetQua').style.display = 'flex';
}


// Đóng modal
function closeModalSuaDiemKetQua() {
    document.getElementById('modalSuaDiemKetQua').style.display = 'none';
}

// Gửi dữ liệu sửa điểm
function submitSuaDiemKetQua() {
    const madetai = document.getElementById('modalSuaMaDeTaiKetQua').innerText;
    const diemGVHD = document.getElementById('inputDiemGVHD').value;
    const diemGVPB = document.getElementById('inputDiemGVPB').value;
    const diemChuTich = document.getElementById('inputDiemChuTich').value;

    fetch('./suadiemketqua.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            madetai : madetai,
            diem_gvhd: diemGVHD,
            diem_gvpb: diemGVPB,
            diem_chutich: diemChuTich,
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Cập nhật điểm thành công!');
                location.reload();
            } else {
                alert('Cập nhật điểm thất bại: ' + data.message);
            }
        });
}

function huyKetQua(madetai) {
    if (confirm("Bạn có chắc chắn muốn hủy kết quả của đề tài: " + madetai + "?")) {
        fetch('./huyketqua.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `madetai=${encodeURIComponent(madetai)}`
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Hiển thị kết quả từ PHP
            location.reload(); // Tải lại trang để cập nhật kết quả
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Đã xảy ra lỗi khi hủy kết quả. Vui lòng thử lại.');
        });
    } else {
        console.log("Người dùng đã hủy yêu cầu hủy kết quả.");
    }
}


function suadiemKetQuaDoAn(madetai, diemGVHD, diemGVPB) {
    console.log("Mã đề tài:", madetai);
    console.log("Điểm GVHD:", diemGVHD);
    console.log("Điểm GVPB:", diemGVPB);
   

    // Gán giá trị vào modal
    document.getElementById('modalSuaTenDeTaiKetQuaDoAn').innerText = `Đề tài ${madetai}`;
    document.getElementById('modalSuaMaDeTaiKetQuaDoAn').innerText = madetai;
    document.getElementById('inputDiemGVHDDoAn').value = diemGVHD || '';
    document.getElementById('inputDiemGVPBDoAn').value = diemGVPB || '';
  

    // Hiển thị modal
    document.getElementById('modalSuaDiemKetQuaDoAn').style.display = 'flex';
}


// Đóng modal
function closeModalSuaDiemKetQuaDoAn() {
    document.getElementById('modalSuaDiemKetQuaDoAn').style.display = 'none';
}

// Gửi dữ liệu sửa điểm
function submitSuaDiemKetQua() {
    const madetai = document.getElementById('modalSuaMaDeTaiKetQuaDoAn').innerText;
    const diemGVHD = document.getElementById('inputDiemGVHDDoAn').value;
    const diemGVPB = document.getElementById('inputDiemGVPBDoAn').value;
   
    fetch('./suadiemketquaDA.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            madetai : madetai,
            diem_gvhd: diemGVHD,
            diem_gvpb: diemGVPB,s
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Cập nhật điểm thành công!');
                location.reload();
            } else {
                alert('Cập nhật điểm thất bại: ' + data.message);
            }
        });
}


function khongdat(madetai,manguoitao) {
    // Hiển thị hộp thoại xác nhận
    var confirmAction = confirm("Bạn có chắc chắn muốn đánh dấu không đạt cho đề tài này?");
    if (!confirmAction) {
        return; // Nếu người dùng chọn 'Hủy', dừng hàm tại đây
    }

    // Gửi yêu cầu AJAX tới PHP
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./danhkhongdat.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Dữ liệu cần gửi
    var data = 'madetai=' + encodeURIComponent(madetai) + '&magv=' + encodeURIComponent(manguoitao);

    xhr.onload = function() {
        if (xhr.status === 200) {
            alert(xhr.responseText); // Thông báo từ PHP
            location.reload();
        } else {
            alert("Có lỗi xảy ra. Vui lòng thử lại."); // Xử lý lỗi nếu HTTP status không phải 200
        }
    };

    xhr.send(data); // Gửi dữ liệu
}

function cholamlai(madetai,manguoitao) {
    // Hiển thị hộp thoại xác nhận
    var confirmAction = confirm("Bạn có chắc chắn muốn mở lại đề tài này?");
    if (!confirmAction) {
        return; // Nếu người dùng chọn 'Hủy', dừng hàm tại đây
    }

    // Gửi yêu cầu AJAX tới PHP
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./cholamlai.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Dữ liệu cần gửi
    var data = 'madetai=' + encodeURIComponent(madetai) + '&magv=' + encodeURIComponent(manguoitao);

    xhr.onload = function() {
        if (xhr.status === 200) {
            alert(xhr.responseText); // Thông báo từ PHP
            location.reload();
        } else {
            alert("Có lỗi xảy ra. Vui lòng thử lại."); // Xử lý lỗi nếu HTTP status không phải 200
        }
    };

    xhr.send(data); // Gửi dữ liệu
}

