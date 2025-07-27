function anNut() {
    const quyen = localStorage.getItem("quyen");
    if (quyen == "quantri") {
        document.getElementById('cddt').style.display = "none";
        document.getElementById('dtct').style.display = "none";
        document.getElementById('ddt').style.display = "none";
        document.getElementById('tl-phancong').style.display = "none";
        document.getElementById('section phan-cong').style.display = "none";
        document.getElementById('control-envet').style.display = "none";
        document.getElementById('section buoibaove').style.display = "none";
        document.getElementById('qldotdk').style.display = "block";
        document.getElementById('qlnd').style.display = "block";
        document.getElementById('qldiem').style.display = "block";
        document.getElementById('them-tin-tuc').style.display = "block";
        document.getElementById('btn-them').style.visibility = "hidden";
       

    }
    else if(quyen == "sinhvien") {
        document.getElementById('cddt').style.display = "none";
        document.getElementById('qldotdk').style.display = "none";
        document.getElementById('qlnd').style.display = "none";
        document.getElementById('qldiem').style.display = "none";
        document.getElementById('ddt').style.display = "none";
        document.getElementById('btn-them').style.visibility = "hidden";
        document.getElementById('tl-phancong').style.display = "none";
        document.getElementById('section phan-cong').style.display = "none";
        document.getElementById('control-envet').style.display = "none";
        document.getElementById('section buoibaove').style.display = "none";
        document.getElementById('them-tin-tuc').style.display = "none";
        

    }
    else if(quyen == "giangvien"){
        document.getElementById('qldotdk').style.display = "none";
        document.getElementById('qlnd').style.display = "none";
        document.getElementById('qldiem').style.display = "none";
        document.getElementById('ddt').style.display = "none";
        document.getElementById('tl-phancong').style.display = "none";
        document.getElementById('section phan-cong').style.display = "none";
        document.getElementById('control-envet').style.display = "none";
        document.getElementById('section buoibaove').style.display = "none";
        document.getElementById('them-tin-tuc').style.display = "none";
        

    }
    else if(quyen == "giaovu"){
        document.getElementById('cddt').style.display = "none";
        document.getElementById('qldotdk').style.display = "none";
        document.getElementById('qlnd').style.display = "none";
        document.getElementById('qldiem').style.display = "none";
        document.getElementById('ddt').style.display = "none";
        document.getElementById('dtct').style.display = "none";
        document.getElementById('btn-them').style.visibility = "hidden";
        document.getElementById('them-tin-tuc').style.display = "none";
       

    }
    else if(quyen =="lanhdao"){
        document.getElementById('cddt').style.display = "none";
        document.getElementById('qldotdk').style.display = "none";
        document.getElementById('qlnd').style.display = "none";
        document.getElementById('qldiem').style.display = "none";
        document.getElementById('dtct').style.display = "none";
        document.getElementById('btn-them').style.visibility = "hidden";
        document.getElementById('tl-phancong').style.display = "none";
        document.getElementById('section phan-cong').style.display = "none";
        document.getElementById('control-envet').style.display = "none";
        document.getElementById('section buoibaove').style.display = "none";
        document.getElementById('them-tin-tuc').style.display = "none";
        


    }
    else{
        document.getElementById('btn-them').style.visibility = "hidden";
        document.getElementById('tl-phancong').style.display = "none";
        document.getElementById('section phan-cong').style.display = "none";
        document.getElementById('control-envet').style.display = "none";
        document.getElementById('section buoibaove').style.display = "none";
        document.getElementById('them-tin-tuc').style.display = "none";
       

    }

};

anNut();


const ma = localStorage.getItem("ma");
// alert(ma);

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




// Phần active các thẻ li trên thanh nav
document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll(".nav ul li a");

    // Kiểm tra và gắn lớp "active" từ localStorage
    const currentSection = localStorage.getItem("currentSection");
    if (currentSection) {
        links.forEach((link) => {
            const name = link.getAttribute("name");
            const parentLi = link.parentElement;

            if (name === currentSection) {
                parentLi.classList.add("active");
            } else {
                parentLi.classList.remove("active");
            }
        });
    }

    // Thêm sự kiện click cho từng mục
    links.forEach((link) => {
        link.addEventListener("click", function () {
            const name = link.getAttribute("name");

            // Lưu phần này vào localStorage
            localStorage.setItem("currentSection", name);

            // Loại bỏ lớp "active" khỏi tất cả các mục
            links.forEach((otherLink) => {
                otherLink.parentElement.classList.remove("active");
            });

            // Thêm lớp "active" vào mục đã nhấn
            link.parentElement.classList.add("active");
        });
    });
});


// chuyển cách item 

function tran_left() {
    var links = document.querySelectorAll(".list_summary .item");

    links.forEach(function (link) {
        link.style.transform = "translateX(100%)";
        link.style.transition = "all ease 0.3s";
    });
}

function tran_right() {
    var links = document.querySelectorAll(".list_summary .item");

    // Sử dụng vòng lặp để thiết lập CSS cho từng phần tử
    links.forEach(function (link) {
        link.style.transform = "translateX(-100%)";
        link.style.transition = "all ease 0.3s";
    });
}



// Hàm ẩn tất cả các nội dung
function hideAllContent() {
    var contentDivs = document.querySelectorAll(".con");
    contentDivs.forEach(function (div) {
        div.style.display = "none";
    });
}

// Hàm hiển thị nội dung của một phần tử cụ thể
function showContent(contentId) {
    var contentDiv = document.getElementById(contentId);
    var footer = document.getElementById("footer");

    if (contentDiv) {
        // Hiển thị phần tử được chọn
        contentDiv.style.display = "block";
    }

    // Điều chỉnh margin-top của footer
    if (contentId === "contact" || contentId === "envent") {
        footer.style.marginTop = "1500px"; // Điều chỉnh margin khi cần
    } else {
        footer.style.marginTop = "0px";
    }
}






document.addEventListener("DOMContentLoaded", function () {
    // Lấy trạng thái từ localStorage
    const savedSection = localStorage.getItem("currentSection");

    // Nếu có trạng thái lưu trữ, hiển thị phần đó, ngược lại hiển thị phần mặc định
    const sectionToShow = savedSection || "summary";

    hideAllContent(); // Ẩn tất cả nội dung
    showContent(sectionToShow); // Hiển thị nội dung cần thiết

    // Xóa trạng thái sau khi sử dụng
    if (savedSection) {
        localStorage.removeItem("currentSection");
    }

    // Lắng nghe sự kiện click trên các thẻ "a"
    var menuItems = document.querySelectorAll("#big-option a");
    menuItems.forEach(function (item) {
        item.addEventListener("click", function (event) {
            // Ngăn chặn hành vi mặc định của thẻ "a"
            event.preventDefault();

            // Lấy giá trị thuộc tính "name" của thẻ "a" được click
            const targetContent = item.getAttribute("name");

            // Lưu lại trạng thái vào localStorage
            localStorage.setItem("currentSection", targetContent);

            // Ẩn tất cả các nội dung và hiển thị nội dung mới
            hideAllContent();
            showContent(targetContent);
        });
    });
});




// tự động gọi tran-left và right
function autoTransition() {
    // Bắt đầu với tran_left
    tran_left();

    // Hàm chuyển đổi tự động
    function autoSwitch() {
        setTimeout(function () {
            tran_right();
            // Sau khi gọi tran_right, đặt lại bộ đếm để chuyển về tran_left
            setTimeout(function () {
                tran_left();
                // Tiếp tục vòng lặp
                autoSwitch();
            }, intervalTime);
        }, intervalTime);
    }

    // Bắt đầu auto switch
    autoSwitch();
}

const intervalTime = 8000; // Thời gian giữa các lần gọi hàm

// Bắt đầu auto transition khi trang web được tải
autoTransition();


document.addEventListener('DOMContentLoaded', function () {
    var userIcon = document.getElementById('userIcon');
    var userMenu = document.getElementById('userMenu');
    var name = document.getElementById('name'); // Thêm phần tử name

    // Khi click vào userIcon hoặc name, hiển thị/ẩn menu
    userIcon.addEventListener('click', function () {
        userMenu.style.display = userMenu.style.display === 'block' ? 'none' : 'block';
    });

    name.addEventListener('click', function () {
        userMenu.style.display = userMenu.style.display === 'block' ? 'none' : 'block';
    });

    // Ẩn menu khi nhấp chuột bên ngoài
    window.addEventListener('click', function (event) {
        if (!userIcon.contains(event.target) && !userMenu.contains(event.target) && !name.contains(event.target)) {
            userMenu.style.display = 'none';
        }
    });
});

// document.addEventListener('DOMContentLoaded', function() {
//     var userIcon = document.getElementById('name');
//     var userMenu = document.getElementById('userMenu');

//     userIcon.addEventListener('click', function() {
//         userMenu.style.display = userMenu.style.display === 'block' ? 'none' : 'block';
//     });

//     // Ẩn menu khi nhấp chuột bên ngoài
//     window.addEventListener('click', function(event) {
//         if (!userIcon.contains(event.target) && !userMenu.contains(event.target)) {
//             userMenu.style.display = 'none';
//         }
//     });
// });

// đăng xuất
document.addEventListener('DOMContentLoaded', function () {
    // Lắng nghe sự kiện click trên liên kết đăng xuất
    document.getElementById('logoutButton').addEventListener('click', function (event) {
        event.preventDefault(); // Ngăn chặn liên kết chuyển hướng ngay lập tức

        // Gọi hàm đăng xuất
        logout();

        // Xóa userRole từ localStorage và ẩn option-dn
        localStorage.setItem('userRole', '');
        // document.getElementById('option-dn').style.display = 'none';
        // document.getElementById('btndn').innerHTML="Đăng nhập";

        // Load lại trang
        location.reload();
        location.reload();

    });

    // Hàm đăng xuất
    function logout() {
        // 1. Xóa toàn bộ dữ liệu trong localStorage
        localStorage.clear();
    
        // 2. Xóa toàn bộ dữ liệu trong sessionStorage
        sessionStorage.clear();
    
        // 3. Xóa cookie (nếu cần)
        document.cookie.split(";").forEach(cookie => {
            const eqPos = cookie.indexOf("=");
            const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
            document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
        });
    
        // 4. Sử dụng Fetch API để gửi yêu cầu đăng xuất đến server
        fetch('dangxuat.php', {
            method: 'GET', // Hoặc 'POST', tùy theo cấu hình server
            credentials: 'include' // Bao gồm thông tin xác thực trong yêu cầu
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Đăng xuất thất bại');
                }
                return response.json();
            })
            .then(data => {
                console.log('Đăng xuất thành công:', data);
    
                // 5. Chuyển hướng người dùng sau khi đăng xuất
                window.location.href = 'http://localhost/Doan2/index.php';
            })
            .catch(error => {
                console.error('Lỗi khi đăng xuất:', error);
    
                // Chuyển hướng ngay cả khi xảy ra lỗi để đảm bảo logout
                window.location.href = 'http://localhost/Doan2/index.php';
            });
    }
    
});

// Thông tin người dùng
document.getElementById('infoButton').addEventListener('click', function () {
    // Hiển thị overlay
    document.getElementById('overlay').style.display = 'block';

    // Hiển thị hộp thoại
    document.getElementById('employeeInfoDialog').style.display = 'block';

    // Tải thông tin nhân viên từ cơ sở dữ liệu (xulydangnhap.php trả về JSON)
    fetch('laythongtin.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json(); // Chuyển đổi phản hồi thành JSON
        })
        .then(data => {
            if (data.error) {
                // Hiển thị lỗi nếu có trong phản hồi JSON
                document.getElementById('employeeInfoContent').innerHTML = `<p>${data.error}</p>`;
            } else {
                // Chèn thông tin nhân viên vào hộp thoại khi nhận được JSON
                document.getElementById('employeeInfoContent').innerHTML = `
                    <p><span id="text-dia">Mã người dùng: </span>${data.ma}</p>
                    <p><span id="text-dia">Họ tên: </span>${data.hoten}</p>
                    <p><span id="text-dia">Địa chỉ: </span>${data.diachi}</p>
                    <p><span id="text-dia">Email: </span>${data.email}</p>
                    <p><span id="text-dia">SĐT: </span>${data.sdt}</p>
                `;
            }
        })
        .catch(error => {
            // Bắt lỗi nếu xảy ra vấn đề khi kết nối hoặc xử lý dữ liệu
            console.error('Error fetching data:', error);
            document.getElementById('employeeInfoContent').innerHTML = `<p>Có lỗi xảy ra khi tải thông tin.</p>`;
        });
});


document.getElementById("btn-them").addEventListener("click", function () {
    // Hiển thị dialog thêm mới
    document.getElementById("dialog-them").style.display = "block";

    // Load mã chi nhánh từ cơ sở dữ liệu
    fetch('/api/get-ma-chi-nhanh')  // Đường dẫn API để lấy dữ liệu
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById("ma-chi-nhanh");
            select.innerHTML = '';  // Xóa các tùy chọn hiện có
            data.forEach(branch => {
                const option = document.createElement("option");
                option.value = branch.id;
                option.text = branch.name;
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));
});

document.getElementById("dong-dialog").addEventListener("click", function () {
    // Đóng dialog thêm mới
    document.getElementById("dialog-them").style.display = "none";
});

document.getElementById("dong-dialog2").addEventListener("click", function () {
    // Đóng dialog thêm mới
    document.getElementById("dialog-them").style.display = "none";
});

document.getElementById("form-them").addEventListener("submit", function (event) {
    event.preventDefault();

    // Thu thập dữ liệu từ form
    const formData = new FormData(this);

    // Gửi dữ liệu tới server để lưu
    fetch('/api/save-data', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            alert('Lưu thành công!');
            document.getElementById("dialog-them").style.display = "none";
        })
        .catch(error => console.error('Error:', error));
});

