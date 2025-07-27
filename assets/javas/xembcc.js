const  mabcc = getQueryParam('mabcc');

document.addEventListener("DOMContentLoaded", function () {

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'loadxembcc.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Thiết lập hàm xử lý sự kiện khi yêu cầu được gửi đi
    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            try {
                var data = JSON.parse(xhr.responseText);
                console.log('Dữ liệu trả về từ server:', data); // Log dữ liệu trả về từ server
                document.getElementById('mal').innerHTML=data[0].mabcc;
                document.getElementById('tenmon').innerHTML=data[0].tenbcc;
                var gio = getCurrentTime();
                var ngay = getCurrentDate();
    
                var table = document.getElementById("attendanceTable").getElementsByTagName('tbody')[0];
                for (var i = 0; i < data.length; i++) {
                    var rowData = [
                        i + 1,
                        data[i].manv,
                        data[i].ten_sv,
                        data[i].ngaycc,
                        data[i].ttchamconng,
                        // '<span data-span="'+data[i].manv+'"></span>',
                        // '<input type="checkbox" name="attendanceCheckbox[]" class="inp" value="' + data[i].manv + '" />'
                    ];
                    addRow(table, rowData);
                }
    
                // Thêm đường viền cho bảng
                table.style.width = "80%";
                table.style.margin = "0 auto";
                table.style.borderCollapse = "collapse";
                var rows = table.getElementsByTagName("tr");
                for (var i = 0; i < rows.length; i++) {
                    rows[i].style.border = "1px solid #dddddd";
                }
            } catch (error) {
                console.error('Lỗi khi xử lý dữ liệu JSON:', error);
            }
        } else {
            console.error('Lỗi:', xhr.status, xhr.statusText);
        }
    };
    

    // Thiết lập hàm xử lý sự kiện khi có lỗi
    xhr.onerror = function () {
        console.error('Có lỗi khi gửi yêu cầu.');
    };

    // Chuẩn bị dữ liệu để gửi đi
    var data = 'mabcc=' + encodeURIComponent(mabcc);

    // Gửi yêu cầu
    xhr.send(data);
});

function addRow(table, rowData) {
    var row = table.insertRow();
    for (var i = 0; i < rowData.length; i++) {
        var cell = row.insertCell(i);
        cell.innerHTML = rowData[i];
    }
}
// Lấy giờ theo định dạng "giờ:phút:giây"
function getCurrentTime() {
    var currentDate = new Date();
    var hours = addLeadingZero(currentDate.getHours());
    var minutes = addLeadingZero(currentDate.getMinutes());
    var seconds = addLeadingZero(currentDate.getSeconds());
    return hours + ':' + minutes + ':' + seconds;
}

// Lấy ngày theo định dạng "dd/mm/yyyy"
function getCurrentDate() {
    var currentDate = new Date();
    var day = addLeadingZero(currentDate.getDate());
    var month = addLeadingZero(currentDate.getMonth() + 1); // Tháng bắt đầu từ 0
    var year = currentDate.getFullYear();
    return day + '/' + month + '/' + year;
}

// Hàm để thêm số 0 đằng trước nếu giá trị nhỏ hơn 10
function addLeadingZero(value) {
    return value < 10 ? '0' + value : value;
}

// Hàm để lấy giá trị mã bảng chấm công của tham số từ URL
function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}

