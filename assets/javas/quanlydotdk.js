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

function hideLoading() {
    document.getElementById('loading-overlay').style.display = 'none';
}

// Mở modal
function openModal() {
    document.getElementById('createDotModal').style.display = 'block';
  }
  
  // Đóng modal
  function closeModal() {
    document.getElementById('createDotModal').style.display = 'none';
  }
  
  function taoDotDangKy() {
    var dot_name = document.getElementById("dot-name").value;
    var start_date = document.getElementById("start-date").value;
    var end_date = document.getElementById("end-date").value;

    // Đảm bảo các trường không bị bỏ trống
    if (!dot_name || !start_date || !end_date) {
        alert("Vui lòng nhập đầy đủ thông tin!");
        return;
    }

    // Gửi AJAX yêu cầu tới PHP
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./taodotdangky.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    // Gửi dữ liệu dạng JSON
    var data = JSON.stringify({
        dot_name: dot_name,
        start_date: start_date,
        end_date: end_date
    });

    xhr.onload = function() {
        if (xhr.status == 200) {
            // Xử lý phản hồi từ PHP
            try {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert(response.message);
                    location.reload();
                } else {
                    alert(response.message);
                }
            } catch (e) {
                console.error("Lỗi parse JSON: ", e);
            }
        }
    };

    xhr.send(data);
}


function xoaDot(dotId) {
    if (confirm("Bạn có chắc chắn muốn xóa đợt này?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "./xoadotdk.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");

        var data = JSON.stringify({ id: dotId });

        xhr.onload = function() {
            if (xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert(response.message);
                    location.reload(); // Tải lại trang để cập nhật danh sách
                } else {
                    alert(response.message);
                }
            }
        };

        xhr.send(data);
    }
}


function moDot(madot) {
    if (confirm("Bạn có chắc chắn muốn mở đợt này?")) {
        fetch('./dongmodot.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ action: 'open', madot: madot }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Đợt đã được mở thành công!");
                location.reload(); // Tải lại trang để cập nhật trạng thái
            } else {
                alert("Đã xảy ra lỗi: " + data.message);
                location.reload(); 
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function dongDot(madot) {
    if (confirm("Bạn có chắc chắn muốn đóng đợt này?")) {
        fetch('./dongmodot.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ action: 'close', madot: madot }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Đợt đã được đóng thành công!");
                location.reload(); // Tải lại trang để cập nhật trạng thái
            } else {
                alert("Đã xảy ra lỗi: " + data.message);
                location.reload(); // Tải lại trang để cập nhật trạng thái
            }
        })
        .catch(error => console.error('Error:', error));
    }
}








function suaDot(dotId,ten,bd,kt) {
  
                document.getElementById("edit-dot-id").value = dotId;
                document.getElementById("edit-dot-name").value = ten;
                document.getElementById("edit-start-date").value = bd;
                document.getElementById("edit-end-date").value = kt;
                document.getElementById("modal-sua").style.display = "block";
         
}


function capNhatDot() {
    var dotId = document.getElementById("edit-dot-id").value;
    var dotName = document.getElementById("edit-dot-name").value;
    var startDate = document.getElementById("edit-start-date").value;
    var endDate = document.getElementById("edit-end-date").value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./suadotdk.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    var data = JSON.stringify({
        id: dotId,
        dot_name: dotName,
        start_date: startDate,
        end_date: endDate
    });

    xhr.onload = function() {
        if (xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert(response.message);
                location.reload(); // Tải lại trang để cập nhật danh sách
            } else {
                alert(response.message);
            }
        }
    };

    xhr.send(data);
}

function dongModal() {
    document.getElementById("modal-sua").style.display = "none"; // Ẩn modal
}