document.addEventListener("DOMContentLoaded", function () {
    function submitForm() {
        // Lấy form theo ID
        const form = document.getElementById('form-them');
        if (form) {
            // Đặt action của form thành trang xulythembcc.php
            form.action = './xulythemdetai.php';
            // Submit form
            form.submit();
        } else {
            console.error('Form không tìm thấy!');
        }
    }

    // Gán hàm submitForm cho sự kiện click của nút Lưu
    document.querySelector('.btn-luu').onclick = submitForm;
});

document.getElementById('upfile-them').addEventListener('click', function (event) {
    openTab(event, 'uploadForm'); // Chuyển đổi tab hiển thị form upload
});

// Thêm sự kiện click cho nút "Upload" để gửi dữ liệu
document.querySelector('#uploadForm .btn-luu').addEventListener('click', function () {
    var form = document.getElementById('uploadExcelForm'); // Form đúng loại
    var formData = new FormData(form); // Tạo đối tượng FormData

    // Kiểm tra xem file đã được chọn chưa
    var fileInput = document.getElementById('excelFile');
    if (!fileInput.files.length) {
        alert('Vui lòng chọn một file trước khi upload.');
        return;
    }

    // Gửi dữ liệu qua AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'xulythemExcel.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Xử lý kết quả trả về
            try {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert('Upload thành công!');
                } else {
                    alert('Lỗi: ' + response.errors.join(', '));
                }
            } catch (e) {
                console.error('Phản hồi không phải JSON hợp lệ:', xhr.responseText);
            }
        } else {
            alert('Lỗi trong quá trình upload.');
        }
    };
    xhr.send(formData); // Gửi dữ liệu
});

function openTab(evt, tabName) {
    var i, tabcontent, tablinks;

    // Ẩn tất cả các tab
    tabcontent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Loại bỏ class "chon" khỏi tất cả các tab
    tablinks = document.getElementsByClassName("tab-link");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].classList.remove("chon");
    }

    // Hiển thị tab hiện tại và thêm class "chon" cho nút đã chọn
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.classList.add("chon");
}




// Đề tài của tôi






// goi ý tìm kiếm đề tài
function searchSuggestion() {
    const query = document.getElementById('madt').value.trim();
    const branch = document.getElementById('branch').value; // Lấy giá trị học kỳ
    const loaidetai = document.getElementById('bra-loaidetai').value; // Lấy giá trị loại đề tài

    if (query.length > 1) {
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById('suggestions').innerHTML = xhr.responseText;
            }
        };
        // Gửi cả từ khóa tìm kiếm, học kỳ và loại đề tài
        xhr.open('GET', 'goiy.php?query=' + encodeURIComponent(query) + '&branch=' + encodeURIComponent(branch) + '&loaidetai=' + encodeURIComponent(loaidetai), true);
        xhr.send();
    } else {
        document.getElementById('suggestions').innerHTML = '';
    }
}


function selectSuggestion(value) {
    document.getElementById('madt').value = value;
    document.getElementById('suggestions').innerHTML = '';
    
}


document.getElementById('tracuu').addEventListener('click', function (event) {
    event.preventDefault(); // Ngăn chặn hành động mặc định của nút submit

    const query = document.getElementById('madt').value.trim();
    const xhr = new XMLHttpRequest();

    xhr.open('POST', 'xulytimdetai.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            try {
                const results = JSON.parse(xhr.responseText); // Kiểm tra JSON
                if (results.error) {
                    console.error('Lỗi từ server: ' + results.error);
                } else {
                    displayResults(results);
                }
            } catch (e) {
                console.error('Phản hồi không phải là JSON hợp lệ: ', xhr.responseText);
            }
        } else {
            console.error('Lỗi khi lấy dữ liệu tìm kiếm');
        }
    };
    xhr.send(`madetai=${encodeURIComponent(query)}`);
});



function displayResults(results) {
    const resultsContainer = document.getElementById('search-results1');
    resultsContainer.innerHTML = ''; // Xóa kết quả cũ

    if (results.length === 0) {
        resultsContainer.innerHTML = '<div>Không có kết quả nào</div>';
        return;
    }

    results.forEach(item => {
        const mota = item.mota ? item.mota : '...';
        const soluongdk = item.soluongdk !== null && item.soluongdk !== undefined ? item.soluongdk : 0;
    
        // Chuyển đổi thời gian bắt đầu và kết thúc sang định dạng dd-mm-yyyy
        const formatDate = (dateString) => {
            const dateObj = new Date(dateString);
            const day = String(dateObj.getDate()).padStart(2, '0'); // Lấy ngày và đảm bảo là 2 chữ số
            const month = String(dateObj.getMonth() + 1).padStart(2, '0'); // Lấy tháng (tháng trong JavaScript bắt đầu từ 0)
            const year = dateObj.getFullYear(); // Lấy năm
    
            return `${day}-${month}-${year}`; // Định dạng ngày theo dd-mm-yyyy
        };
    
        const thoigianbatdauFormatted = formatDate(item.thoigianbatdau);
        const thoigianhoanthanhFormatted = formatDate(item.thoigianhoanthanh);
    
        const div = document.createElement('div');
        div.className = 'item-info';
        div.innerHTML = `
            <div><span>Mã đề tài: </span><span class="rs-madetai">${item.madetai}</span></div>
            <div><span>Tên đề tài: </span><span class="rs-tendetai">${item.tendetai}</span></div>
            <div><span>Giáo viên hướng dẫn: </span><span class="rs-giaovien">${item.tengv}</span></div>
            <div><span>Thời gian bắt đầu: </span><span class="rs-tgbt">${thoigianbatdauFormatted}</span></div>
            <div><span>Thời gian kết thúc: </span><span class="rs-ketthuc">${thoigianhoanthanhFormatted}</span></div>
            <div><span>Trạng thái: </span><span class="rs-tt">${item.trangthai}</span></div>
            <div><span>Số lượng đăng ký tối đa: </span><span class="rs-solmax">${item.soluongmax}</span></div>
            <div><span>Số lượng đã đăng ký: </span><span class="rs-soldk">${soluongdk}</span></div>
            <div><span>Mô tả: </span><span class="rs-mota">${mota}</span></div>
            <div class="btn-action">
                <a class="btn dangky" data-madt="${item.madetai}" href="#">Đăng ký</a>
                <a class="btn huy-dangky" data-madt="${item.madetai}" style="display: none;" href="#">Hủy đăng ký</a>
                <a class="btn sua" data-madt="${item.madetai}">Sửa</a>
                <a class="btn xoa" data-madt="${item.madetai}">Xóa</a>
                <a class="btn file" data-madt="${item.madetai}">Xem chi tiết</a>
            </div>
        `;
        resultsContainer.appendChild(div);
    
        // Các thao tác tiếp theo (ẩn/hiển thị các nút, kiểm tra quyền, etc.)
        const xem = div.querySelector('.file');
        const sua = div.querySelector('.sua');
        const xoa = div.querySelector('.xoa');
        const ma = localStorage.getItem("ma");
        const registerButton = div.querySelector('.dangky');
        const cancelButton = div.querySelector('.huy-dangky');
    
        const quyen = localStorage.getItem("quyen");
        if (quyen == "giangvien") {
            registerButton.style.display = 'none';
            cancelButton.style.display = 'none';
            if (ma !== item.manguoitao) {
                xem.style.display = 'none'
                sua.style.display = 'none';
                xoa.style.display = 'none';
            }
            else {
                if (item.trangthai == "Đang thực hiện" || item.trangthai == "Hoàn thành") {
                    sua.style.display = 'none';
                    xoa.style.display = 'none';
                    xem.style.display = 'inline-block';
                }
                else {
                    sua.style.display = 'inline-block';
                    xoa.style.display = 'inline-block';
                    xem.style.display = 'none';
                }
                if(item.trangthai == "Đăng ký"){
                    xoa.style.display = 'none';
                }
            }
        }
        else if (quyen == "sinhvien") {
            sua.style.display = 'none';
            xoa.style.display = 'none';
        
            // Kiểm tra trạng thái đăng ký cho mỗi item
            fetch('kiemtradangky.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ madetai: String(item.madetai) }) // Ép kiểu chuỗi nếu cần
            })
                .then(response => response.json())
                .then(data => {
                    // Đặt tất cả các nút và thông báo về trạng thái mặc định
                    registerButton.style.display = 'none';
                    cancelButton.style.display = 'none';
                    xem.style.display = 'none';
                    div.querySelectorAll('.message').forEach(msg => msg.remove()); // Xóa các thông báo cũ nếu có
        
                    let message = ""; // Biến lưu thông báo
        
                    // Ưu tiên kiểm tra nếu đang trong trạng thái thực hiện
                    if (data.in_progress) {
                        xem.style.display = "inline-block"; // Hiển thị nút xem
                        return; // Dừng xử lý nếu đang thực hiện
                    }
        
                    // Kiểm tra các điều kiện khác và đặt thông báo tương ứng
                    if (!data.dotdk_open) {
                        message = "Chưa hoặc đã quá hạn đăng ký";
                    } else if (!data.madetai_in_dotdk) {
                        message = "Đề tài này không trong đợt đăng ký của bạn";
                    } else if (data.registration_count >= 3) {
                        message = "Bạn đã đăng ký đủ 3 đề tài trong đợt này";
                    }
        
                    // Hiển thị thông báo nếu có
                    if (message) {
                        const messageDiv = document.createElement('div');
                        messageDiv.className = 'message';
                        messageDiv.style.color = 'red';
                        messageDiv.innerHTML = message;
                        div.appendChild(messageDiv);
                    } else {
                        // Không có thông báo, kiểm tra trạng thái đăng ký
                        if (data.registered) {
                            cancelButton.style.display = 'inline-block';
                        } else {
                            registerButton.style.display = 'inline-block';
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        }
        else {
            xem.style.display = 'none'
            sua.style.display = 'none';
            xoa.style.display = 'none';
            registerButton.style.display = 'none';
            cancelButton.style.display = 'none';
        }
    });
    
    resultsContainer.addEventListener('click', function (event) {
        const target = event.target;

        if (target.classList.contains('dangky')) {
            event.preventDefault();
            const madetai = target.getAttribute('data-madt');
            handleRegister(event, madetai);
        }

        if (target.classList.contains('huy-dangky')) {
            event.preventDefault();
            const madetai = target.getAttribute('data-madt');
            handleCancelRegistration(target, madetai);
        }

        if (target.classList.contains('sua')) {
            const itemId = target.getAttribute('data-madt');
            handleEdit(itemId, target.closest('.item-info'));
        }

        if (target.classList.contains('xoa')) {
            const itemId = target.getAttribute('data-madt');
            handleDelete(itemId, target.closest('.item-info'));
        }

        if (target.classList.contains('file')) {
            const mabcc = target.getAttribute('data-madt');
            xemchitiet(mabcc);
        }
    });
}




document.getElementById('dong-sua').addEventListener("click", function () {
    document.getElementById('editModal').style.display = "none";
});

document.getElementById('dong-info').addEventListener("click", function () {
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('employeeInfoDialog').style.display = 'none';
});

function xemchitiet(mabcc) {

    window.location.href = './detai/' + encodeURIComponent(mabcc) + '.php';


};

// Hàm xử lý sửa
function handleEdit(madetai, div) {
    const modal = document.getElementById('editModal');
    const modalMabcc = document.getElementById('modal-madetai');
    const modalTenbcc = document.getElementById('modal-tendetai');
    const modalTg_batdau = document.getElementById('modal-tg_batdau');
    const modalTg_ketthuc = document.getElementById('modal-tg_ketthuc');
    const modalsolmax = document.getElementById('sua-solmax');
    const modalMota = document.getElementById('sua-mota');

    // Giả định bạn có dữ liệu `item` từ id `madetai`
    modalMabcc.value = madetai;
    modalTenbcc.value = div.querySelector('.rs-tendetai').textContent;
    modalTg_batdau.value = div.querySelector('.rs-tgbt').textContent;
    modalTg_ketthuc.value = div.querySelector('.rs-ketthuc').textContent;
    modalsolmax.value = div.querySelector('.rs-solmax').textContent;
    modalMota.value = div.querySelector('.rs-mota').textContent;

    modal.style.display = "block";

    document.getElementById('saveBtn').onclick = function () {
        saveEdit(madetai, modalTenbcc.value, modalTg_batdau.value, modalTg_ketthuc.value, modalsolmax.value, modalMota.value, div);
    };
}

function saveEdit(madetai, newtendetai, newTg_batdau, newTg_ketthuc, new_solmax, new_mota, div) {
    fetch('update_item.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            madetai,
            newtendetai,
            newTg_batdau,
            newTg_ketthuc,
            new_solmax,
            new_mota
        })
    })
        .then(response => response.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    div.querySelector('.rs-tendetai').textContent = newtendetai;
                    div.querySelector('.rs-tgbt').textContent = newTg_batdau;
                    div.querySelector('.rs-ketthuc').textContent = newTg_ketthuc;
                    div.querySelector('.rs-solmax').textContent = new_solmax;
                    div.querySelector('.rs-mota').textContent = new_mota;

                    modal.style.display = "none";
                    hienThiThongBao("thanhcong", "Cập nhật thành công");
                } else {
                    hienThiThongBao("thatbai", data.error);
                }
            } catch (error) {
                console.error('Failed to parse JSON:', text);
                hienThiThongBao("thatbai", "Có lỗi xảy ra, vui lòng thử lại sau");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            hienThiThongBao("thatbai", "Có lỗi xảy ra, vui lòng thử lại sau");
        });
}

