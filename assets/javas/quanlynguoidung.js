function showTab(tabId) {
    // Ẩn tất cả các tab
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.style.display = 'none';
    });

    // Hiện tab được chọn
    const selectedTab = document.getElementById(tabId);
    selectedTab.style.display = 'block';

    // Cập nhật trạng thái nút tab
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active');
    });
    document.querySelector(`.tab-button[onclick="showTab('${tabId}')"]`).classList.add('active');
}

function themgv() {
    // Hiển thị modal
    const modal = document.getElementById('modalThemgv');
    modal.style.display = 'block';

    // Hiển thị tab đầu tiên mặc định
    showTab('tab-manual');
}



document.addEventListener('DOMContentLoaded', function () {
    console.log('Script loaded successfully'); // Debug: Kiểm tra script đã tải

    // Lấy tất cả nút "con mắt"
    const buttons = document.querySelectorAll('.view-password-btn');
    
    // Gắn sự kiện click cho từng nút
    buttons.forEach(button => {
        button.addEventListener('click', function () {
            console.log('Eye button clicked'); // Debug: Kiểm tra sự kiện click

            // Lấy phần tử mật khẩu liền trước nút
            const passwordElement = this.previousElementSibling;

            if (!passwordElement) {
                console.error('Password element not found!'); // Debug: Nếu không tìm thấy phần tử
                return;
            }   

            // Kiểm tra và thay đổi hiển thị mật khẩu
            if (passwordElement.style.webkitTextSecurity === 'disc') {
                passwordElement.style.webkitTextSecurity = 'none'; // Hiển thị mật khẩu
                this.textContent = '🔓'; // Đổi biểu tượng
            } else {
                passwordElement.style.webkitTextSecurity = 'disc'; // Ẩn mật khẩu
                this.textContent = '🔒'; // Đổi lại biểu tượng
            }
        });
    });
});


function togglePassword(inputId, button) {
    const passwordInput = document.getElementById(inputId);

    if (passwordInput.type === "password") {
        passwordInput.type = "text"; // Hiển thị mật khẩu
        button.textContent = "🔓"; // Đổi biểu tượng
    } else {
        passwordInput.type = "password"; // Ẩn mật khẩu
        button.textContent = "🔒"; // Đổi lại biểu tượng
    }
}




document.getElementById('formThemgv').addEventListener('submit', function (event) {
    event.preventDefault();
    const formData = new FormData(this);

    fetch('./xulythemgv.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        alert('Giảng viên được thêm thành công!');
        closeModal('modalThemgv'); // Đóng modal
        location.reload(); // Tải lại danh sách
    })
    .catch(error => console.error('Lỗi:', error));
});


// thêm excel
document.getElementById('formExcel').addEventListener('submit', async function (event) {
    event.preventDefault(); // Ngăn form gửi theo cách mặc định
    
    const formData = new FormData(this); // Tạo FormData từ form
    
    try {
        const response = await fetch('./xulythemgvExcel.php', {
            method: 'POST',
            body: formData,
        });

        const result = await response.json(); // Chuyển đổi JSON trả về

        if (result.success) {
            alert('Tải dữ liệu thành công: ' + result.message.join('\\n')); // Hiển thị thông báo thành công
            closeModal('modalThemgv'); // Đóng modal
            location.reload(); // Tải lại danh sách
        } else {
            alert('Tải dữ liệu thất bại: ' + result.errors.join('\\n')); // Hiển thị thông báo lỗi
        }
    } catch (error) {
        alert('Có lỗi xảy ra: ' + error.message); // Xử lý lỗi không mong muốn
    }
});

document.getElementById('xuatExcelGV').addEventListener('click', () => {
    fetch('./xuatExcelGV.php', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Tải file về
            const link = document.createElement('a');
            link.href = data.file;
            link.download = data.file.split('/').pop();
            link.click();
            alert('Xuất file Excel thành công!');
        } else {
            alert('Lỗi: ' + data.message);
        }
    })
    .catch(error => {
        alert('Đã xảy ra lỗi trong quá trình xuất file.');
        console.error(error);
    });
});






