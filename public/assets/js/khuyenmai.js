document.addEventListener('DOMContentLoaded', async function (){
    let listKhuyenMaiGoc = []
    const tableKhuyenMai = document.querySelector('#table-khuyenMai tbody')
    const btnThem = document.querySelector('#btn-them')
    const btnXacNhanXoa = document.querySelector('#btn-xacNhanXoa')
    const btnXacNhanCapNhat = document.querySelector('#btn-CapNhat')

    const messageKhuyenMai = document.querySelector('#message-khuyenMai')
    const messageXoa = document.querySelector('#message-xoa')
    const messageErrorThemChuDe = document.querySelector('#message-errorThemChuDe')
    const messageErrorThemBatDau = document.querySelector('#message-errorThemBatDau')
    const messageErrorThemKetThuc = document.querySelector('#message-errorThemKetThuc')
    const messageErrorThemDieuKien = document.querySelector('#message-errorThemDieuKien')

    const messageErrorCapNhatChuDe = document.querySelector('#message-errorCapNhatChuDe')
    const messageErrorCapNhatBatDau = document.querySelector('#message-errorCapNhatBatDau')
    const messageErrorCapNhatKetThuc = document.querySelector('#message-errorCapNhatKetThuc')
    const messageErrorCapNhatDieuKien = document.querySelector('#message-errorCapNhatDieuKien')

    const txtTimKiem = document.querySelector('#txt-timKiem')
    const txtThemChuDe = document.querySelector('#txt-ThemChuDe')
    const txtThemBatDau = document.querySelector('#txt-ThemBatDau')
    const txtThemKetThuc = document.querySelector('#txt-ThemKetThuc')
    const txtThemDieuKien = document.querySelector('#txt-ThemDieuKien')

    const txtCapNhatChuDe = document.querySelector('#txt-CapNhatChuDe')
    const txtCapNhatBatDau = document.querySelector('#txt-CapNhatBatDau')
    const txtCapNhatKetThuc = document.querySelector('#txt-CapNhatKetThuc')
    const txtCapNhatDieuKien = document.querySelector('#txt-CapNhatDieuKien')
    const txtCapNhatMoTa = document.querySelector('#txt-CapNhatMoTa')

    const comboboxTimKiem = document.querySelector('#combobox-timKiem')
    const comboboxThemPhanTram = document.querySelector('#combobox-ThemPhanTram')
    const comboboxCapNhatPhanTram = document.querySelector('#combobox-CapNhatPhanTram')

    let hopLeThemChuDe = false
    let hopLeThemDieuKien = false
    let hopLeThemBatDau = false
    let hopLeThemKetThuc = false

    let hopLeCapNhatChuDe = false
    let hopLeCapNhatDieuKien = false
    let hopLeCapNhatBatDau = false
    let hopLeCapNhatKetThuc = false

    function renderKhuyenMai(list){
        tableKhuyenMai.innerHTML = ''
        if(list.length > 0){
            messageKhuyenMai.classList.add('d-none')
            list.forEach(function (khuyenMai, index){
                let newRow = document.createElement('tr')
                newRow.innerHTML = `
                <td >${index + 1}</td>
                <td>${khuyenMai.MaKhuyenMai}</td>
                <td>${khuyenMai.ChuDe}</td>
                <td>${khuyenMai.PhanTram}</td>
                <td>${khuyenMai.BatDau}</td>
                <td>${khuyenMai.KetThuc}</td>
                <td>
                    <a href="./khuyen-mai-chi-tiet-${khuyenMai.MaKhuyenMai}" class="btn btn-light">Xem</a>
                    <button class="btn btn-outline-danger btn-xoa" data-bs-toggle="modal" data-bs-target="#message-xoa" value="${khuyenMai.MaKhuyenMai}">Xóa</button>
                    <button class="btn btn-outline-primary btn-capNhat" data-bs-toggle="modal" data-bs-target="#form-capNhat" value="${khuyenMai.MaKhuyenMai}">Cập nhật</button>
                </td>
            `
                tableKhuyenMai.appendChild(newRow)
            })

        }
        else{
            messageKhuyenMai.classList.remove('d-none')
        }

        const btnXoaS = document.querySelectorAll('.btn-xoa')
        btnXoaS.forEach(function (btn, index){
            btn.onclick = function (){
                btnXacNhanXoa.value = this.value

                messageXoa.querySelector('.modal-body').innerHTML = `Bạn có muốn xóa khuyến mãi có mã là ${this.value} không ?`
            }
        })
        btnXacNhanXoa.onclick = async function (){
            try {
                const response = await fetch('./fetch/xoa-khuyen-mai', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body:JSON.stringify({'MaKhuyenMai':this.value})
                })
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                const data = await response.json()
                if(data.status === 'success'){
                    window.location.href = './khuyen-mai'
                }
            }
            catch (error){
                console.error('Fetch error: ', error)
            }

        }
        const btnCapNhatS = document.querySelectorAll('.btn-capNhat')
        btnCapNhatS.forEach(function (btn, index){
            btn.onclick = function (){
                const khuyenMai = listKhuyenMaiGoc.find(km => km.MaKhuyenMai === parseInt(this.value))
                txtCapNhatChuDe.value = khuyenMai.ChuDe
                txtCapNhatDieuKien.value = khuyenMai.DieuKien
                txtCapNhatBatDau.value = khuyenMai.BatDau
                txtCapNhatKetThuc.value = khuyenMai.KetThuc
                txtCapNhatMoTa.value = khuyenMai.MoTa
                comboboxCapNhatPhanTram.value = khuyenMai.PhanTram
                btnXacNhanCapNhat.value = khuyenMai.MaKhuyenMai

            }
        })
    }
    
    function kiemTraThemChuDe(){
        if(txtThemChuDe.value === ''){
            hopLeThemChuDe = false
            messageErrorThemChuDe.innerHTML = 'Không được để trống'
        }
        else {
            hopLeThemChuDe = true
            messageErrorThemChuDe.innerHTML = ''
        }
    }
    function kiemTraThemDieuKien(){
        if(txtThemDieuKien.value === ''){
            hopLeThemDieuKien = false
            messageErrorThemDieuKien.innerHTML = 'Không được để trống'
        }
        else {
            hopLeThemDieuKien = true
            messageErrorThemDieuKien.innerHTML = ''
        }
    }
    function kiemTraThemBatDau(){
        const startTime = new Date(txtThemBatDau.value);
        const currentTime = new Date();
        if(txtThemBatDau.value === ''){
            hopLeThemBatDau = false
            messageErrorThemBatDau.innerHTML = 'Không được để trống'
        }
        else {
            if(startTime <= currentTime){
                hopLeThemBatDau = false
                messageErrorThemBatDau.innerHTML = 'Thời gian bắt đầu phải sau thời gian hiện tại'
            }
            else{
                hopLeThemBatDau = true
                messageErrorThemBatDau.innerHTML = ''
            }
        }
    }
    function kiemTraThemKetThuc(){

        if(txtThemKetThuc.value === ''){
            hopLeThemKetThuc = false
            messageErrorThemKetThuc.innerHTML = 'Không được để trống'
        }
        else {
            const startTime = new Date(txtThemBatDau.value);
            const endTime = new Date(txtThemKetThuc.value);
            if(endTime <= startTime){
                hopLeThemKetThuc = false
                messageErrorThemKetThuc.innerHTML = 'Thời gian kết thúc phải sau thời gian bắt đầu'
            }
            else{
                hopLeThemKetThuc = true
                messageErrorThemKetThuc.innerHTML = ''
            }
        }
    }

    function kiemTraCapNhatChuDe(){
        if(txtCapNhatChuDe.value === ''){
            hopLeCapNhatChuDe = false
            messageErrorCapNhatChuDe.innerHTML = 'Không được để trống'
        }
        else {
            hopLeCapNhatChuDe = true
            messageErrorCapNhatChuDe.innerHTML = ''
        }
    }
    function kiemTraCapNhatDieuKien(){
        if(txtCapNhatDieuKien.value === ''){
            hopLeCapNhatDieuKien = false
            messageErrorCapNhatDieuKien.innerHTML = 'Không được để trống'
        }
        else {
            hopLeCapNhatDieuKien = true
            messageErrorCapNhatDieuKien.innerHTML = ''
        }
    }
    function kiemTraCapNhatBatDau(){
        const startTime = new Date(txtCapNhatBatDau.value);
        const currentTime = new Date();
        if(txtCapNhatBatDau.value === ''){
            hopLeCapNhatBatDau = false
            messageErrorCapNhatBatDau.innerHTML = 'Không được để trống'
        }
        else {
            if(startTime <= currentTime){
                hopLeCapNhatBatDau = false
                messageErrorCapNhatBatDau.innerHTML = 'Thời gian bắt đầu phải sau thời gian hiện tại'
            }
            else{
                hopLeCapNhatBatDau = true
                messageErrorCapNhatBatDau.innerHTML = ''
            }
        }
    }
    function kiemTraCapNhatKetThuc(){

        if(txtCapNhatKetThuc.value === ''){
            hopLeCapNhatKetThuc = false
            messageErrorCapNhatKetThuc.innerHTML = 'Không được để trống'
        }
        else {
            const startTime = new Date(txtCapNhatBatDau.value);
            const endTime = new Date(txtCapNhatKetThuc.value);
            if(endTime <= startTime){
                hopLeCapNhatKetThuc = false
                messageErrorCapNhatKetThuc.innerHTML = 'Thời gian kết thúc phải sau thời gian bắt đầu'
            }
            else{
                hopLeCapNhatKetThuc = true
                messageErrorCapNhatKetThuc.innerHTML = ''
            }
        }
    }

    function timKiemKhuyenMai(){
        if(txtTimKiem.value === ''){
            renderKhuyenMai(listKhuyenMaiGoc)
        }
        else {
            let ds = []
            if(parseInt(comboboxTimKiem.value) === 1){

                listKhuyenMaiGoc.forEach(function (khuyenMai, index){
                    let maKhuyenMai = khuyenMai.MaKhuyenMai + ''
                    if(txtTimKiem.value.length <= maKhuyenMai.length && maKhuyenMai.includes(txtTimKiem.value)){
                        ds.push(khuyenMai)
                    }
                })
            }
            else {
                listKhuyenMaiGoc.forEach(function (khuyenMai, index){
                    let chuDe = khuyenMai.ChuDe + ''
                    if(txtTimKiem.value.length <= chuDe.length && chuDe.includes(txtTimKiem.value)){
                        ds.push(khuyenMai)
                    }
                })
            }
            renderKhuyenMai(ds)

        }
    }

    async function themKhuyenMai(obj){
        try {
            const response = await fetch('./fetch/them-khuyen-mai',{
                method: 'POST',
                headers:{
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(obj)
            })
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            const data = await response.json()
            if(data.status === 'success'){
                window.location.href = './khuyen-mai'
            }
        }
        catch (error){
            console.error('Fetch error: ', error)
        }
    }
    async function capNhatKhuyenMai(obj){
        try {
            const response = await fetch('./fetch/cap-nhat-khuyen-mai',{
                method: 'POST',
                headers:{
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(obj)
            })
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            const data = await response.json()
            if(data.status === 'success'){
                window.location.href = './khuyen-mai'
            }
        }
        catch (error){
            console.error('Fetch error: ', error)
        }
    }

    btnThem.onclick = function (){
        kiemTraThemChuDe()
        kiemTraThemBatDau()
        kiemTraThemKetThuc()
        kiemTraThemDieuKien()

        if(hopLeThemBatDau === true && hopLeThemKetThuc === true && hopLeThemChuDe === true && hopLeThemDieuKien === true){

            let newKhuyenMai = {
                'ChuDe': txtThemChuDe.value,
                'PhanTram': comboboxThemPhanTram.value,
                'DieuKien': txtThemDieuKien.value,
                'BatDau': txtThemBatDau.value.replace("T", " ") + ":00",
                'KetThuc': txtThemKetThuc.value.replace("T", " ") + ":00"
            }
            themKhuyenMai(newKhuyenMai)
        }
    }
    btnXacNhanCapNhat.onclick = function (){
        kiemTraCapNhatChuDe()
        kiemTraCapNhatBatDau()
        kiemTraCapNhatKetThuc()
        kiemTraCapNhatDieuKien()

        if(hopLeCapNhatBatDau === true && hopLeCapNhatKetThuc === true && hopLeCapNhatChuDe === true && hopLeCapNhatDieuKien === true){

            let khuyenMai = {
                'MaKhuyenMai': this.value,
                'ChuDe': txtCapNhatChuDe.value,
                'PhanTram': comboboxCapNhatPhanTram.value,
                'DieuKien': txtCapNhatDieuKien.value,
                'BatDau': txtCapNhatBatDau.value.replace("T", " ") + ":00",
                'KetThuc': txtCapNhatKetThuc.value.replace("T", " ") + ":00",
                'MoTa': txtCapNhatMoTa.value
            }
            capNhatKhuyenMai(khuyenMai)
        }
    }

    txtThemDieuKien.oninput = function (){
        let start = this.selectionStart;
        let end = this.selectionEnd;

        // Loại bỏ các ký tự không phải là số
        let inputValue = this.value.replace(/[^0-9]/g, '');
        this.value = inputValue || 1
        this.setSelectionRange(start, end);
    }
    txtCapNhatDieuKien.oninput = function (){
        let start = this.selectionStart;
        let end = this.selectionEnd;

        // Loại bỏ các ký tự không phải là số
        let inputValue = this.value.replace(/[^0-9]/g, '');
        this.value = inputValue || 1
        this.setSelectionRange(start, end);
    }

    txtTimKiem.oninput = function (){
        timKiemKhuyenMai()
    }
    comboboxTimKiem.onchange = function (){
        timKiemKhuyenMai()
    }

    try{
        const response = await fetch('./fetch/danh-sach-khuyen-mai')
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        const data = await response.json()

        listKhuyenMaiGoc = Array.from(data)
        renderKhuyenMai(listKhuyenMaiGoc)
    }
    catch (error){
        console.log('Fetch error: ',error)
    }
})