// Lưu dữ liệu sửa
function saveEdit(madetai, newtendetai, newTg_batdau, newTg_ketthuc, new_solmax, new_mota, div) {
    console.log(madetai, newtendetai, newTg_batdau, newTg_ketthuc, new_solmax, new_mota);

    fetch('update_item.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            madetai,
            newtendetai,
            newTg_batdau,
            newTg_ketthuc,
            new_solmax,
            new_mota
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                div.querySelector('.rs-tendetai').textContent = newtendetai;
                div.querySelector('.rs-tgbt').textContent = newTg_batdau;
                div.querySelector('.rs-ketthuc').textContent = newTg_ketthuc;
                div.querySelector('.rs-solmax').textContent = new_solmax
                div.querySelector('.rs-mota').textContent = new_mota;
                hienThiThongBao('thanhcong', 'Thay đổi dữ liệu thành công');

                document.getElementById('editModal').style.display = "none";
            } else {
                console.error("Error from server:", data.error);
                hienThiThongBao('thatbai', 'Phát sinh lỗi trong quá trình thay đổi dữ liệu');
            }
        })
        .catch(error => console.error('Error:', error));
}

// Hàm xử lý xóa
const deletedIds = new Set(); // Tạo một Set để lưu trữ các ID đã xóa

function handleDelete(madetai, div) {
    // Kiểm tra nếu ID đã bị xóa
    if (deletedIds.has(madetai)) {
        hienThiThongBao("thatbai", "Đề tài này đã bị xóa.");
        return; // Ngăn không cho xóa nếu đã xóa rồi
    }

    if (confirm('Bạn có chắc muốn xóa đề tài này?')) {
        fetch('delete_item.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ madetai })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {

                    div.remove(); // Xóa đề tài khỏi giao diện
                    // location.reload();
                    deletedIds.add(madetai); // Thêm ID đã xóa vào Set
                    hienThiThongBao("thanhcong", "Xóa đề tài thành công");
                } else {

                    hienThiThongBao("thatbai", data.error || "Có lỗi xảy ra, vui lòng thử lại.");
                }
            })
            .catch(error => {
                hienThiThongBao("thatbai", "Có lỗi xảy ra, vui lòng thử lại sau");
            });
    }
}


// hàm đăng ký
function handleRegister(event, madetai) {
    event.preventDefault();
    const target = event.target;

    // Kiểm tra nếu số lượng đã đăng ký >= số lượng tối đa
    const soluongdk = parseInt(target.closest('.item-info').querySelector('.rs-soldk').textContent);
    const soluongmax = parseInt(target.closest('.item-info').querySelector('.rs-solmax').textContent);

    if (soluongdk >= soluongmax) {
        alert('Số lượng đã đăng ký đã đạt tối đa.');
        return;
    }

    // Gửi yêu cầu đến PHP để tăng số lượng đăng ký và thêm vào bảng dangkydetai
    fetch('./xulydangkydetai.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ madetai: madetai })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cập nhật giao diện người dùng
                const updatedSoluongdk = soluongdk + 1;
                target.closest('.item-info').querySelector('.rs-soldk').textContent = updatedSoluongdk;
                const itemInfo = target.closest('.item-info');

                // Hiện nút "Đăng ký" và ẩn nút "Hủy đăng ký"
                itemInfo.querySelector('.huy-dangky').style.display = 'inline-block';
                target.style.display = 'none';
                hienThiThongBao('thanhcong', "Đăng ký đề tài thành công");

                // cancelButton.style.display = "inline-block";
            } else {
                alert('Có lỗi xảy ra: ' + data.message);
                hienThiThongBao('thatbai', "Đăng ký đề tài thất bại");
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function handleCancelRegistration(target, madetai) {
    // Gửi yêu cầu đến PHP để hủy đăng ký
    fetch('./xulyhuydangky.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ madetai: madetai })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cập nhật giao diện người dùng
                const itemInfo = target.closest('.item-info');
                const soluongElement = itemInfo.querySelector('.rs-soldk');
                const currentSoluongdk = parseInt(soluongElement.textContent);

                // Kiểm tra nếu soluongdk > 0, giảm 1
                if (currentSoluongdk > 0) {
                    soluongElement.textContent = currentSoluongdk - 1;
                }

                // Hiển thị nút "Đăng ký" và ẩn nút "Hủy đăng ký"
                itemInfo.querySelector('.dangky').style.display = 'inline-block';
                target.style.display = 'none';
                hienThiThongBao('thanhcong', "Hủy đăng ký đề tài thành công");
            } else {
                // alert('Có lỗi xảy ra: ' + data.message);
                // hienThiThongBao('thatbai', "Hủy đăng ký đề tài thất bại");
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}




// timf bang luong

// function searchSuggestion2() {
//     const query = document.getElementById('malop2').value.trim();
//     const branch = document.getElementById('branch2').value; // Lấy giá trị của chi nhánh được chọn

//     if (query.length > 1) {
//         const xhr = new XMLHttpRequest();
//         xhr.onreadystatechange = function () {
//             if (xhr.readyState === 4 && xhr.status === 200) {
//                 document.getElementById('suggestions2').innerHTML = xhr.responseText;
//             }
//         };
//         // Gửi cả từ khóa tìm kiếm và chi nhánh được chọn
//         xhr.open('GET', 'search_bcc2.php?query=' + encodeURIComponent(query) + '&branch=' + encodeURIComponent(branch), true);
//         xhr.send();
//     } else {
//         document.getElementById('suggestions2').innerHTML = '';
//     }
// }

// function selectSuggestion2(value) {
//     document.getElementById('malop2').value = value;
//     document.getElementById('suggestions2').innerHTML = '';
// }

// document.getElementById('tracuu-env').addEventListener('click', function (event) {
//     event.preventDefault(); // Ngăn chặn hành động mặc định của nút submit

//     const query = document.getElementById('malop2').value.trim();
//     const branch = document.getElementById('branch2').value;
//     const xhr = new XMLHttpRequest();

//     xhr.open('POST', 'xulytimbcc2.php', true);
//     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//     xhr.onload = function () {
//         if (xhr.status === 200) {
//             const results = JSON.parse(xhr.responseText);
//             displayResults2(results);
//         } else {
//             console.error('Lỗi khi lấy dữ liệu tìm kiếm');
//         }
//     };
//     xhr.send(`malop=${encodeURIComponent(query)}&branch=${encodeURIComponent(branch)}`);
// });

// function displayResults2(results) {
//     const resultsContainer = document.getElementById('search-results2');
//     resultsContainer.innerHTML = ''; // Xóa kết quả cũ

//     if (results.length === 0) {
//         resultsContainer.innerHTML = '<div>Không có kết quả nào</div>';
//         return;
//     }

//     results.forEach(item => {
//         console.log(item);
//         const div = document.createElement('div');
//         div.className = 'item-info';
//         div.innerHTML = `
//             <div><span>Mã bảng chấm công: </span><span class="mabcc">${item.mabcc}</span></div>
//             <div><span>Tên bảng chấm công: </span><span class="tenbcc">${item.tenbcc}</span></div>
//             <div><span>Thời gian bắt đầu: </span><span class="tg_batdau">${item.tg_batdau}</span></div>
//             <div><span>Thời gian kết thúc: </span><span class="tg_ketthuc">${item.tg_ketthuc}</span></div>
//             <div><span>Giờ chấm công: </span><span class="tg_chamcong">${item.tg_chamcong}</span></div>
//             <div class="btn-action">
//                 <a class="btn tinhluong" data-mabcc="${item.mabcc}" href="#">Tính lương</a>
//                 <a class="btn xem" data-mabcc="${item.mabcc}">Xem tính lương</a>
//             </div>
//         `;
//         resultsContainer.appendChild(div);
//         const quyen = localStorage.getItem("userRole");
//         if (quyen) {
//             const quyen2 = quyen.split("-");

//             // Kiểm tra quyền và ẩn/hiện các nút
//             if (quyen2[0] !== "admin") {
//                 div.querySelector('.tinhluong').style.display = "none";



//             } else {
//                 div.querySelector('.tinhluong').style.display = "inline-block";



//             }
//         } else {
//             console.error("Quyền không tồn tại trong localStorage.");
//         }


//         // Thêm sự kiện cho nút "Chấm công"
//         div.querySelector('.tinhluong').addEventListener('click', (event) => {
//             event.preventDefault(); // Ngăn chặn hành động mặc định của link
//             console.log(`Mã bảng chấm công: ${item.mabcc}`);
//             window.location.href = `./tinhluong.php?mabcc=${item.mabcc}`;
//         });

//         // Thêm sự kiện cho nút "Sửa"
//         div.querySelector('.xem').addEventListener('click', () => {
//             fetch(`./loadxemluong.php?mabcc=${item.mabcc}`)
//                 .then(response => response.json())
//                 .then(data => {
//                     // Hiển thị dialog thông tin lương
//                     showSalaryDialog(data);
//                 })
//                 .catch(error => {
//                     console.error('Lỗi khi tải dữ liệu lương:', error);
//                 });
//         });



//     });
// }

// // Hàm showSalaryDialog hiện thị thông tin lương
// function showSalaryDialog(data) {
//     const dialog = document.querySelector('#salaryDialog');

//     // Kiểm tra xem có lỗi từ server không
//     if (data.error) {
//         console.error(data.error);
//         alert(data.error); // Hoặc hiển thị thông báo lỗi phù hợp
//         return;
//     }

//     dialog.querySelector('.manv').textContent = data[0].manv;
//     dialog.querySelector('.hoten').textContent = data[0].hoten;
//     dialog.querySelector('.songaylam').textContent = data[0].songaylam;
//     dialog.querySelector('.songaynghi').textContent = data[0].songaynghi;
//     dialog.querySelector('.songayditre').textContent = data[0].songayditre;
//     dialog.querySelector('.tongluong').textContent = data[0].tongluong;

//     dialog.showModal(); // Hiển thị dialog
// }


// // Phần tìm lịch làm việc
// document.getElementById('searchForm').addEventListener('submit', function (event) {
//     event.preventDefault();

//     const manv = document.getElementById('manv-lich').value;
//     const searchType = document.getElementById('searchType').value;

//     fetch(`./timlich.php?manv=${manv}&searchType=${searchType}`)
//         .then(response => response.text())
//         .then(data => {
//             // Hiển thị phần tử result khi có kết quả
//             const resultElement = document.getElementById('result');
//             resultElement.style.display = "block";
//             resultElement.innerHTML = data;
//         });
// });


// Quản lý phân công chấm đồ án, khóa luận



document.getElementById("filter-do-an-khoa").addEventListener("change", function () {
    const idDotDangKy = this.value; // Lấy giá trị của đợt đăng ký
    if (idDotDangKy) {
        // Gọi API lấy danh sách đồ án
        fetch(`./loaddetaidoan.php?id_dotdk=${idDotDangKy}`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then((data) => {
                const tbody = document.getElementById("do-an-table-body");
                tbody.innerHTML = ""; // Xóa dữ liệu cũ

                if (data.length > 0) {
                    data.forEach((item) => {
                        tbody.innerHTML += `
                            <tr>
                                <td>${item.madetai}</td>
                                <td>${item.tendetai}</td>
                                <td>${item.sinhvien || "Không có"}</td> 
                                <td>${item.linhvuc || "Không có"}</td>
                                <td>${item.tengv || "Không có"}</td>
                                <td>
                                    <button class="btn-primary" onclick="phancongda('${item.madetai}','${item.magv}','${item.tengv}','${idDotDangKy}')">Phân công</button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    tbody.innerHTML = "<tr><td colspan='6'>Không có dữ liệu</td></tr>";
                }
            })
            .catch((error) => {
                console.error("Lỗi khi tải dữ liệu Đồ án:", error);
                alert(`Đã xảy ra lỗi khi tải đồ án: ${error.message}`);
            });

        // Gọi API lấy lịch sử phân công
        fetch(`./lichsuphancongdoan.php?id_dotdk=${idDotDangKy}`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then((data) => {
                const tbodyLichSu = document.getElementById("lich-su-table-body-do-an");
                tbodyLichSu.innerHTML = ""; // Xóa dữ liệu cũ

                if (data.length > 0) {
                    data.forEach((item) => {
                        tbodyLichSu.innerHTML += `
                            <tr>
                                <td>${item.madetai}</td>
                                <td>${item.tendetai}</td>
                                <td>${item.ten_gvhd}</td>
                                <td>${item.ten_gvpb}</td>
                                <td>${item.ngayphancong}</td>
                                <td>
                                   <button class="btn-danger" onclick="xoaPhanCongda('${item.madetai}')">Xóa</button>
                                    <button class="btn-sua" onclick="suaPhanCongda('${item.madetai}')">Sửa</button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    tbodyLichSu.innerHTML = "<tr><td colspan='6'>Không có dữ liệu</td></tr>";
                }
            })
            .catch((error) => {
                console.error("Lỗi khi tải dữ liệu Lịch sử phân công:", error);
                alert(`Đã xảy ra lỗi khi tải lịch sử phân công: ${error.message}`);
            });
    }
});


function phancongda(madetai, magv, tengv, dot){
    console.log(magv);
    console.log(dot);
    // Hiển thị modal ngay lập tức
    const modal = document.getElementById('modal-phancongda');
    modal.style.display = "block";
    modal.querySelector('.modal-body').innerHTML = `<p>Đang tải dữ liệu...</p>`;

    // Gửi yêu cầu fetch để lấy dữ liệu
    fetch('./laygiangvienda.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ madetai: madetai, magv: magv }) // Gửi dữ liệu JSON
    })
    .then((response) => response.json())
    .then((data) => {
        console.log(data);
        if (data.success) {
            modal.querySelector('.modal-body').innerHTML = `
                <p><strong>Mã đề tài:</strong> ${data.madetai}</p>
                <p><strong>Tên đề tài:</strong> ${data.tendetai}</p>
                <p><strong>Lĩnh vực:</strong> ${data.linhvuc}</p>
                <div>
               <label for="gvhd-da">Giáo viên hướng dẫn : </label>
                <select id="gvhd-da" data-dot="${dot}" class="form-control">
                    <option value="${magv}">${tengv}</option>
                </select>

                </div>
                <div>
                    <label for="phanbien-da" ">Phản biện:</label>
                    <select id="phanbien-da" data-dot="${data.madetai}" class="form-control">
                        ${data.dsPhanBien.map(gv => `<option value="${gv.ma}">${gv.hoten}</option>`).join('')}
                    </select>
                </div>
            `;


            
        } else {
            modal.querySelector('.modal-body').innerHTML = `<p>Lỗi: Không thể tải dữ liệu.</p>`;
        }
    })
    .catch(() => {
        modal.querySelector('.modal-body').innerHTML = `<p>Lỗi: Không thể kết nối tới máy chủ.</p>`;
    });
   
}


function closeModalda() {
   const modal = document.getElementById('modal-phancongda').style.display = "none";
   
}

function savePhanCongda() {
    const madetai = document.getElementById("phanbien-da").dataset.dot;
    const gvhd = document.getElementById('gvhd-da').value.trim();
    const phanbien = document.getElementById('phanbien-da').value.trim();
    const dot = document.getElementById("gvhd-da").dataset.dot;

    console.log(dot);
    console.log(gvhd);
    console.log(phanbien);
    console.log(madetai);

    // Kiểm tra dữ liệu trước khi gửi
    if (!madetai || !gvhd || !phanbien || !dot) {
        alert("Vui lòng điền đầy đủ thông tin trước khi lưu.");
        return;
    }

    // Kiểm tra trùng lặp giảng viên
    if (gvhd === phanbien) {
        alert("Giảng viên hướng dẫn và giảng viên phản biện không được trùng nhau. Vui lòng kiểm tra lại.");
        return;
    }

    // Gửi yêu cầu fetch để lưu thông tin phân công
    fetch('./luuphancongda.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            madetai: madetai,
            gvhd: gvhd,
            phanbien: phanbien,
            dot: dot,
        }),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            if (data.success) {
                alert(data.message); // Hiển thị thông báo thành công

                // Đóng modal sau khi lưu thành công
                closeModalda();

                // Lưu trạng thái vào localStorage để hiển thị phần "contact" sau khi reload
                localStorage.setItem("currentSection", "contact");

                // Reload lại trang
                location.reload();
            } else {
                alert(data.message || "Đã xảy ra lỗi khi lưu thông tin."); // Thông báo lỗi từ server (nếu có)
            }
        })
        .catch((error) => {
            console.error('Lỗi:', error);
            alert('Lỗi khi lưu thông tin phân công: ' + error.message);
        });
}



 // Hàm xóa phân công
 function xoaPhanCongda(madetai) {
    if (confirm("Bạn có chắc chắn muốn xóa phân công này không?")) {
        fetch('./xoaphancongda.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ madetai: madetai })
        })
        .then((response) => response.json())
        .then((data) => {
            alert(data.message);
            if (data.success) {
                // Reload lại danh sách sau khi xóa
                loadDanhSachPhanCong();
                localStorage.setItem("currentSection", "contact");

                // Reload lại trang
                location.reload();
            }
        })
        .catch(() => {
            // alert("Lỗi khi xóa phân công.");
            localStorage.setItem("currentSection", "contact");

                // Reload lại trang
                location.reload();  
        });
    }
}


function suaPhanCongda(madetai) {
    const modal = document.getElementById('modalSuaPhanCong-da');
    modal.style.display = "block";

    // Gửi yêu cầu lấy dữ liệu phân công
    fetch('./layphancongda.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ madetai: madetai }),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            if (data.success) {
                const dsPhanBien = data.dsPhanBien || [];

                document.getElementById('modal-body-sua-da').innerHTML = `
                    <input type="hidden" id="madetai-da" value="${data.madetai || 'Không xác định'}">
                    <p><strong>Mã đề tài:</strong> ${data.madetai || 'Không xác định'}</p>
                    <p><strong>Tên đề tài:</strong> ${data.tendetai || 'Không xác định'}</p>
                    <label for="gvhd">Giáo viên hướng dẫn :</label>
                    <input id="gvhd" value="${data.tengvhd || 'Không xác định'}" disabled>
                    <label for="gvphanbien-da">Phản biện:</label>
                    <select id="gvphanbien-da" class="form-control">
                        ${dsPhanBien.map(
                            (gv) => `<option value="${gv.ma}" ${gv.ma === data.gvphanbien ? 'selected' : ''}>${gv.hoten}</option>`
                        ).join('')}
                    </select>
    
                `;
            } else {
                document.getElementById('modal-body-sua-da').innerHTML = `<p>Lỗi khi tải dữ liệu: ${data.message}</p>`;
            }
        })
        .catch((error) => {
            console.error('Lỗi kết nối:', error);
            document.getElementById('modal-body-sua-da').innerHTML = `<p>Lỗi kết nối tới máy chủ: ${error.message}</p>`;
        });
}