// Hiển thị modal sửa và điền thông tin
function hienthisuaGv(ma, hoten, trinhdo, chucvu, email, sdt, diachi) {
    console.log({ ma, hoten, trinhdo, chucvu, email, sdt, diachi });

    // Hiển thị modal sửa giảng viên
    document.getElementById('model-suagv').style.display = 'flex';

    // Gán giá trị vào các trường
    document.getElementById('suagv-ma').value = ma;
    document.getElementById('suagv-hoten').value = hoten;
    document.getElementById('suagv-trinhdo').value = trinhdo; // Dropdown trình độ
    document.getElementById('suagv-email').value = email;
    document.getElementById('suagv-sdt').value = sdt;
    document.getElementById('suagv-diachi').value = diachi;
}


  
  // Đóng modal
  function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
  }
  
  // Lưu thay đổi
  function saveChangesGV() {
    const form = document.getElementById('form-suagv');
    const formData = new FormData(form);
  
    fetch('./xulysuaGv.php', {
      method: 'POST',
      body: formData,
    })
      .then(response => response.text())
      .then(data => {
        alert(data);
        location.reload(); // Tải lại trang sau khi lưu
      })
      .catch(error => console.error('Lỗi:', error));
  }
  

  function xoaGv(ma) {
    if (confirm('Bạn có chắc chắn muốn xóa giảng viên này?')) {
      fetch('./xulyxoaGv.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'ma=' + ma,
      })
        .then(response => response.text())
        .then(data => {
          alert(data);
          location.reload(); // Tải lại trang sau khi xóa
        })
        .catch(error => console.error('Lỗi:', error));
    }
  }
  

  document.getElementById("search-giangvien").addEventListener("input", function () {
    const keyword = this.value.toLowerCase(); // Lấy từ khóa tìm kiếm và chuyển thành chữ thường
    const table = document.querySelector("#giangvien-section table tbody"); // Chỉ chọn bảng dữ liệu giảng viên
    const rows = table.querySelectorAll("tr"); // Lấy tất cả các dòng trong tbody của bảng

    rows.forEach(row => {
        // Lấy toàn bộ text trong các ô của dòng
        const rowText = row.textContent.toLowerCase();

        if (keyword && rowText.includes(keyword)) {
            row.style.backgroundColor = "lightgreen"; // Đổi nền thành xanh lá cho các dòng khớp
        } else {
            row.style.backgroundColor = ""; // Trả lại nền mặc định cho các dòng không khớp
        }
    });
});



// Sinh viên


// Hàm hiển thị tab
function showTab(tabId) {
    // Ẩn tất cả các tab
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.style.display = 'none';
    });

    // Hiện tab được chọn
    const selectedTab = document.getElementById(tabId);
    if (selectedTab) {
        selectedTab.style.display = 'block';
    }

    // Cập nhật trạng thái nút tab
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active');
    });
    const activeButton = document.querySelector(`.tab-button[onclick="showTab('${tabId}')"]`);
    if (activeButton) {
        activeButton.classList.add('active');
    }
}

// Hiển thị modal thêm sinh viên
function themSv() {
    const modal = document.getElementById('modalThemSV');
    if (modal) {
        modal.style.display = 'block';
        showTab('tab-manualSv'); // Hiển thị tab mặc định
    }
}

const formThemsv = document.getElementById('formThemSv');
if (formThemsv) {
    formThemsv.addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(this);

        fetch('./xulythemSV.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                alert('Sinh viên được thêm thành công!');
                closeModal('modalThemSV');
                location.reload();
            })
            .catch(error => console.error('Lỗi:', error));
    });
}


// thêm excel
document.getElementById('formExcelSv').addEventListener('submit', async function (event) {
    event.preventDefault(); // Ngăn không cho form gửi theo cách thông thường
    
    const formData = new FormData(this); // Lấy dữ liệu từ form
    
    try {
        const response = await fetch('./xulythemsvExcel.php', {
            method: 'POST',
            body: formData,
        });

        const result = await response.json(); // Chuyển phản hồi JSON từ PHP thành đối tượng JavaScript

        if (result.success) {
            alert('Tải dữ liệu thành công: ' + result.message.join('\n')); // Hiển thị thông báo thành công
            closeModal('modalThemSV');
            location.reload();
        } else {
            alert('Tải dữ liệu thất bại: ' + result.errors.join('\n')); // Hiển thị thông báo lỗi
        }
    } catch (error) {
        alert('Có lỗi xảy ra: ' + error.message); // Xử lý lỗi không mong muốn
    }
});


