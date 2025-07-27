let sections = JSON.parse(localStorage.getItem("sections")) || [];
document.getElementById('editAnnouncementModal').style.display = 'none';
const quyen = localStorage.getItem("quyen");
// Lấy mã đề tài từ localStorage
function getMadetai() {
    // Lấy URL hiện tại
    const url = window.location.href;

    // Tách URL theo dấu "/" và lấy phần cuối cùng
    const parts = url.split("/");
    const lastPart = parts[parts.length - 1];

    // Kiểm tra nếu phần cuối có ".php" thì loại bỏ phần mở rộng
    const madetai = lastPart.includes(".php") ? lastPart.replace(".php", "") : null;

    if (!madetai || madetai.trim() === "") {
        console.error("Mã đề tài không tồn tại hoặc rỗng");
        return null;
    }

    return madetai;
}

document.addEventListener("DOMContentLoaded", () => {
    // Gọi hàm loadMessages mỗi 2 giây
    setInterval(() => {
        loadMessages();
    }, 2000);

    
})

document.addEventListener("DOMContentLoaded", () => {
    const madetai = getMadetai();

    if (!madetai) {
        console.error("Không lấy được mã đề tài");
        return;
    }

    fetch(`http://localhost/Doan2/laytendetai.php`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ madetai: madetai }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.detai) {
                const titleElement = document.getElementById("title");
                titleElement.textContent = `${data.detai.tendetai} (${data.detai.madetai})`;
            } else {
                console.error("Không tìm thấy đề tài:", data.error || "Không rõ lỗi");
            }
        })
        .catch(error => console.error("Lỗi khi gửi yêu cầu:", error));
});

// Kiểm tra và ẩn tất cả các nút có class "button button-add" nếu quyền không phải 'giangvien'
if (quyen != 'giangvien') {
    // Lấy tất cả các phần tử có class "button button-add"
    const addButtons = document.querySelectorAll('.button.button-add');
    
    // Duyệt qua từng nút và ẩn nó
    addButtons.forEach(button => {
        button.style.display = 'none'; // Hoặc button.remove() nếu muốn xóa khỏi DOM
    });

     // Lấy tất cả các phần tử có class "button button-add"
     const editButtons = document.querySelectorAll('.button.button-edit');
    
     // Duyệt qua từng nút và ẩn nó
     editButtons.forEach(button => {
         button.style.display = 'none'; // Hoặc button.remove() nếu muốn xóa khỏi DOM
     });

      // Lấy tất cả các phần tử có class "button button-add"
      const deleteButtons = document.querySelectorAll('.button.button-delete');
    
      // Duyệt qua từng nút và ẩn nó
      deleteButtons.forEach(button => {
          button.style.display = 'none'; // Hoặc button.remove() nếu muốn xóa khỏi DOM
      });


    //   const evaButtons = document.querySelectorAll('.button.button-evaluate');
    //     // Duyệt qua từng nút và ẩn nó
    //     evaButtons.forEach(button => {
    //         button.style.display = 'none'; // Hoặc button.remove() nếu muốn xóa khỏi DOM
    //     });
    document.getElementById("save-evaluation").style.display= 'none';
    document.getElementById("progress-percentage").readOnly = true;
    document.getElementById("evaluation-content").readOnly = true;

  
}
else{
     // Lấy tất cả các phần tử có class "button button-add"
     const addButtons = document.querySelectorAll('.button.button-add');
    
     // Duyệt qua từng nút và ẩn nó
     addButtons.forEach(button => {
         button.style.display = 'inline-block'; // Hoặc button.remove() nếu muốn xóa khỏi DOM
     });
 
      // Lấy tất cả các phần tử có class "button button-add"
      const editButtons = document.querySelectorAll('.button.button-edit');
     
      // Duyệt qua từng nút và ẩn nó
      editButtons.forEach(button => {
          button.style.display = 'inline-block'; // Hoặc button.remove() nếu muốn xóa khỏi DOM
      });
 
       // Lấy tất cả các phần tử có class "button button-add"
       const deleteButtons = document.querySelectorAll('.button.button-delete');
     
       // Duyệt qua từng nút và ẩn nó
       deleteButtons.forEach(button => {
           button.style.display = 'inline-block'; // Hoặc button.remove() nếu muốn xóa khỏi DOM
       });

       const evaButtons = document.querySelectorAll('.button.button-evaluate');
       // Duyệt qua từng nút và ẩn nó
       evaButtons.forEach(button => {
           button.style.display = 'inline-block'; // Hoặc button.remove() nếu muốn xóa khỏi DOM
       });
       document.getElementById("save-evaluation").style.display= 'inline-block';
        document.getElementById("progress-percentage").readOnly = false;
         document.getElementById("evaluation-content").readOnly = false;

       

}