function luuSuaPhanCongda() {
    const madetai = document.getElementById('madetai-da').value;
    const gvphanbien = document.getElementById('gvphanbien-da').value;

    fetch('./luusuaphancongda.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            madetai: madetai,
            gvphanbien: gvphanbien,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            alert(data.message);
            if (data.success) {
                closeModalSuaPhanCongda();
                location.reload(); // Tải lại trang
                localStorage.setItem("currentSection", "contact");
            }
        })
        .catch(() => {
            alert('Lỗi khi lưu thay đổi.');
        });
}

function closeModalSuaPhanCongda() {
    document.getElementById('modalSuaPhanCong-da').style.display = "none";
}













document.getElementById("filter-khoa-luan-khoa").addEventListener("change", function () {
    const idDotDangKy = this.value; // Lấy giá trị của đợt đăng ký
    if (idDotDangKy) {
        fetch(`./loaddetaikhoaluan.php?id_dotdk=${idDotDangKy}`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then((data) => {
                if (data.error) {
                    throw new Error(data.error);
                }

                const tbody = document.getElementById("khoa-luan-table-body");
                tbody.innerHTML = ""; // Xóa dữ liệu cũ

                if (data.length > 0) {
                    data.forEach((item) => {
                        tbody.innerHTML += `
                            <tr>
                                <td>${item.madetai}</td>
                                <td>${item.tendetai}</td>
                                <td>${item.sinhvien || "Không có"}</td>
                                <td>${item.linhvuc || "Không có"}</td>
                                <td>${item.tengv || "Không có"}</td>
                                <td>
                                    <button class="btn-primary" onclick="phancongkl('${item.madetai}','${item.magv}','${item.tengv}','${item.dot}')">Phân công</button>

                                </td>
                            </tr>
                        `;
                    });
                } else {
                    tbody.innerHTML = "<tr><td colspan='6'>Không có dữ liệu</td></tr>";
                }
            })
            .catch((error) => {
                console.error("Lỗi khi tải dữ liệu:", error);
                alert(`Đã xảy ra lỗi: ${error.message}`);
            });

              // Gọi API lấy lịch sử phân công
        fetch(`./lichsuphancongkhoaluan.php?id_dotdk=${idDotDangKy}`)
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            const tbodyLichSu = document.getElementById("lich-su-table-body-khoa-luan");
            tbodyLichSu.innerHTML = ""; // Xóa dữ liệu cũ

            if (data.length > 0) {
                data.forEach((item) => {
                    tbodyLichSu.innerHTML += `
                        <tr>
                            <td>${item.madetai}</td>
                            <td>${item.tendetai}</td>
                            <td>${item.ten_gvtk}</td>
                            <td>${item.ten_gvpb}</td>
                            <td>${item.ten_gvct}</td>
                            <td>${item.ngayphancong}</td>
                            <td>
                                <button class="btn-danger" onclick="xoaPhanCongkl('${item.madetai}')">Xóa</button>
                                <button class="btn-sua" onclick="suaPhanCongkl('${item.madetai}')">Sửa</button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                tbodyLichSu.innerHTML = "<tr><td colspan='6'>Không có dữ liệu</td></tr>";
            }
        })
        .catch((error) => {
            console.error("Lỗi khi tải dữ liệu Lịch sử phân công:", error);
            alert(`Đã xảy ra lỗi khi tải lịch sử phân công: ${error.message}`);
        });
    }
});


function phancongkl(madetai, magv, tengv, dot) {
   

    // Hiển thị modal ngay lập tức
    const modal = document.getElementById('modal-phancong');
    modal.style.display = "block";
    modal.querySelector('.modal-body').innerHTML = `<p>Đang tải dữ liệu...</p>`;

    // Gửi yêu cầu fetch để lấy dữ liệu
    fetch('./laygiangvienkl.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ madetai: madetai, magv: magv }) // Gửi dữ liệu JSON
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.success) {
            modal.querySelector('.modal-body').innerHTML = `
                <p><strong>Mã đề tài:</strong> ${data.madetai}</p>
                <p><strong>Tên đề tài:</strong> ${data.tendetai}</p>
                <p><strong>Lĩnh vực:</strong> ${data.linhvuc}</p>
                <div>
               <label for="thuky">Thư ký:</label>
                <select id="thuky" data-dot="${dot}" class="form-control">
                    <option value="${magv}">${tengv}</option>
                </select>

                </div>
                <div>
                    <label for="phanbien" ">Phản biện:</label>
                    <select id="phanbien" data-dot="${data.madetai}" class="form-control">
                        ${data.dsPhanBien.map(gv => `<option value="${gv.ma}">${gv.hoten}</option>`).join('')}
                    </select>
                </div>
                <div>
                    <label for="chutich">Chủ tịch:</label>
                    <select id="chutich" class="form-control">
                        ${data.dsChuTich.map(gv => `<option value="${gv.ma}">${gv.hoten}</option>`).join('')}
                    </select>
                </div>
            `;
        } else {
            modal.querySelector('.modal-body').innerHTML = `<p>Lỗi: Không thể tải dữ liệu.</p>`;
        }
    })
    .catch(() => {
        modal.querySelector('.modal-body').innerHTML = `<p>Lỗi: Không thể kết nối tới máy chủ.</p>`;
    });
}


function closeModalkl() {
    const modal = document.getElementById('modal-phancong').style.display = "none";
    
}


// Hàm xử lý lưu thông tin phân công
function savePhanCongkl() {
    const madetai = document.getElementById("phanbien").dataset.dot;
    const thuky = document.getElementById('thuky').value.trim();
    const phanbien = document.getElementById('phanbien').value.trim();
    const chutich = document.getElementById('chutich').value.trim();
    const dot = document.getElementById("thuky").dataset.dot;

    console.log(dot);
    console.log(thuky);
    console.log(phanbien);
    console.log(chutich);
    console.log(madetai);

    // Kiểm tra dữ liệu trước khi gửi
    if (!madetai || !thuky || !phanbien || !chutich || !dot) {
        alert("Vui lòng điền đầy đủ thông tin trước khi lưu.");
        return;
    }

    // Kiểm tra xem giảng viên có bị trùng không
    if (thuky === phanbien || thuky === chutich || phanbien === chutich) {
        alert("Các giảng viên không được trùng nhau. Vui lòng kiểm tra lại.");
        return;
    }

    // Gửi yêu cầu fetch để lưu thông tin phân công
    fetch('./luuphancongkl.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            madetai: madetai,
            thuky: thuky,
            phanbien: phanbien,
            chutich: chutich,
            dot: dot,
        }),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            if (data.success) {
                alert(data.message); // Hiển thị thông báo thành công
                closeModalkl();
                // Đóng modal sau khi lưu thành công
                location.reload(); // Tải lại trang
                localStorage.setItem("currentSection", "contact");

               
            } else {
                alert(data.message || "Đã xảy ra lỗi khi lưu thông tin."); // Hiển thị thông báo lỗi từ server
            }
        })
        .catch((error) => {
            console.error('Lỗi:', error);
            alert('Lỗi khi lưu thông tin phân công: ' + error.message);
        });
}


 // Hàm xóa phân công
function xoaPhanCongkl(madetai) {
    if (confirm("Bạn có chắc chắn muốn xóa phân công này không?")) {
        fetch('./xoaphancongkl.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ madetai: madetai })
        })
        .then((response) => response.json())
        .then((data) => {
            alert(data.message);
            if (data.success) {
                // Reload lại danh sách sau khi xóa
                // loadDanhSachPhanCong();
                location.reload(); // Tải lại trang
                localStorage.setItem("currentSection", "contact");
            }
           
        })
        .catch(() => {
            alert("Lỗi khi xóa phân công."+ data.message);
        });
    }
}

function suaPhanCongkl(madetai) {
    const modal = document.getElementById('modalSuaPhanCong');
    modal.style.display = "block";

    // Gửi yêu cầu lấy dữ liệu phân công
    fetch('./layphancongkl.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ madetai: madetai }),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            if (data.success) {
                const dsPhanBien = data.dsPhanBien || [];
                const dsChuTich = data.dsChuTich || [];

                document.getElementById('modal-body-sua').innerHTML = `
                    <input type="hidden" id="madetai" value="${data.madetai || 'Không xác định'}">
                    <p><strong>Mã đề tài:</strong> ${data.madetai || 'Không xác định'}</p>
                    <p><strong>Tên đề tài:</strong> ${data.tendetai || 'Không xác định'}</p>
                    <label for="gvthuky">Thư ký:</label>
                    <input id="gvthuky" value="${data.tenthuky || 'Không xác định'}" disabled>
                    <label for="gvphanbien">Phản biện:</label>
                    <select id="gvphanbien" class="form-control">
                        ${dsPhanBien.map(
                            (gv) => `<option value="${gv.ma}" ${gv.ma === data.gvphanbien ? 'selected' : ''}>${gv.hoten}</option>`
                        ).join('')}
                    </select>
                    <label for="chutich">Chủ tịch:</label>
                    <select id="chutich" class="form-control">
                        ${dsChuTich.map(
                            (gv) => `<option value="${gv.ma}" ${gv.ma === data.chutich ? 'selected' : ''}>${gv.hoten}</option>`
                        ).join('')}
                    </select>
                `;
            } else {
                document.getElementById('modal-body-sua').innerHTML = `<p>Lỗi khi tải dữ liệu: ${data.message}</p>`;
            }
        })
        .catch((error) => {
            console.error('Lỗi kết nối:', error);
            document.getElementById('modal-body-sua').innerHTML = `<p>Lỗi kết nối tới máy chủ: ${error.message}</p>`;
        });
}




function luuSuaPhanCong() {
    const madetai = document.getElementById('madetai').value;
    const gvphanbien = document.getElementById('gvphanbien').value;
    const chutich = document.getElementById('chutich').value;

    // Kiểm tra xem gvphanbien và chutich có trùng nhau không
    if (gvphanbien === chutich) {
        alert('Giảng viên phản biện và Chủ tịch không được trùng nhau.');
        return; // Dừng việc gửi yêu cầu
    }

    fetch('./luusuaPhanCong.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            madetai: madetai,
            gvphanbien: gvphanbien,
            chutich: chutich,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            alert(data.message);
            if (data.success) {
                closeModalSuaPhanCong();
                localStorage.setItem("currentSection", "contact");

                // Reload lại trang
                location.reload();
            }
        })
        .catch(() => {
            alert('Lỗi khi lưu thay đổi.');
        });
}


function closeModalSuaPhanCong() {
    document.getElementById('modalSuaPhanCong').style.display = "none";
}


document.getElementById("search-do-an").addEventListener("input", function () {
    const keyword = this.value.toLowerCase(); // Lấy từ khóa tìm kiếm và chuyển thành chữ thường

    // Chọn cả hai bảng
    const tables = document.querySelectorAll("#do-an-section table tbody, #lich-su-phan-cong-do-an table tbody");

    tables.forEach(table => {
        const rows = table.querySelectorAll("tr"); // Lấy tất cả các dòng trong tbody của bảng hiện tại

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
});


document.getElementById("search-khoa-luan").addEventListener("input", function () {
    const keyword = this.value.toLowerCase(); // Lấy từ khóa tìm kiếm và chuyển thành chữ thường

    // Chọn cả hai bảng
    const tables = document.querySelectorAll("#khoa-luan-section table tbody, #lich-su-phan-cong-khoa-luan table tbody");

    tables.forEach(table => {
        const rows = table.querySelectorAll("tr"); // Lấy tất cả các dòng trong tbody của bảng hiện tại

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
});





// goi ý tìm kiếm đề tài
function searchSuggestion2() {
    const query = document.getElementById('malop2').value.trim();
    const branch = ""; // Lấy giá trị học kỳ (nếu cần)
    const loaidetai = document.getElementById('bra-loaidetai-phancong').value; // Lấy giá trị loại đề tài

    if (query.length > 1 || loaidetai) { // Kiểm tra nếu có từ khóa hoặc loại đề tài
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById('suggestions2').innerHTML = xhr.responseText;
            }
        };
        // Gửi cả từ khóa tìm kiếm, học kỳ và loại đề tài
        xhr.open(
            'GET',
            'goiy2.php?query=' + encodeURIComponent(query) +
            '&branch=' + encodeURIComponent(branch) +
            '&loaidetai=' + encodeURIComponent(loaidetai),
            true
        );
        xhr.send();
    } else {
        document.getElementById('suggestions2').innerHTML = '';
    }
}


function selectSuggestion2(value) {
    document.getElementById('malop2').value = value;
    document.getElementById('suggestions2').innerHTML = '';
   
   
}


document.getElementById('tracuu2').addEventListener('click', function (event) {
    event.preventDefault(); // Ngăn chặn hành động mặc định của nút submit

    const query = document.getElementById('malop2').value.trim();
    const loaidetai = document.getElementById('bra-loaidetai-phancong').value; // Lấy giá trị từ dropdown
    const xhr = new XMLHttpRequest();

    console.log(loaidetai);
    console.log(query);

    xhr.open('POST', './xulytimphancong.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            try {
                // Phân tích JSON từ phản hồi
                const results = JSON.parse(xhr.responseText);
                if (results.error) {
                    console.error('Lỗi từ server: ' + results.error);
                    displayError(results.error); // Hiển thị lỗi nếu có
                } else if (results.length === 0) {
                    console.log('Không có dữ liệu phù hợp');
                    displayResultsPhancong(results); // Hiển thị thông báo không tìm thấy
                } else {
                    console.log('Dữ liệu nhận được:', results);
                    displayResultsPhancong(results); // Hiển thị kết quả
                }
            } catch (e) {   
                console.error('Không thể phân tích JSON: ', e, xhr.responseText);
                displayError('Phản hồi không hợp lệ từ server.');
            }
        } else {
            console.error('Lỗi khi lấy dữ liệu tìm kiếm');
            displayError('Không thể kết nối tới server.');
        }
    };

    // Gửi dữ liệu tới server
    xhr.send(`madetai=${encodeURIComponent(query)}&loaidetai=${encodeURIComponent(loaidetai)}`);
});

// Hàm hiển thị thông báo lỗi
function displayError(message) {
    const container = document.getElementById('search-results-phancong');
    container.innerHTML = `<p class="error">Đề tài chưa được phân công.</p>`;
}

// Hàm hiển thị thông báo không có kết quả
function displayNoResults() {
    const container = document.getElementById('search-results-phancong');
    container.innerHTML = '<p>Đề tài chưa được phân công.</p>';
}

function displayResultsPhancong(results) {
  
    const resultsContainer = document.getElementById('search-results-phancong');
    resultsContainer.innerHTML = ''; // Xóa kết quả cũ

    if (results.length === 0) {
        resultsContainer.innerHTML = '<div>Đề tài chưa được phân công</div>';
        return;
    }

    results.forEach(result => {
        const { table, data: item } = result; // Lấy thông tin bảng và dữ liệu
        
        const div = document.createElement('div');
        div.className = 'item-info';

        
        if (table === 'phancongdoan') {
          
            // Hiển thị dữ liệu từ bảng phancongdoan
            div.innerHTML = `
                <div><span>Mã đề tài: </span><span class="rs-madetai">${item.madetai}</span></div>
                <div><span>Tên đề tài: </span><span class="rs-tendetai">${item.tendetai}</span></div>
                <div><span>Giáo viên hướng dẫn: </span><span class="rs-gvhd">${item.gvthuky_ten || 'N/A'}</span></div>
                <div><span>Giáo viên phản biện: </span><span class="rs-gvpb">${item.gvphanbien_ten || 'N/A'}</span></div>
            `;
        } else if (table === 'phancongkhoaluan') {
            // Hiển thị dữ liệu từ bảng phancongkhoaluan
            div.innerHTML = `
                <div><span>Mã đề tài: </span><span class="rs-madetai">${item.madetai}</span></div>
                <div><span>Tên đề tài: </span><span class="rs-tendetai">${item.tendetai}</span></div>
                <div><span>Thư ký: </span><span class="rs-thuky">${item.gvthuky_ten || 'N/A'}</span></div>
                <div><span>Giáo viên phản biện: </span><span class="rs-gvpb">${item.gvphanbien_ten || 'N/A'}</span></div>
                <div><span>Chủ tịch: </span><span class="rs-chutich">${item.chutich_ten || 'N/A'}</span></div>
              
            `;
        }

        resultsContainer.appendChild(div);
    });
}




// Phần sắp lịch bảo vệ


document.querySelector('#btn-them-buoi').addEventListener('click', function () {
  
       document.getElementById('modal-thembuoi').style.display="block";
});

function closeModathem_buoi(){
    document.getElementById('modal-thembuoi').style.display="none";
}
function savethem_buoi(){
    const form = document.querySelector('#form-thembuoi');
    const formData = new FormData(form);

    fetch('./luuthembuoi.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                closeModathem_buoi();
                 localStorage.setItem("currentSection", "envent");

                // Reload lại trang
                location.reload();
            } else {
                alert('Lỗi: ' + data.message);
            }
        })
        .catch(error => console.error('Lỗi khi lưu buổi bảo vệ:', error));
}


// function setThukyOption(tenthuky, mathuky) {
//     const selectElement = document.getElementById("thuky-saplich");

//     // Kiểm tra xem `option` mặc định đã tồn tại hay chưa
//     const existingDefaultOption = selectElement.querySelector(`option[value="${mathuky}"]`);

//     if (!existingDefaultOption) {
//         // Tạo `option` mới nếu chưa tồn tại
//         const newOption = document.createElement("option");
//         newOption.textContent = tenthuky; // Gán nội dung hiển thị
//         newOption.value = mathuky; // Gán giá trị

//         // Thêm `option` mới vào đầu danh sách
//         selectElement.insertBefore(newOption, selectElement.firstChild);

//         // Tự động chọn `option` vừa thêm
//         newOption.selected = true;
//     } else {
//         // Nếu `option` mặc định đã tồn tại, tự động chọn nó
//         existingDefaultOption.selected = true;
//     }
// }




let mb =0;
// Hiển thị modal và gán tên buổi
function saplichBuoi(mabuoi,tenbuoi, diadiem, thuky, mathuky,ngay) {
    const modal = document.getElementById("modalSapLich");

    mb = mabuoi;
  
    document.getElementById("tenbuoi-saplich").value = tenbuoi; // Gán tên buổi vào input
    document.getElementById("diadiem-saplich").value = diadiem; // Địa điểm
   
    // setThukyOption(thuky, mathuky);

   
    document.getElementById("thuky-saplich").dataset.set = mathuky;
    document.getElementById("ngay-saplich").value = ngay; // Ngày tổ chức
    modal.style.display = "flex"; // Hiển thị modal
    fetch(`./loadlichsusaplich.php?mabuoi=${mabuoi}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                const tableBody = document.querySelector(".modal-saplich-table tbody");
                tableBody.innerHTML = ""; // Xóa nội dung cũ của bảng
                
                data.data.forEach((row, index) => {
                    const tableRow = document.createElement("tr");
                
                    // Gắn thuộc tính `data-madetai` vào dòng
                    tableRow.dataset.madetai = row.madetai || "N/A";
                
                    // Cột STT
                    const sttCell = document.createElement("td");
                    sttCell.textContent = index + 1;
                    tableRow.appendChild(sttCell);
                
                    // Cột MSSV
                    const mssvCell = document.createElement("td");
                    mssvCell.textContent = row.masv;
                    tableRow.appendChild(mssvCell);
                
                    // Cột Họ và tên SV
                    const nameCell = document.createElement("td");
                    nameCell.textContent = row.tensinhvien;
                    tableRow.appendChild(nameCell);
                
                    // Cột Mã lớp
                    const classCell = document.createElement("td");
                    classCell.textContent = row.lop;
                    tableRow.appendChild(classCell);
                
                    // Cột Tên đề tài
                    const topicCell = document.createElement("td");
                    topicCell.textContent = row.tendetai;
                    tableRow.appendChild(topicCell);
                
                    // Cột Giảng viên hướng dẫn
                    const supervisorCell = document.createElement("td");
                    supervisorCell.textContent = row.gvthuky; // Sử dụng `gvthuky` như là giảng viên hướng dẫn
                    tableRow.appendChild(supervisorCell);
                
                    // Cột Giảng viên chấm hội đồng
                    const councilCell = document.createElement("td");
                    councilCell.innerHTML = `Chủ tịch: ${row.chutich || "N/A"}<br>Phản biện: ${row.gvphanbien || "N/A"}<br>Thư ký: ${row.gvthuky || "N/A"}`;
                    tableRow.appendChild(councilCell);
                
                    // Cột Thời gian (Bắt đầu - Kết thúc trong hai ô input riêng biệt)
                    const timeCell = document.createElement("td");
                
                    // Tạo input cho thời gian bắt đầu
                    const startTimeInput = document.createElement("input");
                    startTimeInput.type = "time";
                    startTimeInput.className = "start-time-input"; // Thêm lớp CSS nếu cần
                    startTimeInput.value = row.giobd || "00:00"; // Gán giá trị thời gian bắt đầu
                    startTimeInput.placeholder = "Bắt đầu"; // Placeholder nếu cần
                
                    // Tạo input cho thời gian kết thúc
                    const endTimeInput = document.createElement("input");
                    endTimeInput.type = "time";
                    endTimeInput.className = "end-time-input"; // Thêm lớp CSS nếu cần
                    endTimeInput.value = row.giokt || "00:00"; // Gán giá trị thời gian kết thúc
                    endTimeInput.placeholder = "Kết thúc"; // Placeholder nếu cần
                
                    // Thêm hai input vào ô với dấu gạch ngang giữa chúng
                    timeCell.appendChild(startTimeInput);
                    timeCell.appendChild(document.createTextNode(" - ")); // Thêm dấu gạch ngang
                    timeCell.appendChild(endTimeInput);
                    tableRow.appendChild(timeCell);
                
                    // Cột Hành động
                    const actionCell = document.createElement("td");
                    const actionButton = document.createElement("button");
                    actionButton.textContent = "Xóa"; // Thay đổi nội dung nút thành "Xóa"
                    actionButton.className = "modal-saplich-delete"; // Thêm lớp CSS nếu cần
                    actionButton.setAttribute("onclick", "xoaDong(this)"); // Gắn sự kiện onclick để gọi hàm xoaDong
                    actionCell.appendChild(actionButton);
                    tableRow.appendChild(actionCell);
                
                    // Thêm dòng vào bảng
                    tableBody.appendChild(tableRow);
                });
                
            } else {
                console.error("Lỗi:", data.message);
            }
        })
        .catch(error => console.error("Lỗi kết nối:", error));
}
// Hàm xóa và reload trang với click vào một phần tử bất kỳ sau khi reload
function deleteBuoi(ma) {
    if (!confirm("Bạn có chắc chắn muốn xóa buổi này?")) return;

    fetch('./xoaBuoi.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: ma }),
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.status === "success") {
                alert("Xóa buổi thành công!");

                // Lưu trạng thái vào localStorage để hiển thị phần "envent" sau khi reload
                localStorage.setItem("currentSection", "envent");

                // Reload lại trang
                location.reload();
            } else {
                alert("Không thể xóa buổi: " + data.message);
            }
        })
        .catch(error => {
            console.error("Lỗi khi xóa buổi:", error);
            alert("Có lỗi xảy ra khi xóa buổi.");
        });
}






// Đóng modal
function dongModalSapLich() {
    const modal = document.getElementById("modalSapLich");
    modal.style.display = "none";
    localStorage.setItem("currentSection", "envent");

    // Reload lại trang
    location.reload();
}


// Biến lưu dòng được chọn
let dongchon = 1;

// Thêm dòng mới vào bảng
function themDong() {
    const tableBody = document.querySelector(".modal-saplich-table tbody");
    const rowCount = tableBody.rows.length; // Lấy số dòng hiện tại (0-based)

    // Số lượng cột trong bảng
    const colCount = document.querySelectorAll(".modal-saplich-table thead th").length;

    // Tạo một dòng mới
    const row = document.createElement("tr");

    for (let i = 0; i < colCount; i++) {
        const cell = document.createElement("td");

        if (i === 0) {
            // Cột STT (Số thứ tự)
            cell.textContent = rowCount + 1; // 1-based hiển thị
        } else if (i === colCount - 1) {
            // Cột cuối (Hành động) - chứa nút "Thêm" và "Xóa"
            cell.innerHTML = `
                <button class="modal-saplich-add" onclick="themHoiDong(${rowCount})">+</button>
                <button class="modal-saplich-delete" onclick="xoaDong(this)">Xóa</button>
            `;
        } else {
            // Các cột dữ liệu khác
            cell.textContent = ""; // Để trống, dữ liệu sẽ được thêm sau
        }

        row.appendChild(cell);
    }

    tableBody.appendChild(row);
}









// Hiển thị modal và tải danh sách đề tài
function themHoiDong(row) {
    dongchon = row; // Lưu dòng hiện tại được chọn
    const modal = document.getElementById("modal-loadphancong");
    if (modal) {
        modal.style.display = "block";
        loadOptions(); // Gọi hàm tải dữ liệu từ API
    }
}

// Đóng modal
function dongModal() {
    const modal = document.getElementById("modal-loadphancong");
    if (modal) {
        modal.style.display = "none";
    }
}



// Tải danh sách đề tài vào dropdown
function loadOptions() {
    fetch("./loadphancong-chon.php")
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById("phancong-select");
            select.innerHTML = ""; // Xóa các tùy chọn cũ

            // Thêm tùy chọn mới
            data.forEach(option => {
                const opt = document.createElement("option");
                opt.value = option.id;
                opt.textContent = option.madetai;
                select.appendChild(opt);
            });
        })
        .catch(error => console.error("Lỗi khi tải dữ liệu:", error));
}