function locSinhVienTheoKhoaVaDot() {
    const khoa = document.getElementById('filter-khoa').value;

    // Gửi yêu cầu đến server để lấy danh sách sinh viên theo khóa
    fetch(`./locsinhvientheokhoa.php?khoa=${khoa}`)
        .then((response) => response.json())
        .then((data) => {
            const tbody = document.getElementById('sinhvien-tbody');
            tbody.innerHTML = ''; // Xóa nội dung cũ

            if (data.length > 0) {
                data.forEach((sinhvien) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td><input type='checkbox' class='checkbox-sv' value='${sinhvien.ma}'></td>
                        <td>${sinhvien.ma}</td>
                        <td>${sinhvien.hoten}</td>
                        <td>${sinhvien.lop}</td>
                        <td>${sinhvien.khoa}</td>
                    `;
                    tbody.appendChild(row);
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="5">Không có sinh viên.</td></tr>';
            }
        })
        .catch((error) => {
            console.error('Lỗi khi tải danh sách sinh viên:', error);
        });
}

function selectAll(type) {
    // Lấy trạng thái của checkbox "Chọn tất cả"
    const selectAllCheckbox = document.getElementById(`select-all-${type}`);
    const checkboxes = document.querySelectorAll(`.checkbox-${type}`);

    // Lặp qua tất cả các checkbox con và đồng bộ trạng thái với checkbox "Chọn tất cả"
    checkboxes.forEach((checkbox) => {
        checkbox.checked = selectAllCheckbox.checked;
    });
}

document.addEventListener("DOMContentLoaded", () => {
    const idDot = document.getElementById("filter-dotdk").value;
    console.log(idDot);
});


function themDotDangKy() {
    // Lấy ID của đợt đăng ký từ dropdown
    const idDot = document.getElementById("filter-dotdk").value;
    console.log(idDot);

    // Kiểm tra nếu chưa chọn đợt
    if (!idDot) {
        alert("Vui lòng chọn một đợt đăng ký!");
        return;
    }

    // Lấy danh sách sinh viên được chọn
    const selectedStudents = Array.from(document.querySelectorAll(".checkbox-sv:checked")).map(
        (checkbox) => checkbox.value
    );

    // Lấy danh sách đề tài được chọn
    const selectedDeTai = Array.from(document.querySelectorAll(".checkbox-dt:checked")).map(
        (checkbox) => checkbox.value
    );

    // Kiểm tra nếu không chọn sinh viên hoặc đề tài
    if (selectedStudents.length === 0 || selectedDeTai.length === 0) {
        alert("Vui lòng chọn ít nhất một sinh viên và một đề tài!");
        return;
    }

    // Debug dữ liệu trước khi gửi
    console.log("Dữ liệu gửi đi:", {
        id_dot: idDot,
        sinhvien: selectedStudents,
        detai: selectedDeTai,
    });

    // Gửi dữ liệu tới server bằng fetch API
    fetch("./themvaodot.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            id_dot: idDot,
            sinhvien: selectedStudents,
            detai: selectedDeTai,
        }),
    })
        .then((response) => {
            console.log("HTTP Status:", response.status); // Debug HTTP Status
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            console.log("Phản hồi từ server:", data); // Debug phản hồi
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert(`Có lỗi xảy ra: ${data.message}`);
            }
        })
        .catch((error) => {
            console.error("Lỗi chi tiết:", error); // Log lỗi chi tiết
            alert("Có lỗi xảy ra khi kết nối đến server. Kiểm tra log để biết thêm chi tiết.");
        });
}


function locSinhVienChuaCoDeTai() {
    const idDot = document.getElementById("filter-dot-sv").value;

    if (!idDot) {
        alert("Vui lòng chọn đợt đăng ký.");
        return;
    }

    fetch(`./locsvchuacodt.php?id_dotdangky=${idDot}`)
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP Status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            const tbody = document.getElementById("sinhvien-chua-tbody");
            tbody.innerHTML = ""; // Xóa nội dung cũ trong bảng

            if (data.success) {
                const sinhvien = data.sinhvien;

                if (sinhvien.length === 0) {
                    // Nếu danh sách rỗng, hiển thị thông báo
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center">Không có sinh viên chưa có đề tài.</td>
                        </tr>
                    `;
                } else {
                    // Hiển thị danh sách sinh viên
                    sinhvien.forEach((sv) => {
                        const row = document.createElement("tr");
                        row.innerHTML = `
                            <td>
                                <input type="radio" class="radio-sv-assign" name="sinhvien" value="${sv.ma}" />
                            </td>
                            <td>${sv.ma}</td>
                            <td>${sv.hoten}</td>
                            <td>${sv.lop}</td>
                            <td>${sv.lydo}</td>
                        `;
                        tbody.appendChild(row);
                    });
                }
            } else {
                alert(data.message);
            }
        })
        .catch((error) => {
            console.error("Lỗi khi tải danh sách sinh viên:", error);
            alert("Có lỗi xảy ra khi kết nối đến server.");
        });
}


function loadDeTaiChuaDuSinhVien(id_dotdangky) {
    fetch(`./locdtchuadusl.php?id_dotdangky=${id_dotdangky}`)
        .then((response) => response.json())
        .then((data) => {
            const tbody = document.getElementById("detai-assign-tbody");
            tbody.innerHTML = ""; // Xóa dữ liệu cũ

            if (data.success) {
                const detai = data.detai;
                if (detai.length === 0) {
                    tbody.innerHTML = "<tr><td colspan='5'>Không có đề tài nào chưa đủ sinh viên.</td></tr>";
                } else {
                    detai.forEach((item) => {
                        tbody.innerHTML += `
                            <tr>
                                <td><input type="radio" class="radio-dt-assign" name="detai-chua" value="${item.madetai}"></td>
                                <td>${item.madetai}</td>
                                <td>${item.tendetai}</td>
                                <td>${item.soluongdk}</td>
                                <td>${item.soluongmax}</td>
                            </tr>
                        `;
                    });
                }
            } else {
                alert(data.message);
            }
        })
        .catch((error) => {
            console.error("Lỗi khi tải danh sách đề tài:", error);
        });
}

function assignDeTai() {
    // Lấy giá trị của iddot từ dropdown
    const idDot = document.getElementById("filter-dot-sv").value;

    // Lấy sinh viên được chọn
    const selectedSV = document.querySelector(".radio-sv-assign:checked");
    if (!selectedSV) {
        alert("Vui lòng chọn một sinh viên.");
        return;
    }
    const maSV = selectedSV.value;

    // Lấy đề tài được chọn
    const selectedDT = document.querySelector(".radio-dt-assign:checked");
    if (!selectedDT) {
        alert("Vui lòng chọn một đề tài.");
        return;
    }
    const maDeTai = selectedDT.value;

    // Gửi yêu cầu đến server
    fetch("./gandetai.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            masv: maSV,
            madetai: maDeTai,
            dotdangky: idDot,
            quantri: 1
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alert("Gán đề tài thành công!");
                // Làm mới danh sách sau khi gán
                locSinhVienChuaCoDeTai();
                loadDeTaiChuaDuSinhVien(idDot);
            } else {
                alert("Gán đề tài thất bại: " + data.message);
            }
        })
        .catch((error) => {
            console.error("Lỗi khi gán đề tài:", error);
            alert("Đã xảy ra lỗi khi gán đề tài.");
        });
}