// Toggle submission options based on type selection
function toggleSubmissionOptions() {
    const selectedType = document.getElementById("subSectionType").value;
    const submissionOptions = document.getElementById("submissionOptions");
    submissionOptions.style.display = selectedType === "nopbai" ? "block" : "none";
}

// loadMessages();

document.getElementById("model-danhgia").style.display="none";
document.getElementById("subSectionModal").style.display="none";

    



// Hàm lưu dữ liệu vào CSDL
function saveToDatabase() {
    const madetai = getMadetai();
    let containerHTML = document.querySelector(".container").innerHTML;

    if (!madetai || madetai.trim() === "") { 
        console.error("Thiếu mã đề tài");
        return;
    }

    // Xóa các ký tự dòng mới và khoảng trắng không cần thiết
    containerHTML = containerHTML.replace(/(\r\n|\n|\r)/gm, "").trim();

    const data = new FormData();
    data.append('madetai', madetai);
    data.append('htmlContent', containerHTML);

    fetch('../luugiaodien.php', {
        method: 'POST',
        body: data
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            console.log("Dữ liệu HTML đã được lưu thành công");
        } else {
            console.error("Lỗi khi lưu dữ liệu HTML:", result.error);
        }
    })
    .catch(error => {
        console.error("Lỗi khi gửi dữ liệu:", error);
    });
}

// Hàm lưu vào localStorage và gửi vào cơ sở dữ liệu
function saveToLocalStorageAndDatabase() {
    localStorage.setItem("sections", JSON.stringify(sections));
    saveToDatabase(); // Lưu toàn bộ cấu trúc HTML vào CSDL
}

// Hàm thêm phần mới vào mảng sections và lưu vào DOM
function addSection() {
    const title = prompt("Nhập tiêu đề cho phần:");
    if (title) {
        const newSection = { title: title, subSections: [] };
        sections.push(newSection);
        addSectionToDOM(newSection);
        saveToLocalStorageAndDatabase(); // Save immediately after adding a new section
    }
}

// Hàm xóa phần
function deleteSection(button) {
    if (confirm("Bạn có chắc chắn muốn xóa phần này không?")) {
        const section = button.closest(".section");
        const sectionID = section.id;  // Lấy id của phần cần xóa
        const title = section.querySelector("h2").innerText;
        sections = sections.filter(s => s.title !== title);
        section.remove();
        console.log(sectionID);
        saveToLocalStorageAndDatabase(); // Save immediately after deleting a section
       
    }
}

// Hàm thêm nội dung con vào phần hiện tại
function addSubSection(button, type) {
    currentSection = button.closest(".section");
    openModal(type);
}

// Mở modal để thêm nội dung con
function openModal(type) {
    document.getElementById("subSectionModal").style.display = "flex";
    document.getElementById("subSectionType").value = type; // Set default type
}

// Đóng modal
function closeModal() {
    document.getElementById("subSectionModal").style.display = "none";
}


const madetai_kt = getMadetai();