let mdt = "";
function luuLuaChon() {
    dongModal();
    const selectElement = document.getElementById("phancong-select");
    if (!selectElement || !selectElement.value) {
        console.error("Không tìm thấy <select> hoặc không có giá trị được chọn!");
        return;
    }

    const selectedMadetai = selectElement.value;

    // Gọi API để lấy dữ liệu
    fetch(`./loadphancong-chonluu.php?madetai=${selectedMadetai}`)
    .then(response => response.json())
    .then(data => {
        if (data.status === "error") {
            console.error("Lỗi từ API:", data.message);
            return;
        }

        const { students, commonData } = data;
        const tableBody = document.querySelector(".modal-saplich-table tbody");

        // Kiểm tra dòng được chọn có hợp lệ
        if (dongchon < 0 || dongchon >= tableBody.rows.length) {
            console.error("Dòng được chọn không hợp lệ:", dongchon);
            return;
        }

        const row = tableBody.rows[dongchon]; // Lấy dòng dựa trên chỉ số 0-based

        // Thêm `madetai` vào thuộc tính dữ liệu của dòng
        row.dataset.madetai = commonData.madetai || "N/A";

        // Dữ liệu từ API
        const rowData = [
            students.map(student => student.masv).join(", ") || "N/A", // MSSV (liệt kê tất cả các sinh viên)
            students.map(student => student.tensinhvien).join(", ") || "N/A", // HỌ VÀ TÊN SV
            students.map(student => student.lop).join(", ") || "N/A", // MÃ LỚP
            commonData.tendetai || "N/A", // TÊN ĐỀ TÀI
            commonData.gvthuky || "N/A", // GIẢNG VIÊN HƯỚNG DẪN (Thư ký)
            `Chủ tịch: ${commonData.chutich || "N/A"}<br>Phản biện: ${commonData.gvphanbien || "N/A"}<br>Thư ký: ${commonData.gvthuky || "N/A"}` // GV CHẤM HỘI ĐỒNG
        ];

        // Cập nhật từng ô, bắt đầu từ cột thứ 2 (bỏ qua STT - cột đầu tiên)
        for (let i = 0; i < rowData.length; i++) {
            row.cells[i + 1].innerHTML = rowData[i];
        }

        // Thêm thẻ <input type="time"> cho thời gian bắt đầu và kết thúc
        const timeCell = row.cells[rowData.length + 1];
        timeCell.innerHTML = ""; // Xóa nội dung cột trước

        // Tạo input cho thời gian bắt đầu
        const startTimeInput = document.createElement("input");
        startTimeInput.type = "time";
        startTimeInput.className = "start-time-input"; // Thêm lớp CSS nếu cần
        startTimeInput.placeholder = "Bắt đầu"; // Placeholder nếu cần

        // Tạo input cho thời gian kết thúc
        const endTimeInput = document.createElement("input");
        endTimeInput.type = "time";
        endTimeInput.className = "end-time-input"; // Thêm lớp CSS nếu cần
        endTimeInput.placeholder = "Kết thúc"; // Placeholder nếu cần

        // Thêm hai input vào ô
        timeCell.appendChild(startTimeInput);
        timeCell.appendChild(document.createTextNode(" - ")); // Thêm dấu gạch ngang giữa hai input
        timeCell.appendChild(endTimeInput);

        // Cập nhật lại nút "Xóa" trong cột cuối
        const lastCell = row.cells[row.cells.length - 1];
        lastCell.innerHTML = `<button class="modal-saplich-delete" onclick="xoaDong(this)">Xóa</button>`;
    })
    .catch(error => console.error("Lỗi tải dữ liệu phân công:", error));

// Đóng modal
dongModal();
}






