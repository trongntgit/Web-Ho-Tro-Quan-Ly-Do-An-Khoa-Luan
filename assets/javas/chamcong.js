






var giocc2 =0;

const  mabcc = getQueryParam('mabcc');

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('modal-nhanvien').style.display = 'none';
    console.log(mabcc);


    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'loadchamcong.php', true);
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
                giocc2 = data[0].tg_chamcong;
                console.log(giocc2);
                var table = document.getElementById("attendanceTable").getElementsByTagName('tbody')[0];
                for (var i = 0; i < data.length; i++) {
                    var rowData = [
                        i + 1,
                        data[i].manv,
                        data[i].ten_sv,
                        ngay,
                        '<span data-span="'+data[i].manv+'"></span>',
                        '<input type="checkbox" name="attendanceCheckbox[]" class="inp" value="' + data[i].manv + '" />'
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

/// Check tất cả
document.addEventListener("DOMContentLoaded",function(){
    var checkAllCheckbox = document.getElementById('check-all');

// Lấy tất cả các checkbox cần được kiểm tra
var checkboxes = document.getElementsByClassName('inp');

// Gắn sự kiện "change" cho checkbox "check-all"
checkAllCheckbox.addEventListener('change', function () {
    // Lặp qua tất cả các checkbox và thiết lập giá trị checked của chúng bằng giá trị của checkbox "check-all"
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = checkAllCheckbox.checked;
    }
});

// Gắn sự kiện "change" cho tất cả các checkbox cần được kiểm tra
for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].addEventListener('change', function () {
        // Nếu có bất kỳ checkbox nào không được chọn, hủy chọn checkbox "check-all"
        checkAllCheckbox.checked = Array.from(checkboxes).every(function (checkbox) {
            return checkbox.checked;
        });
    });
}
})


document.getElementById('themnv').addEventListener('click', function() {
   
    document.getElementById('modal-nhanvien').style.display = 'flex';
    document.querySelector('#tab-select').classList.add('active'); // Mặc định mở tab chọn nhân viên
});


document.getElementById('add-nv').addEventListener('click', function() {
  // Lấy phần tử <select>
  const elm = document.getElementById('op-nv');
    
  // Lấy phần tử <option> được chọn
  const selectedOption = elm.options[elm.selectedIndex];
  
  // Lấy giá trị và thuộc tính data-hoten của <option> được chọn
  const selectedMsnv = selectedOption.value;
 
  const hoten = selectedOption.getAttribute('data-hoten');
    
    fetch('./themnvbcc.php', { // Endpoint thêm nhân viên vào bảng chấm công
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            manv: selectedMsnv,
            hoten: hoten,
            mabcc: mabcc, // Thay bằng mã bảng chấm công thực tế
        }),
    })
    .then(response => {
        if (!response.ok) {
            // Kiểm tra mã trạng thái HTTP
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(result => {
        if (result.success) {
            alert('Thêm nhân viên thành công!');
           // Tải lại trang web
            window.location.reload();

        } else {
            alert(result.message || 'Có lỗi xảy ra!');
        }
    })
    .catch(error => {
        console.error('Có lỗi xảy ra:', error);
        alert('Có lỗi xảy ra, vui lòng thử lại.');
    });
});

document.getElementById('upload-file').addEventListener('click', function() {
    const fileInput = document.getElementById('file-upload');
    const file = fileInput.files[0];

    if (!file) {
        alert('Vui lòng chọn một file!');
        return;
    }

    const formData = new FormData();
    formData.append('file', file);

    fetch('upload-excel.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(result => {
        const dialog = document.getElementById('dialog');
        const title = document.getElementById('dialog-title');
        const content = document.getElementById('dialog-content');

        if (result.success) {
            title.textContent = 'Kết quả';
            content.innerHTML = `<p>${result.message}</p>`;
            if (result.failedRecords.length > 0) {
                const list = document.createElement('ul');
                result.failedRecords.forEach(record => {
                    const item = document.createElement('li');
                    if (record.error) {
                        item.textContent = `Mã NV: ${record.manv || 'N/A'}, Tên: ${record.hoten || 'N/A'}, Mã BCC: ${record.mabcc || 'N/A'}, Lỗi: ${record.error}`;
                    } else {
                        item.textContent = `Lỗi: ${record.error}`;
                    }
                    list.appendChild(item);
                });
                content.appendChild(list);
            }
        } else {
            title.textContent = 'Có lỗi';
            content.textContent = result.message;
        }

        dialog.style.display = 'block';
    })
    .catch(error => {
        alert('Có lỗi xảy ra: ' + error);
        console.error('Có lỗi xảy ra:', error);
    });
});

document.getElementById('dialog-close').addEventListener('click', function() {
    document.getElementById('dialog').style.display = 'none';
});






