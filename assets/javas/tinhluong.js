

function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}

const mabcc = getQueryParam('mabcc');



document.addEventListener("DOMContentLoaded",function(){
    document.getElementById('mal').innerText= mabcc;
    const xhr = new XMLHttpRequest();
    
    xhr.open('POST', './loadtinhluong.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            const results = JSON.parse(xhr.responseText);
            displayResults2(results);
        } else {
            console.error('Lỗi khi lấy dữ liệu tìm kiếm');
        }
    };
    xhr.send(`mabcc=${encodeURIComponent(mabcc)}`);
});

function displayResults2(data) {
    const tableBody = document.querySelector('#attendanceTable tbody');
    tableBody.innerHTML = ''; // Xóa nội dung cũ
    

    let stt = 1;
    for (const manv in data) {
        
        const row = document.createElement('tr');
        
        const sttCell = document.createElement('td');
        sttCell.textContent = stt++;
        row.appendChild(sttCell);

        const manvCell = document.createElement('td');
        manvCell.textContent = manv;
        row.appendChild(manvCell);

        const hotenCell = document.createElement('td');
        hotenCell.textContent = data[manv]['hoten'];
        row.appendChild(hotenCell);

        const ngayddCell = document.createElement('td');
        ngayddCell.textContent = data[manv]['somaylam'];
        row.appendChild(ngayddCell);

        const ngaynghiCell = document.createElement('td');
        ngaynghiCell.textContent = data[manv]['somaynghi'];
        row.appendChild(ngaynghiCell);

        const ditreCell = document.createElement('td');
        ditreCell.textContent = data[manv]['somayditre'];
        row.appendChild(ditreCell);

        const tongluongCell = document.createElement('td');
        tongluongCell.textContent = ''; // Ô trống cho cột tổng lương
        row.appendChild(tongluongCell);

        tableBody.appendChild(row);
    }
}


function showSalaryDialog() {
    document.getElementById("salaryDialog").style.display = "block";
    document.querySelector('.overlay').style.display = 'block';

}

function closeDialog() {
    document.getElementById("salaryDialog").style.display = "none";
    document.querySelector('.overlay').style.display = 'none';

}

function calculateSalary() {
    let dailySalary = parseFloat(document.getElementById("dailySalary").value);
    let allowance = parseFloat(document.getElementById("allowance").value);
    let latePenalty = parseFloat(document.getElementById("latePenalty").value);
    let absencePenalty = parseFloat(document.getElementById("absencePenalty").value);

    const tableBody = document.querySelector('#attendanceTable tbody');

    // Iterate through each row in the table to calculate the salary
    for (const row of tableBody.rows) {
        let workDays = parseInt(row.cells[3].textContent);  // Số ngày đi làm
        let absenceDays = parseInt(row.cells[4].textContent);  // Số ngày nghỉ
        let lateDays = parseInt(row.cells[5].textContent);  // Số ngày đi trễ

        let totalSalary = (dailySalary * workDays) + allowance - (latePenalty * lateDays) - (absencePenalty * absenceDays);
        row.cells[6].textContent = totalSalary.toFixed(2);  // Display the calculated salary in the "Tổng lương" column
    }

    closeDialog();  // Close the dialog after calculation
}

document.getElementById("tinhluong").addEventListener("click", showSalaryDialog);



//luu bảng lương
document.getElementById('hoantat').addEventListener('click', function() {
    const tableBody = document.querySelector('#attendanceTable tbody');
    const data = [];

    for (const row of tableBody.rows) {
        const manv = row.cells[1].textContent;
        const hoten = row.cells[2].textContent;
        const songaylam = parseInt(row.cells[3].textContent);
        const songaynghi = parseInt(row.cells[4].textContent);
        const songayditre = parseInt(row.cells[5].textContent);
        const tongluong = parseFloat(row.cells[6].textContent);
        const mab = mabcc;

        data.push({ manv, hoten, songaylam, songaynghi, songayditre, tongluong,mab});
    }

    // Gửi dữ liệu đến PHP để lưu vào CSDL
    fetch('luu_bangluong.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.text())
    .then(data => {
        alert('Dữ liệu đã được lưu thành công!');
    })
    .catch(error => {
        console.error('Lỗi:', error);
    });
});

// xuất bảng tính lương
document.getElementById('xuatfile').addEventListener('click', function() {
    document.getElementById('exportModal').style.display = 'block';
});

document.getElementById('cancelBtn').addEventListener('click', function() {
    document.getElementById('exportModal').style.display = 'none';
})

document.getElementById('saveFileBtn').addEventListener('click', function() {
    const filename = document.getElementById('filename').value;
    if (filename) {
        window.location.href = `xuatbangluong.php?mabcc=${mabcc}&filename=${filename}`;
    } else {
        alert('Please enter a file name');
    }
});



// script.js

// Mở dialog thống kê
function openStatisticsDialog() {
    document.getElementById('statistics-dialog').style.display = 'block';
    fetchData();
}

// Đóng dialog thống kê
function closeDialog2() {
    document.getElementById('statistics-dialog').style.display = 'none';
}

// Hiển thị thống kê
function showStatistics() {
    fetchData(); // Gọi hàm lấy dữ liệu và vẽ biểu đồ
}

// Lấy dữ liệu từ server và vẽ biểu đồ
function fetchData() {
    fetch('get_statistics.php')
        .then(response => response.text()) // Lấy phản hồi dưới dạng văn bản thô
        .then(text => {
            console.log('Phản hồi nhận được:', text);
            try {
                const data = JSON.parse(text); // Chuyển đổi sang JSON
                console.log('JSON hợp lệ:', data);

                const labels = data.map(item => item.hoten);
                const daysWorked = data.map(item => parseInt(item.tong_ngay_lam, 10)); // Chuyển đổi giá trị thành số nguyên

                const ctx = document.getElementById('myChart').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'pie', // Loại biểu đồ tròn
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Tổng số ngày làm việc',
                            data: daysWorked,
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(255, 99, 132, 0.7)',
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 206, 86, 0.7)',
                                'rgba(153, 102, 255, 0.7)',
                                'rgba(255, 159, 64, 0.7)'
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right', // Hiển thị chú thích bên phải biểu đồ
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return `${tooltipItem.label}: ${tooltipItem.raw} ngày`;
                                    }
                                }
                            },
                            // Hiển thị số liệu trực tiếp trên các phần của biểu đồ
                            datalabels: {
                                color: '#fff',
                                font: {
                                    weight: 'bold',
                                    size: 14,
                                },
                                formatter: (value, ctx) => {
                                    let percentage = (value / daysWorked.reduce((a, b) => a + b, 0) * 100).toFixed(2) + '%';
                                    return ctx.chart.data.labels[ctx.dataIndex] + '\n' + value + ' ngày (' + percentage + ')';
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels] // Kích hoạt plugin để hiển thị số liệu
                });
            } catch (error) {
                console.error('Lỗi phân tích JSON:', error);
                console.error('Phản hồi không hợp lệ:', text);
            }
        })
        .catch(error => console.error('Lỗi:', error));
}

// Gọi hàm fetchData để vẽ biểu đồ ngay khi trang được tải
fetchData();