// Xóa dòng khỏi bảng
function xoaDong(button) {
    const row = button.closest("tr"); // Lấy dòng chứa nút bấm
    const madetai = row.dataset.madetai; // Lấy giá trị `madetai` 

    if (madetai) {
        console.log("Mã đề tài của dòng bị xóa:", madetai);

        // Gửi yêu cầu cập nhật trạng thái sang capnhattrangthaichon.php
        fetch("./capnhattrangthaichon.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `madetai=${encodeURIComponent(madetai)}&chon=Chưa chọn`,
        })
            .then(response => {
                if (response.ok) {
                    console.log(`Trạng thái của mã đề tài ${madetai} đã được cập nhật thành "Chưa chọn".`);
                } else {
                    console.error(`Lỗi khi cập nhật trạng thái của mã đề tài ${madetai}.`);
                }
            })
            .catch(error => console.error("Lỗi khi gửi yêu cầu cập nhật trạng thái:", error));
    } else {
        console.error("Không thể lấy mã đề tài của dòng bị xóa!");
    }

    // Xóa dòng
    row.remove();

    // Cập nhật lại số thứ tự (STT)
    const tableBody = document.querySelector(".modal-saplich-table tbody");
    const rows = tableBody.querySelectorAll("tr");
    rows.forEach((tr, index) => {
        tr.querySelector("td").textContent = index + 1; // Cập nhật STT
    });
}






function moModalLuaChon() {
    document.getElementById("modalLuaChon").style.display = "block";
}



function dongModalLuaChon() {
    document.getElementById("modalLuaChon").style.display = "none";
}



async function sapLichTuDong() {
    const rows = document.querySelectorAll("table tbody tr");
    const ngay = document.getElementById("ngay-saplich").value;
    const thoigianMoiDeTai = parseInt(document.getElementById('thoigian-luachon').value) || 10;
    const allocatedSlots = new Set(); // Track allocated time slots to avoid duplicates

    for (const row of rows) {
        const madetai = row.dataset.madetai || null;
        if (!madetai) {
            console.error("Mã đề tài không hợp lệ.");
            continue;
        }

        try {
            // Gửi yêu cầu lấy khung giờ khả dụng từ server
            const response = await fetch('./laygiokhadung.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ madetai, ngay, thoigianMoiDeTai }),
            });

            const data = await response.json();
            if (data.success && data.slots.length > 0) {
                // Find the first available non-allocated slot
                let selectedSlot = null;
                for (const slot of data.slots) {
                    const slotKey = `${slot.start}-${slot.end}`;
                    if (!allocatedSlots.has(slotKey)) {
                        selectedSlot = slot;
                        allocatedSlots.add(slotKey);
                        break;
                    }
                }

                if (selectedSlot) {
                    const { start, end } = selectedSlot;

                    // Gửi yêu cầu cập nhật lịch
                    const updateResponse = await fetch('./saplich.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ madetai, startTime: start, endTime: end, ngay }),
                    });

                    const updateData = await updateResponse.json();
                    if (updateData.success) {
                        console.log(`Lịch sắp xếp thành công cho mã đề tài: ${madetai}`);
                        const timeCell = row.cells[row.cells.length - 2];
                        timeCell.innerHTML = `
                            <input type="time" class="start-time-input" value="${start.slice(0, 5)}">
                            -
                            <input type="time" class="end-time-input" value="${end.slice(0, 5)}">
                        `;
                    } else {
                        console.error(`Không thể sắp xếp cho mã đề tài: ${madetai}`);
                    }
                } else {
                    console.error(`Không tìm được khung giờ không trùng cho mã đề tài: ${madetai}`);
                }
            } else {
                console.error(`Không tìm được khung giờ khả dụng cho mã đề tài: ${madetai}`);
            }
        } catch (error) {
            console.error("Lỗi kết nối server:", error);
        }
    }
}









document.getElementById('close-buoi').addEventListener('click', (e) => {
   document.getElementById('modal-thembuoi').style.display = 'none';
});







function luuSapLich() {
    const rows = document.querySelectorAll('.modal-saplich-table tbody tr');
    const ngaySapLich = document.getElementById('ngay-saplich').value;
    const mathuky = document.getElementById("thuky-saplich").value;
    const tenbuoi = document.getElementById("tenbuoi-saplich").value;
    const diadiem = document.getElementById("diadiem-saplich").value;
    const data = [];
    console.log(mb);
  
    

    rows.forEach(row => {
        const madetai = row.dataset.madetai;
        const startTime = row.querySelector('.start-time-input')?.value;
        const endTime = row.querySelector('.end-time-input')?.value;

        if (madetai && startTime && endTime) {
            data.push({ madetai, startTime, endTime, ngaySapLich, mathuky, tenbuoi, diadiem ,mb});
        }
    });

    console.log(data);

    // Gửi dữ liệu đến server
    fetch('./luusaplich.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(result => {
            if (result.success) {
                alert('Lưu lịch thành công');
            } else if (result.messages && Array.isArray(result.messages)) {
                alert('Lỗi: ' + result.messages.join(', '));
            } else {
                alert('Đã xảy ra lỗi không xác định.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi gửi dữ liệu.');
        });
}




function xuatExcel() {
    // Lấy dữ liệu từ các input đầu trang
    const tenBuoi = document.getElementById("tenbuoi-saplich").value || "Chưa nhập";
    const ngay = document.getElementById("ngay-saplich").value || "Chưa nhập";
    const diaDiem = document.getElementById("diadiem-saplich").value || "Chưa nhập";
    const thuKySelect = document.getElementById("thuky-saplich");
    const thuKy = thuKySelect.options[thuKySelect.selectedIndex].text || "Chưa chọn";
    


    // Lấy bảng và dữ liệu
    const table = document.querySelector(".modal-saplich-table");
    const rows = Array.from(table.rows);

    // Tạo dữ liệu Excel
    const data = [
        ["Tên buổi:", tenBuoi],
        ["Ngày:", ngay],
        ["Địa điểm:", diaDiem],
        ["Thư ký:", thuKy],
        [], // Dòng trống để phân cách
    ];

    // Xử lý dữ liệu bảng
    rows.forEach((row, rowIndex) => {
        if (rowIndex === 0) {
            // Lấy tiêu đề bảng
            const headers = Array.from(row.cells).slice(0, -1).map(cell => cell.innerText);
            data.push(headers);
        } else {
            // Lấy dữ liệu từng dòng, giữ cột thời gian trong cùng một ô
            const cells = Array.from(row.cells).slice(0, -1).map((cell, cellIndex) => {
                if (cellIndex === 7) {
                    // Xử lý cột thời gian
                    const startTime = cell.querySelector(".start-time-input").value || "Chưa nhập";
                    const endTime = cell.querySelector(".end-time-input").value || "Chưa nhập";
                    return `${startTime} - ${endTime}`; // Ghép hai giá trị thời gian
                } else {
                    return cell.innerText;
                }
            });
            data.push(cells);
        }
    });

    // Tạo WorkBook
    const worksheet = XLSX.utils.aoa_to_sheet(data);

    // Thêm định dạng cho tiêu đề
    const range = XLSX.utils.decode_range(worksheet['!ref']);
    for (let C = range.s.c; C <= range.e.c; C++) {
        const cellAddress = XLSX.utils.encode_cell({ r: 0, c: C }); // Dòng tiêu đề
        if (!worksheet[cellAddress]) continue;
        worksheet[cellAddress].s = {
            font: { bold: true, color: { rgb: "FFFFFF" } },
            fill: { fgColor: { rgb: "4F81BD" } }, // Màu nền xanh lam
            alignment: { horizontal: "center", vertical: "center" }
        };
    }

    // Tạo Workbook và xuất file
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "LichBaoVe");

    // Định dạng tên file
    const fileName = `LichBaoVe_${new Date().toISOString().split("T")[0]}.xlsx`;
    XLSX.writeFile(workbook, fileName);
}