function addSubSectionContent() {
    const selectedType = document.getElementById("subSectionType").value;
    let subContentHTML = "";
    let titleHTML = "";
    let positionID = `position-${Date.now()}`; // Tạo ID vị trí duy nhất dựa trên thời gian
    console.log("Creating sub-section with positionID:", positionID); // Kiểm tra ID được tạo

    switch (selectedType) {
        case "thongbao":
            subContentHTML = `<div id="${positionID}" class="sub-section-content">Nội dung thông báo</div>`;
            break;
        case "nopbai":
            const submissionType = document.getElementById("submissionType").value;
            const submissionDeadline = document.getElementById("submissionDeadline").value;

            if (!submissionDeadline) {
                alert("Vui lòng chọn thời hạn nộp.");
                return;
            }

            let loaiTienDo = submissionType === "progress" ? "progress" : (submissionType === "final" ? "final" : null);

            if (!loaiTienDo) {
                alert("Loại tiến độ không hợp lệ.");
                return;
            }

            titleHTML = `<div class="submission-title">${loaiTienDo === "progress" ? "Nộp tiến độ" : "Nộp sản phẩm cuối cùng"} - Hạn nộp: ${submissionDeadline}</div>`;
            subContentHTML = ` 
                <div id="${positionID}" class="sub-section-content">
                    ${titleHTML}
                    <input type="file" class="file-upload" onchange="previewFile(event, '${positionID}')"/>
                    <div class="file-preview" id="file-preview-${positionID}">Chưa có tệp nào được chọn</div>
                    <textarea placeholder="Đang tải ghi chú..." class="note-input" readonly></textarea>
                    ${loaiTienDo === "progress" ? ` 
                        <div class="evaluation-buttons">
                           <button class="button button-evaluate" onclick="danhgiatiendo('${loaiTienDo}','${submissionDeadline}','${madetai_kt}')">Đánh giá</button>
                        </div>
                    ` : ''}
                </div>`;

            fetch("../luutiendo.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    loai_tien_do: loaiTienDo,
                    ngay_nop: submissionDeadline,
                    madetai: madetai_kt
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("Data saved successfully.");
                    loadNotesOnPageLoad(); // Tải ghi chú khi lưu thành công
                } else {
                    console.error("Error saving data:", data.error);
                }
            })
            .catch(error => console.error("Error:", error));

            break;
        case "tailieu":
            subContentHTML = `<div id="${positionID}" class="sub-section-content">
                                <input type="file" class="file-upload" onchange="previewFile(event, '${positionID}')"/>
                                <div class="file-preview" id="file-preview-${positionID}">Chưa có tệp nào được chọn</div>
                              </div>`;
            break;
        case "thaoLuan":
            subContentHTML = `<div id="${positionID}" class="discussion-thread">Thảo luận mới</div>`;
            break;
        default:
            console.error("Loại nội dung không xác định");
            return;
    }

    const subSectionData = {
        type: selectedType,
        content: subContentHTML,
        positionID: positionID
    };

    const content = document.createElement("div");
    content.classList.add("sub-section");
    content.innerHTML = `
        ${subSectionData.content}
        <div class="content-actions">
            ${selectedType !== "tailieu" ? `<button class="button button-edit" onclick="editSubSection(this)"><i class="fas fa-edit"></i> Sửa</button>` : ""}
            <button class="button button-delete" onclick="deleteSubSection(this)"><i class="fas fa-trash-alt"></i> Xóa</button>
        </div>
    `;

    const section = currentSection || document.querySelector(".section");
    const sectionContent = section.querySelector(".section-content");

    if (sectionContent) {
        sectionContent.appendChild(content);
        console.log(`Added sub-section with ID: ${positionID} to section content.`);
        loadNotesOnPageLoad(); // Tải lại ghi chú sau khi thêm phần tử mới
    } else {
        console.error("Không tìm thấy phần tử .section-content trong phần 'Thông Báo'.");
        return;
    }

    const sectionTitle = section.querySelector("h2").innerText;
    const sectionData = sections.find(s => s.title === sectionTitle);
    if (sectionData) {
        sectionData.subSections.push(subSectionData);
    }

    saveToLocalStorageAndDatabase();
    closeModal();
}






























function loadNotesOnPageLoad() {
    const noteInputs = document.querySelectorAll('.note-input');
    var madetai = getMadetai();
    noteInputs.forEach(noteInput => {
        const parent = noteInput.closest('.sub-section-content');
        if (!parent) return;

        const parentID = parent.id; // ID của phần sub-section
        const submissionTitle = parent.querySelector('.submission-title');
        if (!submissionTitle) return;

        const isProgress = submissionTitle.innerText.includes("Nộp tiến độ");
        const loaiTienDo = isProgress ? "progress" : "final";
        const submissionDeadline = submissionTitle.innerText.split(' - Hạn nộp: ')[1];

        if (!submissionDeadline) {
            console.error("Không thể tìm thấy thời hạn nộp.");
            return;
        }

        // Gửi yêu cầu AJAX để lấy ghi chú
        fetch("../layghichutiendo.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                madetai: madetai,
                loaitiendo: loaiTienDo,
                ngay_nop: submissionDeadline
            })
        })
        .then(res => res.json())
        .then(noteData => {
            console.log("Tham số gửi API:", {
                madetai:madetai,
                loaitiendo: loaiTienDo,
                ngay_nop: submissionDeadline
            }); // Log tham số gửi
            console.log("Kết quả API trả về:", noteData); // Log kết quả trả về
            if (noteData.success && noteData.note !== null) {
                noteInput.value = noteData.note;
            } else {
                noteInput.value = "Không có ghi chú.";
            }
        })
        .catch(error => {
            console.error("Lỗi khi tải ghi chú:", error);
            noteInput.value = "Không có ghi chú.";
        });
        
    });
}