// Hiển thị modal sửa sinh viên và điền thông tin
function hienthisuaSV(ma, hoten, diachi, diemtichluy, email, sdt, lop,khoa) {
    const modal = document.getElementById('model-suasv');
    if (modal) {
        modal.style.display = 'block';

        document.getElementById('suasv-ma').value = ma;
        document.getElementById('suasv-hoten').value = hoten;
        document.getElementById('suasv-lop').value = lop;
        document.getElementById('suasv-diem').value = diemtichluy;
        document.getElementById('suasv-email').value = email;
        document.getElementById('suasv-sdt').value = sdt;
        document.getElementById('suasv-diachi').value = diachi;
        document.getElementById('suasv-khoa').value = khoa;
    }
}


// Lưu thay đổi khi sửa sinh viên
function saveChangesSV() {
    const form = document.getElementById('form-suasv');
    if (form) {
        const formData = new FormData(form);

        fetch('./xulysuaSv.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            })
            .catch(error => console.error('Lỗi:', error));
    }
}

// Xóa sinh viên
function xoaSv(ma) {
    if (confirm('Bạn có chắc chắn muốn xóa sinh viên này?')) {
        fetch('./xulyxoaSv.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'ma=' + encodeURIComponent(ma),
        })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            })
            .catch(error => console.error('Lỗi:', error));
    }
}

// Tìm kiếm sinh viên
const searchInput = document.getElementById('timSV');
if (searchInput) {
    searchInput.addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        const table = document.querySelector('#sinhvien-section table tbody');
        if (!table) return;

        const rows = table.querySelectorAll('tr');
        rows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            row.style.backgroundColor = keyword && rowText.includes(keyword) ? 'lightgreen' : '';
        });
    });
}


document.getElementById('xuatExcelSV').addEventListener('click', () => {
    alert("hehehehehe");
    fetch('./xuatExcelSV.php', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Tải file về
            const link = document.createElement('a');
            link.href = data.file;
            link.download = data.file.split('/').pop();
            link.click();
            alert('Xuất file Excel thành công!');
        } else {
            alert('Lỗi: ' + data.message);
        }
    })
    .catch(error => {
        alert('Đã xảy ra lỗi trong quá trình xuất file.');
        console.error(error);
    });
});



// quản lý quản trị viên

// Hiển thị modal thêm quản trị
function themQT() {
    const modal = document.getElementById('modalThemQT');
    if (modal) {
        modal.style.display = 'block';
        showTab('tab-manualQT'); // Hiển thị tab mặc định
    }
}

// Gửi form thêmquản trị
const formThemqt = document.getElementById('formThemQT');
if (formThemqt) {
    formThemqt.addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(this);

        fetch('./xulythemQT.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                alert('Sinh viên được thêm thành công!');
                closeModal('modalThemQT');
                location.reload();
            })
            .catch(error => console.error('Lỗi:', error));
    });
}

document.getElementById('formExcelQT').addEventListener('submit', async function (event) {
    event.preventDefault();
    if (this.dataset.submitting === 'true') return;

    this.dataset.submitting = 'true';

    const formData = new FormData(this);

    try {
        const response = await fetch('./xulythemqtExcel.php', {
            method: 'POST',
            body: formData,
        });

        const text = await response.text(); // Lấy phản hồi dưới dạng văn bản
        console.log('Phản hồi từ PHP:', text);

        const result = JSON.parse(text); // Chuyển đổi sang JSON

        if (result.success) {
            alert('Tải dữ liệu thành công: ' + result.message.join('\n'));
            closeModal('modalThemQT');
            location.reload();
        } else {
            alert('Tải dữ liệu thất bại: ' + result.errors.join('\n'));
        }
    } catch (error) {
        console.error('Lỗi xử lý:', error);
        alert('Có lỗi xảy ra: ' + error.message);
        alert('vailon');
    } finally {
        this.dataset.submitting = 'false';
    }
});





// Hiển thị modal sửa sinh viên và điền thông tin
function hienthisuaQT(ma, hoten, diachi,  email, sdt) {
    const modal = document.getElementById('model-suaqt');
    if (modal) {
        modal.style.display = 'block';

        document.getElementById('suaqt-ma').value = ma;
        document.getElementById('suaqt-hoten').value = hoten;
        document.getElementById('suaqt-email').value = email;
        document.getElementById('suaqt-sdt').value = sdt;
        document.getElementById('suaqt-diachi').value = diachi;
    }
}