// function suaBuoi(mabuoi, tenbuoi, diadiem, thuky, ngay) {
//     document.getElementById('modalSapLich-sua').style.display = "flex";
//     document.getElementById("tenbuoi-saplich-sua").value = tenbuoi; // Gán tên buổi vào input
//     document.getElementById("diadiem-saplich-sua").value = diadiem; // Địa điểm
//     document.getElementById("thuky-saplich-sua").value = thuky; // Thư ký
//     document.getElementById("ngay-saplich-sua").value = ngay; // Ngày tổ chức

//     // Gửi yêu cầu lấy dữ liệu từ PHP
//     fetch(`./loadlichsusaplich.php?mabuoi=${mabuoi}`)
//         .then(response => response.json())
//         .then(data => {
//             if (data.status === "success") {
//                 const tableBody = document.querySelector(".modal-saplich-table-sua tbody");
//                 tableBody.innerHTML = ""; // Xóa nội dung cũ của bảng
                
//                 data.data.forEach((row, index) => {
//                     const tableRow = document.createElement("tr");

//                     // Cột STT
//                     const sttCell = document.createElement("td");
//                     sttCell.textContent = index + 1;
//                     tableRow.appendChild(sttCell);

//                     // Cột MSSV
//                     const mssvCell = document.createElement("td");
//                     mssvCell.textContent = row.masv;
//                     tableRow.appendChild(mssvCell);

//                     // Cột Họ và tên SV
//                     const nameCell = document.createElement("td");
//                     nameCell.textContent = row.tensinhvien;
//                     tableRow.appendChild(nameCell);

//                     // Cột Mã lớp
//                     const classCell = document.createElement("td");
//                     classCell.textContent = row.lop;
//                     tableRow.appendChild(classCell);

//                     // Cột Tên đề tài
//                     const topicCell = document.createElement("td");
//                     topicCell.textContent = row.tendetai;
//                     tableRow.appendChild(topicCell);

//                     // Cột Giảng viên hướng dẫn
//                     const supervisorCell = document.createElement("td");
//                     supervisorCell.textContent = row.gvthuky; // Sử dụng `gvthuky` như là giảng viên hướng dẫn
//                     tableRow.appendChild(supervisorCell);

//                     // Cột Giảng viên chấm hội đồng
//                     const councilCell = document.createElement("td");
//                     councilCell.innerHTML = `Chủ tịch: ${row.chutich || "N/A"}<br>Phản biện: ${row.gvphanbien || "N/A"}<br>Thư ký: ${row.gvthuky || "N/A"}`;
//                     tableRow.appendChild(councilCell);

//                     // Cột Thời gian (Bắt đầu - Kết thúc trong hai ô input riêng biệt)
//                     const timeCell = document.createElement("td");

//                     // Tạo input cho thời gian bắt đầu
//                     const startTimeInput = document.createElement("input");
//                     startTimeInput.type = "time";
//                     startTimeInput.className = "start-time-input"; // Thêm lớp CSS nếu cần
//                     startTimeInput.value = row.giobd || "00:00"; // Gán giá trị thời gian bắt đầu
//                     startTimeInput.placeholder = "Bắt đầu"; // Placeholder nếu cần

//                     // Tạo input cho thời gian kết thúc
//                     const endTimeInput = document.createElement("input");
//                     endTimeInput.type = "time";
//                     endTimeInput.className = "end-time-input"; // Thêm lớp CSS nếu cần
//                     endTimeInput.value = row.giokt || "00:00"; // Gán giá trị thời gian kết thúc
//                     endTimeInput.placeholder = "Kết thúc"; // Placeholder nếu cần

//                     // Thêm hai input vào ô với dấu gạch ngang giữa chúng
//                     timeCell.appendChild(startTimeInput);
//                     timeCell.appendChild(document.createTextNode(" - ")); // Thêm dấu gạch ngang
//                     timeCell.appendChild(endTimeInput);
//                     tableRow.appendChild(timeCell);

//                     // Cột Hành động
//                     const actionCell = document.createElement("td");
//                     const actionButton = document.createElement("button");
//                     actionButton.textContent = "Lưu";
//                     actionButton.className = "btn-save-time"; // Thêm lớp CSS nếu cần
//                     actionButton.addEventListener("click", () => {
//                         console.log(`Lưu thời gian: ${startTimeInput.value} - ${endTimeInput.value} cho SV: ${row.masv}`);
//                         // Thực hiện hành động lưu vào cơ sở dữ liệu
//                     });
//                     actionCell.appendChild(actionButton);
//                     tableRow.appendChild(actionCell);

//                     // Thêm dòng vào bảng
//                     tableBody.appendChild(tableRow);
//                 });
//             } else {
//                 console.error("Lỗi:", data.message);
//             }
//         })
//         .catch(error => console.error("Lỗi kết nối:", error));
// }






function hoantatsaplich() {
    // Kiểm tra đầu vào
    if (!mb) {
        console.error("ID buổi bảo vệ không hợp lệ.");
        return;
    }

    // Gửi yêu cầu AJAX bằng Fetch API
    fetch("./hoantatsaplich.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ id: mb }), // Gửi ID buổi bảo vệ
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Hoàn tất sắp lịch thành công!");
            localStorage.setItem("currentSection", "envent");

            // Reload lại trang
            location.reload();
        } else {
            alert("Lỗi: " + data.message);
        }
    })
    .catch(error => {
        console.error("Lỗi kết nối:", error);
    });
}


function huyBuoi(mb) {
    // Kiểm tra đầu vào
    if (!mb) {
        console.error("ID buổi bảo vệ không hợp lệ.");
        return;
    }

    // Gửi yêu cầu AJAX bằng Fetch API
    fetch("./huysaplich.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ id: mb }), // Gửi ID buổi bảo vệ
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Hoàn tất sắp lịch thành công!");
            localStorage.setItem("currentSection", "envent");

            // Reload lại trang
            location.reload();
        } else {
            alert("Lỗi: " + data.message);
        }
    })
    .catch(error => {
        console.error("Lỗi kết nối:", error);
    });
}









/// Hàm hiển thị thông báo
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

// Đóng tất cả các dialog (nếu cần)
function dongDialog() {
    document.getElementById("dialog-thongbao").classList.remove("show");
    document.getElementById("dialog-thanhcong").classList.remove("show");
    document.getElementById("dialog-thatbai").classList.remove("show");
}

// Gán sự kiện đóng dialog cho nút Đóng
document.getElementById("dong-thongbao")?.addEventListener("click", dongDialog);
document.getElementById("dong-thanhcong")?.addEventListener("click", dongDialog);
document.getElementById("dong-thatbai")?.addEventListener("click", dongDialog);

// Ví dụ hiển thị thông báo thất bại khi upload file thất bại
function uploadFile() {
    let fileInput = document.getElementById('uploadfile');
    if (!fileInput.files[0]) {
        hienThiThongBao('thatbai', 'Đã có lỗi xảy ra khi upload file!');
    } else {
        hienThiThongBao('thanhcong', 'Upload file thành công!');
    }
}


// Phần tìm kiếm lịch hội đồng

// goi ý tìm kiếm đề tài
function searchSuggestion3() {
    const query = document.getElementById('malop3').value.trim();
    const branch = ""; // Lấy giá trị học kỳ (nếu cần)
    const loaidetai = document.getElementById('bra-loaidetai-hoidong').value; // Lấy giá trị loại đề tài

    if (query.length > 1 || loaidetai) { // Kiểm tra nếu có từ khóa hoặc loại đề tài
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById('suggestions3').innerHTML = xhr.responseText;
            }
        };
        // Gửi cả từ khóa tìm kiếm, học kỳ và loại đề tài
        xhr.open(
            'GET',
            'goiy3.php?query=' + encodeURIComponent(query) +
            '&branch=' + encodeURIComponent(branch) +
            '&loaidetai=' + encodeURIComponent(loaidetai),
            true
        );
        xhr.send();
    } else {
        document.getElementById('suggestions3').innerHTML = '';
    }
}


function selectSuggestion3(value) {
    document.getElementById('malop3').value = value;
    document.getElementById('suggestions3').innerHTML = '';
   
   
}


document.getElementById('tracuu-env').addEventListener('click', function (event) {
    event.preventDefault(); // Ngăn chặn hành động mặc định của nút submit

    const query = document.getElementById('malop3').value.trim();
    const loaidetai = document.getElementById('bra-loaidetai-hoidong').value; // Lấy giá trị từ dropdown
    const xhr = new XMLHttpRequest();

    console.log(loaidetai);
    console.log(query);
    console.log(ma);

    xhr.open('POST', './xulytimlichbaove.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            try {
                // Phân tích JSON từ phản hồi
                const results = JSON.parse(xhr.responseText);
                if (results.error) {
                    console.error('Lỗi từ server: ' + results.error);
                    displayError_hoidong(results.error); // Hiển thị lỗi nếu có
                } else if (results.length === 0) {
                    console.log('Không có dữ liệu phù hợp');
                    displayResultsPhancong_hoidong(results); // Hiển thị thông báo không tìm thấy
                } else {
                    console.log('Dữ liệu nhận được:', results);
                    displayResultsPhancong_hoidong(results); // Hiển thị kết quả
                }
            } catch (e) {   
                console.error('Không thể phân tích JSON: ', e, xhr.responseText);
                displayError_hoidong('Phản hồi không hợp lệ từ server.');
            }
        } else {
            console.error('Lỗi khi lấy dữ liệu tìm kiếm');
            displayError_hoidong('Không thể kết nối tới server.');
        }
    };

    // Gửi dữ liệu tới server
    xhr.send(`madetai=${encodeURIComponent(query)}&loaidetai=${encodeURIComponent(loaidetai)}&masv=${encodeURIComponent(ma)}`);
});

// Hàm hiển thị thông báo lỗi
function displayError_hoidong(message) {
    const container = document.getElementById('search-results-hoidong');
    container.innerHTML = `<p class="error">Đề tài chưa được phân công.</p>`;
}

// Hàm hiển thị thông báo không có kết quả
function displayNoResults() {
    const container = document.getElementById('search-results-hoidong');
    container.innerHTML = '<p>Đề tài chưa được phân công.</p>';
}

function displayResultsPhancong_hoidong(results) {
   
    const resultsContainer = document.getElementById('search-results-hoidong');
    resultsContainer.innerHTML = ''; // Xóa kết quả cũ

    if (results.length === 0) {
        resultsContainer.innerHTML = '<div>Không tìm thấy lịch hay kết quả cho đề tài</div>';
        return;
    }

    results.forEach(result => {
        const { table, data: item, kt_sv, ketqua } = result; // Lấy thông tin bảng và dữ liệu
        console.log(kt_sv);    // Truy xuất 'kt_sv'
        console.log(ketqua?.diemgvhd);   // Truy xuất 'ketqua'
    
        const div = document.createElement('div');
        div.className = 'item-info';
        const ma = localStorage.getItem("ma");
    
        let btnXemDiem = ""; // Biến chứa nút xem điểm, nếu đủ điều kiện
    
        // Kiểm tra điều kiện hiển thị nút xem điểm
        if (kt_sv === true && ketqua !== null) {
            if (table === 'phancongdoan') {
                btnXemDiem = `
                    <div class="btn-action">
                        <a class="btn xemdiem-doan" data-madt="" onclick="xemKQDoAn(${ketqua.diemgvhd}, ${ketqua.diemgvpb})">Xem kết quả</a>
                    </div>
                `;
            } else if (table === 'phancongkhoaluan') {
                btnXemDiem = `
                    <div class="btn-action">
                        <a class="btn xemdiem-doan" data-madt="" onclick="xemKQKL(${ketqua.diemgvhd}, ${ketqua.diemgvpb}, ${ketqua.diemchutich})">Xem kết quả</a>
                    </div>
                `;
            }
        }
    
        if (table === 'phancongdoan') {
            // Hiển thị dữ liệu từ bảng phancongdoan
            div.innerHTML = `
                <div><span>Mã đề tài: </span><span class="rs-madetai">${item.madetai}</span></div>
                <div><span>Tên đề tài: </span><span class="rs-tendetai">${item.tendetai}</span></div>
                <div><span>Giáo viên hướng dẫn: </span><span class="rs-tendetai">${item.gvthuky_ten}</span></div>
                ${btnXemDiem} <!-- Nút xem điểm chỉ xuất hiện nếu đủ điều kiện -->
            `;
        }
    
        if (table === 'phancongkhoaluan') {
            if (item.ngaybaove && item.ngaybaove !== 'N/A') {
                // Kiểm tra và chuyển đổi ngày bảo vệ
                const ngaybaoveFormatted = formatDateDung(item.ngaybaove);
            
                if (ngaybaoveFormatted) {
                    // Nếu chuyển đổi thành công, hiển thị ngày theo định dạng dd-mm-yyyy
                    div.innerHTML = `
                        <div><span>Mã đề tài: </span><span class="rs-madetai">${item.madetai}</span></div>
                        <div><span>Tên đề tài: </span><span class="rs-tendetai">${item.tendetai}</span></div>
                        <div><span>Hội đồng: </span><span class="rs-thuky">${item.tenbuoi || 'N/A'}</span></div>
                        <div><span>Địa điểm: </span><span class="rs-gvpb">${item.diadiem || 'N/A'}</span></div>
                        <div><span>Ngày: </span><span class="rs-chutich">${ngaybaoveFormatted}</span></div>
                        <div><span>Thời gian: </span><span class="rs-tt">${item.giobd} - ${item.giokt}</span></div>
                        ${btnXemDiem}
                    `;
                } else {
                    // Nếu ngày không hợp lệ, thông báo lỗi
                    div.innerHTML = `
                        <div><span>Mã đề tài: </span><span class="rs-madetai">${item.madetai}</span></div>
                        <div><span>Tên đề tài: </span><span class="rs-tendetai">${item.tendetai}</span></div>
                        <div><span>Thông báo: </span><span class="rs-thongbao">Ngày bảo vệ không hợp lệ</span></div>
                    `;
                }
            } else {
                // Nếu không có ngày bảo vệ, hiển thị thông báo
                div.innerHTML = `
                    <div><span>Mã đề tài: </span><span class="rs-madetai">${item.madetai}</span></div>
                    <div><span>Tên đề tài: </span><span class="rs-tendetai">${item.tendetai}</span></div>
                    <div><span>Thông báo: </span><span class="rs-thongbao">Chưa có lịch bảo vệ cho đề tài</span></div>
                    ${btnXemDiem}
                `;
            }
        }
    
        resultsContainer.appendChild(div);
    });
    
}