//đánh giá đề tài
function danhgiatiendo(loaidetai, ngaynop, madetai) {
    const modal = document.getElementById('model-danhgia');

    // Gửi yêu cầu đến server để lấy dữ liệu
    fetch(`../laytiendo.php?madetai=${madetai}&loaidetai=${loaidetai}&ngaynop=${ngaynop}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Hiển thị dữ liệu vào modal
                document.getElementById('evaluation-content').value = data.evaluation || '';
                document.getElementById('progress-percentage').value = data.percentage || 0;
                document.getElementById('total-percentage').innerText = `${data.total_percentage || 0}%`;
            } else {
                // Nếu không có dữ liệu, đặt giá trị mặc định
                document.getElementById('evaluation-content').value = '';
                document.getElementById('progress-percentage').value = 0;
                document.getElementById('total-percentage').innerText = '0%';
            }

            // Hiển thị modal
            modal.style.display = 'block';
        })
        .catch(error => {
            console.error("Lỗi khi tải dữ liệu đánh giá:", error);
            alert("Đã xảy ra lỗi khi tải dữ liệu đánh giá.");
        });

    // Lưu dữ liệu khi nhấn nút "Lưu đánh giá"
    document.getElementById('save-evaluation').onclick = () => saveEvaluation(madetai, loaidetai, ngaynop);
    }


// lưu đánh giá
function saveEvaluation(madetai, loaidetai, ngaynop) {
    const evaluationContent = document.getElementById('evaluation-content').value;
    const progressPercentage = document.getElementById('progress-percentage').value;

    if (progressPercentage < 0 || progressPercentage > 100) {
        alert("Phần trăm hoàn thành phải từ 0 đến 100.");
        return;
    }

    // Gửi dữ liệu đến server để lưu
    fetch('../luudanhgia.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            madetai,
            loaidetai,
            ngaynop,
            evaluation: evaluationContent,
            percentage: progressPercentage,
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Đánh giá đã được lưu thành công.");
                closeModal('model-danhgia');
            } else {
                alert("Lỗi khi lưu đánh giá: " + data.error);
            }
        })
        .catch(error => {
            console.error("Lỗi khi lưu đánh giá:", error);
            alert("Đã xảy ra lỗi khi lưu đánh giá.");
        });
}



/* Hàm xem trước file */
function previewFile(event, positionID) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById(`file-preview-${positionID}`);
    
    if (file) {
        previewContainer.innerHTML = `<p>${file.name}</p>`;
    } else {
        previewContainer.innerHTML = "Chưa có tệp nào được chọn";
    }
}

document.addEventListener('change', function (event) {
    if (event.target.classList.contains('file-upload')) {
        const fileInput = event.target;
        const subSectionContent = fileInput.closest('.sub-section-content');

        if (subSectionContent) {
            const positionID = subSectionContent.id;

            if (fileInput.files.length > 0) {
                const formData = new FormData();
                formData.append('file', fileInput.files[0]);
                formData.append('positionID', positionID);
                formData.append('sectionTitle', document.querySelector('.section h2').innerText);

                fetch('../uploadfile.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("File đã được tải lên thành công!");

                        // Tìm thẻ <p> để hiển thị file
                        const previewContainer = document.getElementById(`file-preview-${positionID}`);
                        if (previewContainer) {
                            // Xóa nội dung cũ
                            previewContainer.innerHTML = "";

                            // Tạo liên kết tệp mới
                            const fileLink = document.createElement('a');
                            fileLink.href = `../${data.file_path}`; // Thêm ../ vào đường dẫn
                            fileLink.innerText = fileInput.files[0].name;
                            fileLink.target = "_blank";
                            fileLink.classList.add('uploaded-file-link');

                            // Thêm liên kết vào thẻ <p>
                            previewContainer.appendChild(fileLink);
                        } else {
                            console.error(`Không tìm thấy thẻ <p> với id: file-preview-${positionID}`);
                        }
                    } else {
                        alert("Lỗi khi tải lên file: " + data.error);
                    }
                })
                .catch(error => {
                    console.error("Lỗi:", error);
                    alert("Đã xảy ra lỗi khi tải lên file.");
                });
            }
        } else {
            console.error("Không tìm thấy sub-section-content để lấy positionID.");
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {
    loadNotesOnPageLoad()
    fetch("../loadfilehienthi.php")
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const files = data.data;

                files.forEach(file => {
                    const previewContainer = document.getElementById(`file-preview-${file.vi_tri_id}`);
                    if (previewContainer) {
                        // Xóa nội dung cũ
                        previewContainer.innerHTML = "";

                        // Tạo liên kết tệp
                        const fileLink = document.createElement('a');
                        fileLink.href = `../${file.duong_dan_tep}`; // Thêm ../ vào đầu đường dẫn
                        fileLink.innerText = file.ten_tep;
                        fileLink.target = "_blank";
                        fileLink.classList.add('uploaded-file-link');

                        // Thêm liên kết vào thẻ <p>
                        previewContainer.appendChild(fileLink);
                    } else {
                        console.error(`Không tìm thấy thẻ <p> với id: file-preview-${file.vi_tri_id}`);
                    }
                });
            } else {
                console.error("Lỗi khi tải tệp:", data.error);
            }
        })
        .catch(error => console.error("Lỗi khi gọi loadfilehienthi.php:", error));
});

function uploadFile(positionID, file) {
    const formData = new FormData();
    formData.append("file", file);
    formData.append("positionID", positionID);

    fetch("../uploadfile.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("File đã được upload thành công!");

            // Tìm thẻ <p> để hiển thị file
            const previewContainer = document.getElementById(`file-preview-${positionID}`);
            if (previewContainer) {
                // Xóa nội dung cũ
                previewContainer.innerHTML = "";

                // Tạo liên kết tệp mới
                const fileLink = document.createElement('a');
                fileLink.href = `../${data.file_path}`;
                fileLink.innerText = file.name;
                fileLink.target = "_blank";
                fileLink.classList.add('uploaded-file-link');

                // Thêm liên kết vào thẻ <p>
                previewContainer.appendChild(fileLink);
            } else {
                console.error(`Không tìm thấy thẻ <p> với id: file-preview-${positionID}`);
            }
        } else {
            // alert("Lỗi upload file: " + data.error);
        }
    })
    .catch(error => console.error("Lỗi kết nối:", error));
}

// Thêm sự kiện upload cho input file khi người dùng chọn file
document.addEventListener("change", function (event) {
    if (event.target.classList.contains("file-upload")) {
        const subSectionContent = event.target.closest(".sub-section-content");
        if (subSectionContent) {
            const positionID = subSectionContent.id;
            const file = event.target.files[0];
            
            if (file) {
                uploadFile(positionID, file);
            }
        }
    }
});



//Lấy loại nộp - hạn nộp
function laythongtinnop(submissionTitleElement) {
    if (!submissionTitleElement || !submissionTitleElement.innerText) {
        console.error("Không tìm thấy nội dung trong submission-title.");
        return null;
    }

    const text = submissionTitleElement.innerText.trim();

    // Tách nội dung
    const regex = /(Nộp tiến độ|Nộp sản phẩm cuối cùng)\s*-\s*Hạn nộp:\s*([\d-]+)/;
    const match = text.match(regex);

    if (match) {
        const loaiTiendo = match[1] === "Nộp tiến độ" ? "progress" : "final"; // Ánh xạ loại tiến độ
        const ngayNop = match[2]; // Hạn nộp
        return { loaiTiendo, ngayNop };
    } else {
        console.error("Không thể tách loại tiến độ và ngày nộp.");
        return null;
    }
}




var madetai_xoacon = getMadetai();

// Hàm xóa nội dung con
function deleteSubSection(button) {
    if (confirm("Bạn có chắc chắn muốn xóa nội dung này không?")) {
        const subSection = button.closest(".sub-section");
        const submissionTitle = subSection.querySelector(".submission-title");
        const noteInput = subSection.querySelector(".note-input");
        const section = button.closest(".section");
        const sectionTitle = section.querySelector("h2").innerText;
        const sectionData = sections.find(s => s.title === sectionTitle);
        if (sectionData) {
            sectionData.subSections = sectionData.subSections.filter(sub => sub.content !== subSection.innerHTML);
            saveToLocalStorageAndDatabase(); // Save immediately after deleting a sub-section
        }
        //là nộp sản phẩm
       
        subSection.remove();
        if(submissionTitle && noteInput){
            var madt = getMadetai();
            // Lấy thông tin loại tiến độ và ngày nộp
            const info =laythongtinnop(submissionTitle);

            if (info) {
                const { loaiTiendo, ngayNop } = info;
               

                if (madt && loaiTiendo && ngayNop) {
                    // Gửi yêu cầu xóa đến backend
                    fetch("../xoatiendo.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            madetai: madt,
                            loaitiendo: loaiTiendo,
                            ngaynop: ngayNop,
                        }),
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log("Xóa tiến độ thành công.");
                                // subSection.remove(); // Xóa khỏi giao diện
                            } else {
                                alert("Lỗi khi xóa tiến độ: " + data.error);
                            }
                        })
                        .catch(error => {
                            console.error("Lỗi khi gọi API xóa tiến độ:", error);
                            alert("Đã xảy ra lỗi khi xóa tiến độ.");
                        });
                } else {
                    console.error("Không đủ thông tin để xóa: madetai, loaitiendo, hoặc ngaynop bị thiếu.");
                }
            } else {
                console.error("Không thể lấy thông tin từ submission-title.");
            }
        }
        
    }
}

// Hàm thêm phần vào DOM
function addSectionToDOM(newSection) {
    // Tìm container với class "container"
    const container = document.querySelector(".container-top");
    
    if (!container) {
        console.error("Không tìm thấy div có class 'container'. Không thể thêm phần mới.");
        return; // Dừng nếu không tìm thấy container
    }

    // Tạo phần mới với cấu trúc HTML chuẩn
    const sectionElement = document.createElement("section");
    sectionElement.classList.add("section");

    sectionElement.innerHTML = `
        <div class="section-header">
            <h2>${newSection.title}</h2>
            <button class="button button-add" onclick="addSubSection(this, 'thongbao')">
                <i class="fas fa-plus"></i> Thêm Nội Dung
            </button>
        </div>
        <div class="section-content"></div>
        <div class="section-actions">
            <button class= "button button-delete" onclick="deleteSection(this)">Xóa phần</button>
        </div>
    `;

    // Thêm phần mới vào container
    container.appendChild(sectionElement);
}


// chỉnh sủa nội duung con

let currentEditingSubSection = null;

function editSubSection(button) {
    const subSection = button.closest(".sub-section");

    // Kiểm tra xem phần tử đang chỉnh sửa là phần "Nộp sản phẩm", "Thông báo", hay "Tài liệu"
    const submissionTitle = subSection.querySelector(".submission-title");
    const noteInput = subSection.querySelector(".note-input");
    const isAnnouncement = subSection.querySelector(".submission-title") === null && subSection.querySelector(".sub-section-content") !== null;
    const isDocument = subSection.querySelector(".file-upload") !== null;

    if (submissionTitle && noteInput) {
        // Lấy thời hạn nộp từ tiêu đề
        const currentDeadline = submissionTitle.innerText.match(/Hạn nộp: (.*)$/)?.[1] || "";
    
        // Xác định loại tiến độ
        const titleText = submissionTitle.innerText.split(" - ")[0]; // Ví dụ: "Nộp tiến độ"
        const loaitiendoMap = {
            "Nộp tiến độ": "progress",
            "Nộp sản phẩm cuối cùng": "final"
        };
        const loaitiendo = loaitiendoMap[titleText] || null;
    
        // Lấy mã đề tài (đảm bảo bạn đã có phương thức này)
        const madetai = getMadetai(); // Hàm lấy mã đề tài, bạn cần định nghĩa nó
    
        // Kiểm tra các tham số có hợp lệ không
        if (!loaitiendo || !madetai || !currentDeadline) {
            console.error("Thiếu thông tin loại tiến độ, mã đề tài, hoặc thời hạn nộp.");
            return;
        }
    
        // Gửi AJAX để lấy ghi chú từ cơ sở dữ liệu
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../layghichutiendo.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");
    
        xhr.onload = function () {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        const currentNote = response.note || "";
    
                        // Hiển thị modal chỉnh sửa nộp sản phẩm
                        document.getElementById("editDeadline").value = currentDeadline;
                        document.getElementById("editNote").value = currentNote;
    
                        // Lưu lại phần tử con đang được chỉnh sửa
                        currentEditingSubSection = subSection;
    
                        // Hiển thị modal nộp sản phẩm
                        document.getElementById("editModal").style.display = "block";
                    } else {
                        console.error("Lỗi lấy ghi chú:", response.error);
                    }
                } catch (e) {
                    console.error("Lỗi phân tích JSON:", e, xhr.responseText);
                }
            } else {
                console.error("Lỗi kết nối server. Status:", xhr.status);
            }
        };
    
        const data = {
            madetai: madetai,
            loaitiendo: loaitiendo,
            ngay_nop: currentDeadline
        };
    
        xhr.send(JSON.stringify(data));
    }
    
    
    // Phần "Thông báo"
    else if (isAnnouncement) {
        console.log("Chỉnh sửa thông báo");

        // Lấy nội dung thông báo hiện tại từ div.sub-section-content
        const currentContent = subSection.querySelector(".sub-section-content").innerText;

        // Hiển thị nội dung thông báo trong modal
        document.getElementById("editAnnouncementContent").value = currentContent;

        // Lưu lại phần tử con đang được chỉnh sửa
        currentEditingSubSection = subSection;

        // Hiển thị modal chỉnh sửa thông báo
        document.getElementById("editAnnouncementModal").style.display = "block";
    }
    // Phần "Tài liệu"
    else if (isDocument) {
        console.log("Chỉnh sửa tài liệu");

        // Lấy tên tài liệu hiện tại
        const currentFileName = subSection.querySelector("p").textContent;

        // Hiển thị modal chỉnh sửa tài liệu
        document.getElementById("editDocumentFileName").value = currentFileName;

        // Lưu lại phần tử con đang được chỉnh sửa
        currentEditingSubSection = subSection;

        // Hiển thị modal chỉnh sửa tài liệu
        document.getElementById("editDocumentModal").style.display = "block";
    }
}

// Hàm lưu thay đổi của thông báo
function saveEditAnnouncement() {
    const newContent = document.getElementById("editAnnouncementContent").value;

    // Thay \n thành <br> để giữ dòng mới khi hiển thị lại trong HTML
    const formattedContent = newContent.replace(/\n/g, "<br>");

    // Cập nhật nội dung trong phần tử .sub-section-content
    currentEditingSubSection.querySelector(".sub-section-content").innerHTML = formattedContent;

    // Đóng modal chỉnh sửa thông báo
    closeModal2('editAnnouncementModal');
}

// Hàm lưu thay đổi của tài liệu
function saveEditDocument() {
    const newFileName = document.getElementById("editDocumentFileName").value;

    // Cập nhật tên tài liệu trong phần tử
    currentEditingSubSection.querySelector("p").textContent = newFileName;

    // Đóng modal chỉnh sửa tài liệu
    closeModal2('editDocumentModal');
}


// Hàm đóng các modal
function closeModal2(modalId) {
    document.getElementById(modalId).style.display = "none";
}


function closeEditModal() {
    document.getElementById("editModal").style.display = "none";
    currentEditingSubSection = null;
}

function saveSubSectionChanges() {
    if (currentEditingSubSection) {
        const newDeadline = document.getElementById("editDeadline").value;
        const oldDeadlineMatch = currentEditingSubSection.querySelector(".submission-title").innerText.match(/Hạn nộp: (.+)/);
        const oldDeadline = oldDeadlineMatch ? oldDeadlineMatch[1] : null; // Lấy ngày nộp cũ
        const newNote = document.getElementById("editNote").value;

        // Lấy loại tiến độ từ tiêu đề
        const titleText = currentEditingSubSection.querySelector(".submission-title").innerText;
        let loaitiendoDisplay = titleText.split(" - ")[0]; // Lấy phần đầu tiêu đề (ví dụ: "Nộp tiến độ")

        // Chuyển đổi sang giá trị lưu trữ trong cơ sở dữ liệu
        const loaitiendoMap = {
            "Nộp tiến độ": "progress",
            "Nộp sản phẩm cuối cùng": "final"
        };
        const loaitiendo = loaitiendoMap[loaitiendoDisplay] || null; // Đảm bảo giá trị hợp lệ

        // Kiểm tra nếu thiếu thông tin
        if (!oldDeadline || !loaitiendo) {
            console.error("Không thể xác định hạn nộp cũ hoặc loại tiến độ.");
            return;
        }

        // Update the deadline in the title
        const submissionTitle = currentEditingSubSection.querySelector(".submission-title");
        submissionTitle.innerHTML = submissionTitle.innerHTML.replace(/Hạn nộp: .*/, `Hạn nộp: ${newDeadline}`);

        // Update the note
        const noteInput = currentEditingSubSection.querySelector(".note-input");
        noteInput.value = newNote;

        // Save changes to sections array
        const sectionTitle = currentEditingSubSection.closest(".section").querySelector("h2").innerText;
        const sectionData = sections.find(s => s.title === sectionTitle);
        if (sectionData) {
            const index = sectionData.subSections.findIndex(sub => sub.content === currentEditingSubSection.innerHTML);
            if (index !== -1) {
                sectionData.subSections[index].content = currentEditingSubSection.innerHTML;
                saveToLocalStorageAndDatabase(); // Save immediately after editing a sub-section
            }
        }

        // Send AJAX request to update database
        const madetai = getMadetai(); // Adjust as needed if `madetai` is different
        updateDatabase(madetai, loaitiendo, oldDeadline, newDeadline, newNote);

        // Close the modal
        closeEditModal();
    }
}


function updateDatabase(madetai, loaitiendo, oldDeadline, newDeadline, newNote) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../capnhatnoptiendo.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                console.log("Cập nhật thành công.");
            } else {
                console.error("Lỗi cập nhật:", response.error);
            }
        } else {
            console.error("Lỗi kết nối server.");
        }
    };

    const data = {
        madetai: madetai,
        loaitiendo: loaitiendo,
        oldDeadline: oldDeadline,
        newDeadline: newDeadline,
        newNote: newNote
    };

    xhr.send(JSON.stringify(data));
}






// Giám sát sự thay đổi trong DOM và gửi dữ liệu mới tới CSDL
const observer = new MutationObserver(saveToDatabase);

// Khởi tạo MutationObserver để theo dõi thay đổi trong DOM
observer.observe(document.querySelector('.container'), {
    childList: true,
    subtree: true
});




// Retrieve userId and username from localStorage, with fallback values
const userId = localStorage.getItem("ma") ;
const username = localStorage.getItem("hoten");
const dt2 = getMadetai(); // Replace with a function to get the current topic ID

loadMessages();

function sendChatMessage() {
    const chatInput = document.getElementById("chatInput");
    const message = chatInput.value.trim();
    if (message === "") return;

    const timestamp = new Date().toISOString(); // Store timestamp in ISO format
    displayMessage(username, message, timestamp, true); // Display message on the right side for current user

    chatInput.value = ""; // Clear input field

    // Send data to backend
    fetch('../luutinnhan.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ userId, username, dt2, message, timestamp })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "error") {
            alert("Không thể gửi tin nhắn: " + data.message);
        } else {
            loadMessages(); // Refresh chat messages after sending
        }
    })
    .catch(error => console.error("Fetch error:", error));
}



// Function to display a message in the chat box
function displayMessage(senderId, message, timestamp, isSelf, messageId = null) {
    const chatBox = document.getElementById("chatBox");
    const newMessage = document.createElement("div");

    // Apply styling based on message source
    newMessage.classList.add("message", isSelf ? "align-right" : "align-left");

    // Add message content and timestamp
    newMessage.innerHTML = `
        <span><strong>${isSelf ? "Bạn" : senderId}:</strong> ${message}</span>
        <br><small>${new Date(timestamp).toLocaleString()}</small>
    `;

    // If the message is from the current user, add a delete button
    if (isSelf && messageId) {
        const deleteButton = document.createElement("button");
        deleteButton.textContent = "Xóa";
        deleteButton.classList.add("delete-button");
        deleteButton.onclick = () => deleteMessage(messageId, newMessage);
        newMessage.appendChild(deleteButton);
    }

    chatBox.appendChild(newMessage);
    chatBox.scrollTop = chatBox.scrollHeight;  // Auto-scroll to the bottom
}

// Function to load messages from the backend and display them
function loadMessages() {
    fetch(`../loadnoidungchat.php?madetai=${dt2}`)
        .then(response => response.json())
        .then(messages => {
            const chatBox = document.getElementById("chatBox");
            chatBox.innerHTML = ""; // Clear existing messages before loading new ones

            messages.forEach(msg => {
                const isSelf = msg.manguoigui === userId; // Check if the message is from the current user
                const senderName = isSelf ? "Bạn" : msg.tennguoigui;
                displayMessage(senderName, msg.noidung, msg.ngaygui, isSelf, msg.id);
            });

            // Scroll to the bottom of the chat box after loading all messages
            chatBox.scrollTop = chatBox.scrollHeight;
        })
        .catch(error => console.error("Fetch error:", error));
}

// Function to delete a message
function deleteMessage(messageId, messageElement) {
    fetch(`../xoatinnhan.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ messageId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            messageElement.remove(); // Remove message from the UI
        } else {
            alert("Không thể xóa tin nhắn: " + data.message);
        }
    })
    .catch(error => console.error("Fetch error:", error));
}

// Load messages when the page loads
document.addEventListener("DOMContentLoaded", loadMessages);


function checkEnter(event) {
    if (event.key === "Enter" && !event.shiftKey) {
        sendChatMessage();
        event.preventDefault(); // Prevents line break
    }
}



// Tải lại các phần khi trang được tải
// window.onload = loadSectionsFromDatabase;