// Lưu thay đổi khi sửa sinh viên
function saveChangesQT() {
    const form = document.getElementById('form-suaqt');
    if (form) {
        const formData = new FormData(form);

        fetch('./xulysuaQt.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            })
            .catch(error => console.error('Lỗi:', error));
    }
}

// Xóa quản trị
function xoaQT(ma) {
    if (confirm('Bạn có chắc chắn muốn xóa quản trị này?')) {
        fetch('./xulyxoaQt.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'ma=' + encodeURIComponent(ma),
        })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            })
            .catch(error => console.error('Lỗi:', error));
    }
}

// Tìm kiếm sinh viên
const searchInput2 = document.getElementById('timQT');
if (searchInput2) {
    searchInput2.addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        const table = document.querySelector('#quantrivien-section table tbody');
        if (!table) return;

        const rows = table.querySelectorAll('tr');
        rows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            row.style.backgroundColor = keyword && rowText.includes(keyword) ? 'lightgreen' : '';
        });
    });
}


document.getElementById('xuatExcelQT').addEventListener('click', () => {
    fetch('./xuatExcelQT.php', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Tải file về
            const link = document.createElement('a');
            link.href = data.file;
            link.download = data.file.split('/').pop();
            link.click();
            alert('Xuất file Excel thành công!');
        } else {
            alert('Lỗi: ' + data.message);
        }
    })
    .catch(error => {
        alert('Đã xảy ra lỗi trong quá trình xuất file.');
        console.error(error);
    });
});










  // // Xử lý xác thực mật khẩu nâng cao
    // document.getElementById('form-mknangcao').addEventListener('submit', function (e) {
    //     e.preventDefault();
    //     const tenTK = this.dataset.tentk;
    //     const mkNangCao = document.getElementById('input-mknangcao').value;

    //     console.log(`Verifying advanced password for: ${tenTK}`); // Debug

    //     // Gửi yêu cầu xác thực mật khẩu nâng cao
    //     fetch('./xacthucmknangcao.php', {
    //         method: 'POST',
    //         headers: { 'Content-Type': 'application/json' },
    //         body: JSON.stringify({ tentk: tenTK, mknangcao: mkNangCao })
    //     })
    //         .then(response => response.json())
    //         .then(data => {
    //             console.log(data); // Debug kết quả trả về
    //             if (data.success) {
    //                 currentPasswordElement.style.webkitTextSecurity = 'none'; // Hiển thị mật khẩu
    //                 alert('Mật khẩu nâng cao đúng! Đã hiển thị mật khẩu.');
    //             } else {
    //                 alert('Mật khẩu nâng cao không chính xác!');
    //             }
    //         })
    //         .catch(err => {
    //             console.error('Lỗi:', err);
    //             alert('Có lỗi xảy ra khi xác thực mật khẩu nâng cao.');
    //         });
    // });


// Hiển thị modal sửa sinh viên và điền thông tin
function hienthisuaTK(ma, hoten, quyen,  mk, tt) {
    const modal = document.getElementById('model-suatk');
    if (modal) {
        modal.style.display = 'block';

        document.getElementById('suatk-ma').value = ma;
        document.getElementById('suatk-tentk').value = hoten;
        document.getElementById('suatk-quyen').value = quyen;
        document.getElementById('suatk-mk').value = mk;
        document.getElementById('suatk-tt').value = tt;
    }
}


// Lưu thay đổi khi sửa sinh viên
function saveChangesTK() {
    const form = document.getElementById('form-suatk');
    if (form) {
        const formData = new FormData(form);

        fetch('./xulysuaTk.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            })
            .catch(error => console.error('Lỗi:', error));
    }
}

const searchInput3 = document.getElementById('timTK');
if (searchInput3) {
    searchInput3.addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        const table = document.querySelector('#taikhoan-section table tbody');
        if (!table) return;

        const rows = table.querySelectorAll('tr');
        rows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            row.style.backgroundColor = keyword && rowText.includes(keyword) ? 'lightgreen' : '';
        });
    });
}




// Gọi showLoading() trước khi tải lại trang hoặc gửi form
document.querySelector('form').addEventListener('submit', (event) => {
    showLoading();
});

// Ẩn overlay sau khi hành động kết thúc
window.addEventListener('DOMContentLoaded', hideLoading);


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