document.querySelectorAll('.tab-button').forEach(button => {
    button.addEventListener('click', function() {
        const tab = this.dataset.tab;
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.toggle('active', content.id === `tab-${tab}`);
        });
    });
});

document.getElementById('close-modal').addEventListener('click', function() {
    document.getElementById('modal-nhanvien').style.display = 'none';
});




document.getElementById('hoantat').addEventListener('click', function () {
  var rows = document.getElementById('attendanceTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');

  // Duyệt qua tất cả các dòng trong bảng
  for (var i = 0; i < rows.length; i++) {
      var cells = rows[i].getElementsByTagName('td');
      var manv = cells[1].innerText;
      var hoten = cells[2].innerText;
      var ngaydd = cells[3].innerText;
      var giodd = cells[4].innerText;

      // Chuyển đổi ngày sang định dạng chuẩn 'YYYY-MM-DD'
      var dateParts = ngaydd.split("/");
      ngaydd = dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0];

      // So sánh giodd với giocc2
      var trangthaidd;
      if (giodd > giocc2) {
          trangthaidd = 'Trễ'; // Giodd trễ hơn giocc2
      } else {
          trangthaidd = cells[5].getElementsByTagName('input')[0].checked ? 'Có' : 'Vắng';
      }

      // Gọi hàm để lưu vào CSDL (sử dụng Ajax hoặc fetch để gửi dữ liệu về phía server)
      saveToDatabase(manv, hoten, ngaydd, giodd, trangthaidd);
  }

  alert('Điểm danh đã được lưu vào CSDL.');
});


function saveToDatabase(manv, mabcc,hoten, ngaydd, giodd, trangthaidd) {
  // Gọi API hoặc sử dụng Ajax/fetch để gửi dữ liệu lên server
  // Đoạn mã này giả sử bạn có một trang PHP xử lý dữ liệu

  var xhr = new XMLHttpRequest();
  xhr.open('POST', './xulyhoantat.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  // Chuẩn bị dữ liệu để gửi đi
  var data = 'manv=' + encodeURIComponent(manv) +
             '&mabcc=' + encodeURIComponent(mabcc) +
             '&hoten=' + encodeURIComponent(hoten) +
             '&ngaydd=' + encodeURIComponent(ngaydd) +
             '&giodd=' + encodeURIComponent(giodd) +  
             '&trangthaidd=' + encodeURIComponent(trangthaidd);

  // Gửi yêu cầu
  console.log(data);
  xhr.send(data);
}





// Nhận diện khuông mặt
// scripts.js
const container = document.querySelector("#dia-camera");
const video = document.querySelector("#video");
const openCameraBtn = document.querySelector("#ddqr");
const closeBtn = document.querySelector("#close-btn");

let canvas;
let faceMatcher;

async function startVideo() {
  const stream = await navigator.mediaDevices.getUserMedia({ video: {} });
  video.srcObject = stream;

  return new Promise((resolve) => {
    video.onloadeddata = () => {
      resolve(video);
    };
  });
}

async function loadTrainingData() {
  const labels = [
    "vl-nv01\\Nguyen Tuan Trong",
    "Rina Ishihara",
    "Takizawa Laura",
    "Yua Mikami",
  ];

  const faceDescriptors = [];
  for (const label of labels) {
    const descriptors = [];
    for (let i = 1; i <= 4; i++) {
      let image;
      try {
        image = await faceapi.fetchImage(`./data/${label}/${i}.jpg`);
      } catch (e1) {
        try {
          image = await faceapi.fetchImage(`./data/${label}/${i}.jpeg`);
        } catch (e2) {
          console.error(`Không tìm thấy hình ảnh cho ${label} ở định dạng jpg hoặc jpeg.`);
          continue;
        }
      }

      const detection = await faceapi
        .detectSingleFace(image)
        .withFaceLandmarks()
        .withFaceDescriptor();
      if (detection) {
        descriptors.push(detection.descriptor);
      }
    }
    faceDescriptors.push(new faceapi.LabeledFaceDescriptors(label, descriptors));
    Toastify({
      text: `Training xong data của ${label}!`,
    }).showToast();
  }

  return faceDescriptors;
}

async function loadModelsAndTrain() {
  // Hiển thị thông báo đang tải model
  const loadingElement = document.createElement("p");
  loadingElement.id = "loading";
  loadingElement.textContent = "Đang tải model và train...";
  container.appendChild(loadingElement);

  await Promise.all([
    faceapi.loadSsdMobilenetv1Model("./models"),
    faceapi.loadFaceRecognitionModel("./models"),
    faceapi.loadFaceLandmarkModel("./models"),
  ]);

  Toastify({
    text: "Tải xong model nhận diện!",
  }).showToast();

  const trainingData = await loadTrainingData();
  faceMatcher = new faceapi.FaceMatcher(trainingData, 0.6);

  console.log(faceMatcher);
  document.querySelector("#loading").remove();

  await startVideo();
  recognizeFaces(); // Start recognition after models and training data are loaded
}

async function recognizeFaces() {
  if (canvas) {
    container.removeChild(canvas);
    canvas = null;
  }

  canvas = document.createElement('canvas');
  canvas.width = video.width;
  canvas.height = video.height;
  canvas.style.position = 'absolute';
  canvas.style.top = video.offsetTop + 'px';
  canvas.style.left = video.offsetLeft + 'px';
  container.appendChild(canvas);

  const displaySize = { width: video.width, height: video.height };
  faceapi.matchDimensions(canvas, displaySize);

  const intervalId = setInterval(async () => {
    const detections = await faceapi
      .detectAllFaces(video)
      .withFaceLandmarks()
      .withFaceDescriptors();
  
    const resizedDetections = faceapi.resizeResults(detections, displaySize);
  
    canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);
  
    resizedDetections.forEach(detection => {
      const match = faceMatcher.findBestMatch(detection.descriptor);
  
      // Remove accuracy or numerical score from the label
      const labelWithoutScore = match.label.split('(')[0].trim(); // Extract name part without confidence score
  
      // Draw bounding box with modified label
      const drawBox = new faceapi.draw.DrawBox(detection.detection.box, {
        label: labelWithoutScore,
        boxColor: "blue",
        lineWidth: 2,
        fontSize: 20
      });
      drawBox.draw(canvas);
  
      const manv = labelWithoutScore.split("\\")[0]; // Get the part before the '\\'
  
      // Find the checkbox and span element
      const checkbox = document.querySelector(`input[type="checkbox"][value="${manv}"]`);
      const spanElement = document.querySelector(`span[data-span="${manv}"]`);
  
      // Only check and update if the checkbox is not already checked
      if (checkbox && !checkbox.checked) {
        checkbox.checked = true;
        console.log(`Checked: ${manv}`);
        
        // Update the span element with the current time
        if (spanElement) {
          const currentTime = getCurrentTime();
          spanElement.textContent = currentTime;
          console.log(`Updated span for ${manv} with time: ${currentTime}`);
          updateTable(manv);
        }
      } else {
        console.log(`Checkbox for ${manv} is already checked, skipping update.`);
      }
    });
  }, 100);
  
}


