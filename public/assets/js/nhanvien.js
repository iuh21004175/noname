document.addEventListener('DOMContentLoaded', async function (){
    let listNhanVienGoc = []
    const tableNhanVien = document.querySelector('#table-nhanVien tbody')
    const btnThem = document.querySelector('#btn-them')
    const btnXacNhanXoa = document.querySelector('#btn-xacNhanXoa')
    const btnXacNhanCapNhat = document.querySelector('#btn-CapNhat')

    const txtTimKiem = document.querySelector('#txt-timKiem')
    const txtThemTen = document.querySelector('#txt-ThemTen')
    const txtThemNgaySinh = document.querySelector('#txt-ThemNgaySinh')
    const txtThemSoDienThoai = document.querySelector('#txt-ThemSoDienThoai')
    const txtThemMatKhau = document.querySelector('#txt-ThemMatKhau')
    const txtCapNhatTen = document.querySelector('#txt-CapNhatTen')
    const txtCapNhatNgaySinh = document.querySelector('#txt-CapNhatNgaySinh')
    const txtCapNhatSoDienThoai = document.querySelector('#txt-CapNhatSoDienThoai')
    const txtCapNhatMatKhau = document.querySelector('#txt-CapNhatMatKhau')
    const txtCapNhatDiaChi = document.querySelector('#txt-CapNhatDiaChi')
    const txtCapNhatEmail = document.querySelector('#txt-CapNhatEmail')
    const txtCapNhatGhiChu = document.querySelector('#txt-CapNhatGhiChu')

    const messageXoa = document.querySelector('#message-xoa')
    const messageNhanVien = document.querySelector('#message-nhanVien')
    const messageErrorThemTen = document.querySelector('#message-errorThemTen')
    const messageErrorThemNgaySinh = document.querySelector('#message-errorThemNgaySinh')
    const messageErrorThemSoDienThoai = document.querySelector('#message-errorThemSoDienThoai')
    const messageErrorThemMatKhau = document.querySelector('#message-errorThemMatKhau')
    const messageErrorCapNhatTen = document.querySelector('#message-errorCapNhatTen')
    const messageErrorCapNhatNgaySinh = document.querySelector('#message-errorCapNhatNgaySinh')
    const messageErrorCapNhatSoDienThoai = document.querySelector('#message-errorCapNhatSoDienThoai')
    const messageErrorCapNhatEmail = document.querySelector('#message-errorCapNhatEmail')
    

    const comboboxCapNhatLoaiNhanVien = document.querySelector('#combobox-CapNhatLoaiNhanVien')
    const comboboxTimkiem = document.querySelector('#combobox-timKiem')

    let hopLeThemTen = false
    let hopLeThemNgaySinh = false
    let hopLeThemSoDienThoai = false
    let hopLeThemMatKhau = false

    let hopLeCapNhatTen = false
    let hopLeCapNhatNgaySinh = false
    let hopLeCapNhatSoDienThoai = false
    let hopLeCapNhatEmail = false

    let maCapNhatNhanVien = null
   
    
    function renderNhanVien(list){
        tableNhanVien.innerHTML = ''
        if(list.length > 0){
            messageNhanVien.classList.add('d-none')
            list.forEach(function (nhanVien, index){
                let newRow = document.createElement('tr')
                newRow.innerHTML = `
                <td >${index + 1}</td>
                <td>${nhanVien.MaNhanVien}</td>
                <td>${nhanVien.TenNhanVien}</td>
                <td>${nhanVien.TenLoaiNhanVien}</td>
                <td>
                    <a href="./nhan-vien-chi-tiet-${nhanVien.MaNhanVien}" class="btn btn-light">Xem</a>
                    <button class="btn btn-outline-danger btn-xoa" data-bs-toggle="modal" data-bs-target="#message-xoa" value="${nhanVien.MaNhanVien}">Xóa</button>
                    <button class="btn btn-outline-primary btn-capNhat" data-bs-toggle="modal" data-bs-target="#form-capNhat" value="${nhanVien.MaNhanVien}">Cập nhật</button>
                </td>
            `
                tableNhanVien.appendChild(newRow)
            })


        }
        else{
            messageNhanVien.classList.remove('d-none')
        }
        const btnXoaS = document.querySelectorAll('.btn-xoa')
        btnXoaS.forEach(function (btn, index){
            btn.onclick = function (){
                btnXacNhanXoa.value = this.value

                messageXoa.querySelector('.modal-body').innerHTML = `Bạn có muốn xóa nhân viên có mã là ${this.value} không ?`
            }
        })
        btnXacNhanXoa.onclick = async function (){
            try {
                const response = await fetch('./fetch/xoa-nhan-vien', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body:JSON.stringify({'MaNhanVien':this.value})
                })
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                const data = await response.json()
                if(data.status === 'success'){
                    window.location.href = './nhan-vien'
                }
            }
            catch (error){
                console.error('Fetch error: ', error)
            }

        }
        const btnCapNhatS = document.querySelectorAll('.btn-capNhat')
        btnCapNhatS.forEach(function (btn, index){
            btn.onclick = function (){
                maCapNhatNhanVien = this.value
                let nhanvien = listNhanVienGoc.find(nv => nv.MaNhanVien === parseInt(maCapNhatNhanVien))
                txtCapNhatTen.value = nhanvien.TenNhanVien
                txtCapNhatNgaySinh.value = nhanvien.NgaySinh
                txtCapNhatSoDienThoai.value = nhanvien.SoDienThoai
                txtCapNhatDiaChi.value = nhanvien.DiaChi
                txtCapNhatEmail.value = nhanvien.Email
                txtCapNhatGhiChu.value = nhanvien.GhiChu
                btnXacNhanCapNhat.value = this.value
            }
        })
    }
    function kiemTraThemTen(){
        if(txtThemTen.value.trim() === ''){
            messageErrorThemTen.innerHTML = 'Không được để trống'
            hopLeThemTen = false
        }
        else{
            messageErrorThemTen.innerHTML = ''
            hopLeThemTen = true
        }
    }
    function kiemTraThemNgaySinh(){
        if(txtThemNgaySinh.value.trim() === ''){
            messageErrorThemNgaySinh.innerHTML = 'Không được để trống'
            hopLeThemNgaySinh = false
        }
        else{
            messageErrorThemNgaySinh.innerHTML = ''
            hopLeThemNgaySinh = true
        }
    }
    function kiemTraThemSoDienThoai(){
        if(txtThemSoDienThoai.value === ''){
            messageErrorThemSoDienThoai.innerHTML = 'Không được để trống'
            hopLeThemSoDienThoai = false
        }
        else{
            if(txtThemSoDienThoai.value.length < 10){
                messageErrorThemSoDienThoai.innerHTML = 'Phải đủ 10 ký tự'
                hopLeThemSoDienThoai = false
            }
            else {
                if(listNhanVienGoc.find(nv => nv.SoDienThoai === txtThemSoDienThoai.value)){
                    messageErrorThemSoDienThoai.innerHTML = 'Số điện thoại này đã được sử dụng'
                    hopLeThemSoDienThoai = false
                }
                else{
                    messageErrorThemSoDienThoai.innerHTML = ''
                    hopLeThemSoDienThoai = true
                }
            }

        }
    }
    function kiemTraThemMatKhau(){
        if(txtThemMatKhau.value.trim() === ''){
            messageErrorThemMatKhau.innerHTML = 'Không được để trống'
            hopLeThemMatKhau = false
        }
        else{
            messageErrorThemMatKhau.innerHTML = ''
            hopLeThemMatKhau = true
        }
    }

    function kiemTraCapNhatTen(){
        if(txtCapNhatTen.value.trim() === ''){
            messageErrorCapNhatTen.innerHTML = 'Không được để trống'
            hopLeCapNhatTen = false
        }
        else{
            messageErrorCapNhatTen.innerHTML = ''
            hopLeCapNhatTen = true
        }
    }
    function kiemTraCapNhatNgaySinh(){
        if(txtCapNhatNgaySinh.value.trim() === ''){
            messageErrorCapNhatNgaySinh.innerHTML = 'Không được để trống'
            hopLeCapNhatNgaySinh = false
        }
        else{
            messageErrorCapNhatNgaySinh.innerHTML = ''
            hopLeCapNhatNgaySinh = true
        }
    }
    function kiemTraCapNhatSoDienThoai(){
        if(txtCapNhatSoDienThoai.value === ''){
            messageErrorCapNhatSoDienThoai.innerHTML = 'Không được để trống'
            hopLeCapNhatSoDienThoai = false
        }
        else{
            if(txtCapNhatSoDienThoai.value.length < 10){
                messageErrorCapNhatSoDienThoai.innerHTML = 'Phải đủ 10 ký tự'
                hopLeCapNhatSoDienThoai = false
            }
            else {
                let nhanvien = listNhanVienGoc.find(nv => nv.MaNhanVien === parseInt(maCapNhatNhanVien))
                
                if(listNhanVienGoc.find(nv => nv.SoDienThoai === txtCapNhatSoDienThoai.value)&& nhanvien.SoDienThoai !== txtCapNhatSoDienThoai.value){
                    messageErrorCapNhatSoDienThoai.innerHTML = 'Số điện thoại này đã được sử dụng'
                    hopLeCapNhatSoDienThoai = false
                }
                else{
                    messageErrorCapNhatSoDienThoai.innerHTML = ''
                    hopLeCapNhatSoDienThoai = true
                }
            }

        }
    }
    function kiemTraCapNhatEmail(){
        if(txtCapNhatEmail.value.trim() === ''){
            messageErrorCapNhatEmail.innerHTML = 'Không được để trống'
            hopLeCapNhatEmail = false
        }
        else{
            const emailPattern = /^[^\s@]+@gmail\.com$/;
            if (!emailPattern.test(txtCapNhatEmail.value)) {
                messageErrorCapNhatEmail.innerHTML = 'Email không hợp lệ, chỉ chấp nhận email @gmail.com';
                hopLeCapNhatEmail = false;
            }
            else{
                messageErrorCapNhatEmail.innerHTML = ''
                hopLeCapNhatEmail = true
            }
           
        }
    }
    function timKiemNhanVien(){
        if(txtTimKiem.value === ''){
            renderNhanVien(listNhanVienGoc)
        }
        else {
            let ds = []
            if(parseInt(comboboxTimkiem.value) === 1){

                listNhanVienGoc.forEach(function (nhanVien, index){
                    let maNhanVien = nhanVien.MaNhanVien + ''
                    if(txtTimKiem.value.length <= maNhanVien.length && maNhanVien.includes(txtTimKiem.value)){
                        ds.push(nhanVien)
                    }
                })
            }
            else {
                listNhanVienGoc.forEach(function (nhanVien, index){
                    let tenNhanVien = nhanVien.TenNhanVien + ''
                    if(txtTimKiem.value.length <= tenNhanVien.length && tenNhanVien.includes(txtTimKiem.value)){
                        ds.push(nhanVien)
                    }
                })
            }
            renderNhanVien(ds)

        }
    }

    async function themNhanVien(obj){
        try {
            const response = await fetch('./fetch/them-nhan-vien',{
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
                window.location.href = './nhan-vien'
            }
        }
        catch (error){
            console.error('Fetch error: ', error)
        }
    }
    async function capNhatNhanVien(obj){
        try {
            const response = await fetch('./fetch/cap-nhat-nhan-vien',{
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
                window.location.href = './nhan-vien'
            }
        }
        catch (error){
            console.error('Fetch error: ', error)
        }
    }

    btnThem.onclick = function(){
        kiemTraThemTen()
        kiemTraThemNgaySinh()
        kiemTraThemSoDienThoai()
        kiemTraThemMatKhau()
        if(hopLeThemTen && hopLeThemNgaySinh && hopLeThemSoDienThoai && hopLeThemMatKhau){
            let newNhanVien = {
                'TenNhanVien': txtThemTen.value,
                'NgaySinh': txtThemNgaySinh.value,
                'SoDienThoai': txtThemSoDienThoai.value,
                'MatKhau': txtThemMatKhau.value
            }
            themNhanVien(newNhanVien)
        }
    }
    btnXacNhanCapNhat.onclick = function(){
        kiemTraCapNhatTen()
        kiemTraCapNhatNgaySinh()
        kiemTraCapNhatSoDienThoai()
        kiemTraCapNhatEmail()
        if(hopLeCapNhatTen && hopLeCapNhatNgaySinh && hopLeCapNhatSoDienThoai && hopLeCapNhatEmail){
            let nhanVien = {
                'MaNhanVien': maCapNhatNhanVien,
                'TenNhanVien': txtCapNhatTen.value,
                'NgaySinh': txtCapNhatNgaySinh.value,
                'SoDienThoai': txtCapNhatSoDienThoai.value,
                'MatKhau': txtCapNhatMatKhau.value,
                'DiaChi': txtCapNhatDiaChi.value,
                'Email': txtCapNhatEmail.value,
                'GhiChu': txtCapNhatGhiChu.value,
            }
            capNhatNhanVien(nhanVien)
        }
    }

    txtThemSoDienThoai.oninput = function (){
        let start = this.selectionStart;
        let end = this.selectionEnd;

        // Loại bỏ các ký tự không phải là số
        let inputValue = this.value.replace(/[^0-9]/g, '');
        this.value = inputValue || ''
        this.setSelectionRange(start, end);
    }
    txtThemTen.oninput = function (){
        let start = this.selectionStart;
        let end = this.selectionEnd;

        // Loại bỏ các ký tự không phải là số
        this.value = this.value.replace(/[^\p{L}\s]/gu, '')
        this.setSelectionRange(start, end);
    }
    txtCapNhatSoDienThoai.oninput = function (){
        let start = this.selectionStart;
        let end = this.selectionEnd;

        // Loại bỏ các ký tự không phải là số
        let inputValue = this.value.replace(/[^0-9]/g, '');
        this.value = inputValue || ''
        this.setSelectionRange(start, end);
    }
    txtCapNhatTen.oninput = function (){
        let start = this.selectionStart;
        let end = this.selectionEnd;

        // Loại bỏ các ký tự không phải là số
        this.value = this.value.replace(/[^\p{L}\s]/gu, '')
        this.setSelectionRange(start, end);
    }

    txtTimKiem.oninput = function(){
        timKiemNhanVien()
    }
    comboboxTimkiem.onchange = function(){
        timKiemNhanVien()
    }
    try{
        const response = await fetch('./fetch/danh-sach-nhan-vien')
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        const data = await response.json()

        listNhanVienGoc = Array.from(data)
        renderNhanVien(listNhanVienGoc)
    }
    catch (error){
        console.log('Fetch error: ',error)
    }
})