// Hàm chuyển đổi ngày sang định dạng dd-mm-yyyy
function formatDateDung(dateString) {
    const date = new Date(dateString);
    
    if (isNaN(date)) {
        return '';  // Trả về chuỗi rỗng nếu không phải ngày hợp lệ
    }

    const day = String(date.getDate()).padStart(2, '0'); // Đảm bảo ngày có 2 chữ số
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Tháng bắt đầu từ 0, nên thêm 1
    const year = date.getFullYear();

    return `${day}-${month}-${year}`;
}


function xemKQDoAn(diemGV1, diemGV2) {
    // Tính điểm trung bình
    const trungBinh = ((diemGV1 + diemGV2) / 2).toFixed(2);

    // Tạo nội dung cho modal
    const modalBody = document.getElementById("doAnBody");
    modalBody.innerHTML = `
        <p><strong>Điểm Giáo Viên 1:</strong> <span>${diemGV1}</span></p>
        <p><strong>Điểm Giáo Viên 2:</strong> <span>${diemGV2}</span></p>
        <p><strong>Điểm Trung Bình:</strong> <span>${trungBinh}</span></p>
    `;

    // Hiển thị modal Đồ Án
    document.getElementById("doAnModal").style.display = "flex";

    // Gọi hiệu ứng dựa vào điểm trung bình
    playEffect(trungBinh);
}

function closeDoAnModal() {
    document.getElementById("doAnModal").style.display = "none";
}


function xemKQKL(diemGV1, diemGV2, diemGV3) {
    // Tính điểm trung bình
    const trungBinh = ((diemGV1 + diemGV2 + diemGV3) / 3).toFixed(2);

    // Tạo nội dung cho modal
    const modalBody = document.getElementById("khoaLuanBody");
    modalBody.innerHTML = `
        <p><strong>Điểm Giáo Viên 1:</strong> <span> ${diemGV1} </span></p>
        <p><strong>Điểm Giáo Viên 2:</strong> <span>${diemGV2}</span></p>
        <p><strong>Điểm Giáo Viên 3:</strong><span> ${diemGV3}</span></p>
        <p><strong>Điểm Trung Bình:</strong> <span>${trungBinh}</span></p>
    `;

    // Hiển thị modal Khóa Luận
    document.getElementById("khoaLuanModal").style.display = "flex";

    // Gọi hiệu ứng dựa vào điểm trung bình
    playEffect(trungBinh);
}

function closeKhoaLuanModal() {
    document.getElementById("khoaLuanModal").style.display = "none";
}

function playEffect(trungBinh) {
    const comfortEffect = document.getElementById("comfortEffect");
    const fireworks = document.querySelectorAll(".pyro");

    // Ẩn tất cả hiệu ứng trước đó
    comfortEffect.style.display = "none";
    fireworks.forEach(fw => fw.style.display = "none");

    if (trungBinh >= 5) {
        // Hiển thị pháo hoa khi điểm >= 5
        fireworks.forEach(fw => fw.style.display = "block");
    } else {
        // Hiển thị hiệu ứng mặt buồn khi điểm < 5
        comfortEffect.style.display = "block";

        // Tự động ẩn sau 2.5 giây (thời gian animation)
        setTimeout(() => {
            comfortEffect.style.display = "none";
        }, 2500);
    }
}






























// Hiển thị tên trong dailog them
localStorage.setItem('userRole', '$role');
var hoten = localStorage.getItem('hoten');
document.getElementById('tengv').value = hoten;




// hiển thị thông báo
// Các phần tử DOM
const notificationIcon = document.getElementById('notificationIcon');
const notificationMenu = document.getElementById('notificationMenu');
const notificationList = document.getElementById('notificationList');
const notificationCount = document.getElementById('notificationCount');

// Hiển thị hoặc ẩn menu thông báo khi nhấp vào icon
notificationIcon.addEventListener('click', (e) => {
    e.stopPropagation();
    toggleNotificationMenu();
});

// Đóng menu khi nhấp ra ngoài
window.addEventListener('click', () => {
    notificationMenu.style.display = 'none';
});

// Ngăn chặn sự kiện đóng menu khi nhấp vào chính menu
notificationMenu.addEventListener('click', (e) => {
    e.stopPropagation();
});

function toggleNotificationMenu() {
    const isVisible = notificationMenu.style.display === 'block';
    notificationMenu.style.display = isVisible ? 'none' : 'block';
}

// Load thông báo từ API
function loadNotifications() {
    fetch('loadthongbao.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderNotifications(data.notifications);
            } else {
                console.error('Không thể tải thông báo:', data.message);
            }
        })
        .catch(error => console.error('Lỗi:', error));
}

// Hiển thị thông báo
function renderNotifications(notifications) {
    notificationList.innerHTML = ''; // Xóa thông báo cũ

    if (notifications.length === 0) {
        notificationList.innerHTML = '<div class="notification-item-empty">Không có thông báo mới</div>';
    } else {
        notifications.forEach(notification => {
            const item = document.createElement('div');
            item.className = 'notification-item';

            const date = new Date(notification.ngay);
            const formattedDate = date.toLocaleString('vi-VN', {
                dateStyle: 'short',
                timeStyle: 'short'
            });

            item.innerHTML = `
                <div class="notification-header">
                    <span class="notification-title">${notification.noidung.substring(0, 20)}...</span>
                    <small>${formattedDate}</small>
                </div>
                <div class="notification-body">
                    <p>${notification.noidung}</p>
                </div>
            `;

            // Thêm sự kiện để mở rộng/thu gọn nội dung khi nhấn vào tiêu đề
            item.querySelector('.notification-header').addEventListener('click', () => {
                item.classList.toggle('expanded');
            });

            notificationList.appendChild(item);
        });
    }

    updateNotificationCount(notifications.length);
}

// Cập nhật số lượng thông báo
function updateNotificationCount(count) {
    const notificationCount = document.getElementById('notificationCount');
    
    if (!notificationCount) {
        console.error('Element with ID "notificationCount" not found.');
        return;
    }
    
    if (count > 0) {
        notificationCount.textContent = count;
        notificationCount.style.display = 'inline-block'; // Hiển thị thông báo
        notificationCount.classList.add('show');
        notificationCount.classList.remove('empty');
    } else {
        notificationCount.textContent = '0'; // Hoặc để trống nếu không cần hiển thị số 0
        notificationCount.style.display = 'none'; // Ẩn thông báo
        notificationCount.classList.remove('show');
        notificationCount.classList.add('empty');
    }
}

// Tải thông báo khi trang được mở
window.onload = loadNotifications;



async function taiTinTuc() {
    try {
        const response = await fetch("./laytintuc.php");
        const data = await response.json();

        const container = document.querySelector(".featured .list");
        container.innerHTML = ""; // Xóa nội dung cũ nếu có
        const quyen = localStorage.getItem("quyen");

        data.forEach(item => {
            // Chuyển đổi ngày sang định dạng dd-mm-yyyy
            const dateObj = new Date(item.date);
            const day = String(dateObj.getDate()).padStart(2, '0'); // Lấy ngày và đảm bảo là 2 chữ số
            const month = String(dateObj.getMonth() + 1).padStart(2, '0'); // Lấy tháng (tháng trong JavaScript bắt đầu từ 0)
            const year = dateObj.getFullYear(); // Lấy năm

            const formattedDate = `${day}-${month}-${year}`; // Định dạng ngày theo dd-mm-yyyy

            const actions = (quyen === 'quantri') ? ` 
                <div class="actions">
                    <button class="edit-btn" onclick="hienFormSuaTinTuc(${item.id})">Sửa</button>
                    <button class="delete-btn" onclick="xoaItem(${item.id})">Xóa</button>
                </div>
            ` : '';

            const html = `
                <div class="item2">
                    <a href="${item.duongdan}" target="_blank" rel="noopener noreferrer" class="link-wrapper">
                        <img src="${item.image_url}" alt="${item.title}" class="thumb">
                        <div class="body">
                            <h3 class="title">${item.title}</h3>
                            <p class="desc">${item.description}</p>
                            <div class="info">${formattedDate}</div> <!-- Hiển thị ngày đã định dạng -->
                        </div>
                    </a>
                    ${actions}
                </div>
            `;
            container.insertAdjacentHTML("beforeend", html); // Thêm vào cuối container
        });
    } catch (error) {
        console.error("Lỗi khi tải tin tức:", error);
    }
}









document.addEventListener("DOMContentLoaded", () => {
    const setupCarousel = (carouselSelector, itemsPerPage = 3) => {
        const carousel = document.querySelector(carouselSelector);
        if (!carousel) return;

        const list = carousel.querySelector(".list");
        const prevBtn = carousel.querySelector(".prev-btn");
        const nextBtn = carousel.querySelector(".next-btn");
        const items = list.children;

        let currentIndex = 0;
        let autoPlayInterval;

        // Cập nhật vị trí hiển thị
        const updateCarousel = () => {
            const translateX = -(currentIndex * (items[0].offsetWidth + 20)); // 20 là khoảng cách giữa các item
            list.style.transform = `translateX(${translateX}px)`;
        };

        // Tự động chạy carousel
        const autoPlay = () => {
            autoPlayInterval = setInterval(() => {
                if (currentIndex + itemsPerPage < items.length) {
                    currentIndex++;
                } else {
                    currentIndex = 0; // Quay lại từ đầu
                }
                updateCarousel();
            }, 1000); // 1 giây
        };

        // Xử lý nút "Next"
        nextBtn.addEventListener("click", () => {
            if (currentIndex + itemsPerPage < items.length) {
                currentIndex++;
                updateCarousel();
            }
        });

        // Xử lý nút "Prev"
        prevBtn.addEventListener("click", () => {
            if (currentIndex > 0) {
                currentIndex--;
                updateCarousel();
            }
        });

        // Dừng tự động chạy khi di chuột vào
        carousel.addEventListener("mouseenter", () => clearInterval(autoPlayInterval));

        // Tiếp tục tự động chạy khi rời chuột
        carousel.addEventListener("mouseleave", autoPlay);

        // Cập nhật carousel khi tải xong
        window.addEventListener("resize", updateCarousel);
        updateCarousel();

        // Bắt đầu tự động chạy khi tải trang
        autoPlay();
    };

    // Khởi tạo carousel cho phần Tin tức
    setupCarousel(".featured .carousel");
});



// Hiển thị form thêm tin tức
function hienFormThemTinTuc() {
    document.getElementById("tin-tuc-id").value = "";
    document.getElementById("form-tin-tuc-title").textContent = "Thêm Tin Tức";
    document.getElementById('overlay-tin-tuc').classList.add('active');
    document.getElementById("modal-tin-tuc").style.display="flex";
}

// Hiển thị form sửa tin tức
function hienFormSuaTinTuc(id) {
    fetch(`./laytintucsua.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById("tin-tuc-id").value = data.id;
            document.getElementById("tin-tuc-title-input").value = data.title;
            document.getElementById("tin-tuc-desc-input").value = data.description;
            document.getElementById("tin-tuc-img-input").value = data.image_url;
            document.getElementById("tin-tuc-date-input").value = data.date;
            document.getElementById("tin-tuc-url-input").value = data.duongdan;
            hienFormThemTinTuc();
            document.getElementById("form-tin-tuc-title").textContent = "Sửa Tin Tức";
        });
}

document.getElementById("overlay-tin-tuc").addEventListener("click", (e) => {
    if (e.target.id === "overlay-tin-tuc") {
        dongFormTinTuc();
    }
});

// Đóng form
function dongFormTinTuc() {
    document.getElementById("modal-tin-tuc").style.display="none";
    document.getElementById('overlay-tin-tuc').classList.remove('active');
}

// Xử lý thêm/sửa tin tức
document.getElementById("form-tin-tuc").addEventListener("submit", async function (e) {
    e.preventDefault();
    const id = document.getElementById("tin-tuc-id").value;
    const title = document.getElementById("tin-tuc-title-input").value;
    const description = document.getElementById("tin-tuc-desc-input").value;
    const image_url = document.getElementById("tin-tuc-img-input").value;
    const date = document.getElementById("tin-tuc-date-input").value;
    const dd = document.getElementById("tin-tuc-url-input").value;

    const apiURL = id ? "./suatin.php" : "./themtin.php";

    const response = await fetch(apiURL, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id, title, description, image_url, date, dd }),
    });

    const result = await response.json();
    if (result.success) {
        dongFormTinTuc();
        taiTinTuc();
    } else {
        alert("Có lỗi xảy ra!");
    }
});


async function xoaItem(id, loai) {
    if (confirm("Bạn có chắc muốn xóa?")) {
        const response = await fetch("./xoatin.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id }),
        });

        const result = await response.json();
        if (result.success) {
            taiTinTuc();
        } else {
            alert("Có lỗi xảy ra!");
        }
    }
}


// Hiển thị loading khi trang bắt đầu tải
window.addEventListener('load', () => {
    showLoading();
    taiTinTuc();
});