openCameraBtn.addEventListener("click", async () => {
  container.style.display = "block";
  await loadModelsAndTrain();
});

closeBtn.addEventListener("click", () => {
  const stream = video.srcObject;
  const tracks = stream.getTracks();

  tracks.forEach(track => track.stop());
  container.style.display = "none";
});

dragElement(document.getElementById("dia-camera"));

function dragElement(elmnt) {
  let pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
  if (document.getElementById(elmnt.id + "-header")) {
    document.getElementById(elmnt.id + "-header").onmousedown = dragMouseDown;
  } else {
    elmnt.onmousedown = dragMouseDown;
  }

  function dragMouseDown(e) {
    e = e || window.event;
    e.preventDefault();
    pos3 = e.clientX;
    pos4 = e.clientY;
    document.onmouseup = closeDragElement;
    document.onmousemove = elementDrag;
  }

  function elementDrag(e) {
    e = e || window.event;
    e.preventDefault();
    pos1 = pos3 - e.clientX;
    pos2 = pos4 - e.clientY;
    pos3 = e.clientX;
    pos4 = e.clientY;
    elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
    elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
  }

  function closeDragElement() {
    document.onmouseup = null;
    document.onmousemove = null;
  }
}

$(function() {
  $(".resizable").resizable();
});


// tỏ màu mơi được check
function unhighlightAllRows() {
  var allRows = document.querySelectorAll('tr');
  allRows.forEach(function(row) {
      row.style.backgroundColor = ''; // Bỏ tô vàng
  });
}

function highlightRow(element) {
  // Lấy dòng chứa ô input
  var tableRow = getParentRow(element);
  
  if (tableRow) {
      // Tô vàng dòng
      tableRow.style.backgroundColor = '#237bd3';
  }
}

function updateTable(manv) {
  var inputElement = document.querySelector('input[value="' + manv + '"]');
  if (inputElement) {

      unhighlightAllRows();

      // Tô vàng dòng chứa ô input và chuyển trạng thái checked
      inputElement.checked = true;
      highlightRow(inputElement);
  }
}

function getParentRow(element) {
  // Lặp qua các phần tử cha để tìm dòng (nếu có)
  while (element && element.tagName !== 'TR') {
      element = element.parentElement;
  }
  return element;
}

function handleError(error) {
  console.error(error);
}


// hoàn tất điểm danh
document.getElementById("thu").addEventListener('click',function(){
  console.log("con cattt");

});

