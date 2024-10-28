document.addEventListener('DOMContentLoaded', async function (){
    let listDoAnUongGoc = []
    const tableDoAnUong = document.querySelector('#table-doAnUong tbody')
    const btnThemDoAnDoUong = document.querySelector('#btn-themDoAnDoUong')
    const btnThem = document.querySelector('#btnThem')
    const btnXacNhanXoa = document.querySelector('#btn-xacNhanXoa')
    const btnXacNhanCapNhatDoAn = document.querySelector('#btn-CapNhatDoAn')
    const btnXacNhanCapNhatDoUong = document.querySelector('#btn-CapNhatDoUong')

    const messageDoAnUong = document.querySelector('#message-doAnUong')
    const messageXoa = document.querySelector('#message-xoa')
    const messageErrorThemTenDoAnDoUong = document.querySelector('#message-errorThemTenDoAnDoUong')
    const messageErrorThemGiaDoAnDoUong = document.querySelector('#message-errorThemGiaDoAnDoUong')

    const messageErrorCapNhatTenDoAn = document.querySelector('#message-errorCapNhatTenDoAn')
    const messageErrorCapNhatGiaDoAn = document.querySelector('#message-errorCapNhatGiaDoAn')
    const messageErrorCapNhatTenDoUong = document.querySelector('#message-errorCapNhatTenDoUong')
    const messageErrorCapNhatGiaDoUong = document.querySelector('#message-errorCapNhatGiaDoUong')

    const txtTimKiem = document.querySelector('#txt-timKiem')
    const txtThemTenDoAnDoUong = document.querySelector('#txt-ThemTenDoAnDoUong')
    const txtThemGiaDoAnDoUong = document.querySelector('#txt-ThemGiaDoAnDoUong')


    const txtCapNhatTenDoAn = document.querySelector('#txt-CapNhatTenDoAn')
    const txtCapNhatGiaDoAn = document.querySelector('#txt-CapNhatGiaDoAn')
    const txtCapNhatMoTaDoAn = document.querySelector('#txt-CapNhatMoTaDoAn')
    const txtCapNhatTenDoUong = document.querySelector('#txt-CapNhatTenDoUong')
    const txtCapNhatGiaDoUong = document.querySelector('#txt-CapNhatGiaDoUong')
    const txtCapNhatMoTaDoUong = document.querySelector('#txt-CapNhatMoTaDoUong')

    const comboboxThemDonViDoAnDoUong = document.querySelector('#combobox-ThemDonViDoAnDoUong')
    const comboboxThemLoaiDoAnDoUong = document.querySelector('#combobox-ThemLoaiDoAnDoUong')
    const comboboxCapNhatDonViDoAn = document.querySelector('#combobox-CapNhatDonViDoAn')
    const comboboxCapNhatDonViDoUong = document.querySelector('#combobox-CapNhatDonViDoUong')
    const comboboxCapNhatTrangThaiDoAn = document.querySelector('#combobox-CapNhatTrangThaiDoAn')
    const comboboxCapNhatTrangThaiDoUong = document.querySelector('#combobox-CapNhatTrangThaiDoUong')
    const comboboxDanhSachTuTrangThai = document.querySelector('#combobox-danhSachTuTrangThai')

    const fileThemDoAnUong = document.querySelector('#file-ThemAnhDoAnDoUong')
    const fileCapNhatDoAn = document.querySelector('#file-CapNhatAnhDoAn')
    const fileCapNhatDoUong = document.querySelector('#file-CapNhatAnhDoUong')

    const imgCapNhatDoAn = document.querySelector('#img-CapNhatDoAnPreview')
    const imgCapNhatDoUong = document.querySelector('#img-CapNhatDoUongPreview')

    let hopLeThemTenDoAnDoUong = false
    let hopLeThemGiaDoAnDoUong = false

    let hopLeCapNhatTenDoAn = false
    let hopLeCapNhatGiaDoAn = false
    let hopLeCapNhatTenDoUong = false
    let hopLeCapNhatGiaDoUong = false

    function renderDoAnUong(list){
        tableDoAnUong.innerHTML = ''
        if(list.length > 0){
            messageDoAnUong.classList.add('d-none')
            list.forEach(function (doAnUong, index){
                let newRow = document.createElement('tr');
                let capNhatButton = '';
                let xoaButton = '';

                // Kiểm tra loại và chọn nút cập nhật phù hợp
                if (doAnUong.Loai === 'Đồ ăn') {
                    capNhatButton = `<button class="btn btn-outline-primary btn-capNhatDoAn" data-bs-toggle="modal" data-bs-target="#form-capNhatDoAn" value="${doAnUong.MaDoAnUong}">Cập nhật</button>`;
                } else if (doAnUong.Loai === 'Đồ uống') {
                    capNhatButton = `<button class="btn btn-outline-primary btn-capNhatDoUong" data-bs-toggle="modal" data-bs-target="#form-capNhatDoUong" value="${doAnUong.MaDoAnUong}">Cập nhật</button>`;
                }
                if(doAnUong.TrangThai !==1){
                    xoaButton = `<button class="btn btn-outline-danger btn-xoa" data-bs-toggle="modal" data-bs-target="#message-xoa" value="${doAnUong.MaDoAnUong}">Xóa</button>`;
                }
                newRow.innerHTML = `
                    <td class="align-middle text-center">${index + 1}</td>
                    <td class="align-middle"><img src="${doAnUong.HinhAnh === '' ? './public/assets/image/mon_default.png':'./public/assets/image/'+doAnUong.HinhAnh}" alt="${doAnUong.Ten}" height="100"></td>
                    <td class="align-middle">${doAnUong.MaDoAnUong}</td>
                    <td class="align-middle">${doAnUong.Ten}</td>
                    <td class="align-middle">${parseInt(doAnUong.Gia).toLocaleString('de-DE')} <i class="fa-solid fa-dong-sign"></i></td>
                    <td class="align-middle">${doAnUong.Loai}</td>
                    <td class="align-middle">${doAnUong.DonVi}</td>
                    <td class="align-middle">
                        <a href="./thuc-don-chi-tiet-${doAnUong.MaDoAnUong}" class="btn btn-light">Xem</a>
                        ${xoaButton}
                        ${capNhatButton}
                    </td>
                `;

                tableDoAnUong.appendChild(newRow);
            })


        }
        else{
            messageDoAnUong.classList.remove('d-none')
        }

        const btnXoaS = document.querySelectorAll('.btn-xoa')
        btnXoaS.forEach(function (btn, index){
            btn.onclick = function (){
                let doAnUong = listDoAnUongGoc.find(au => au.MaDoAnUong === this.value)
                btnXacNhanXoa.value = this.value

                messageXoa.querySelector('.modal-body').innerHTML = `Bạn có muốn xóa ${doAnUong.Loai} có mã là ${this.value} không ?`
            }
        })
        btnXacNhanXoa.onclick = async function (){
            try {
                const response = await fetch('./fetch/xoa-do-an-uong', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body:JSON.stringify({'MaDoAnUong':this.value})
                })
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                const data = await response.json()
                if(data.status === 'success'){
                    window.location.href = './thuc-don'
                }
                else {
                    alert(data.message)
                }
            }
            catch (error){
                console.error('Fetch error: ', error)
            }

        }
        const btnCapNhatDoAn = document.querySelectorAll('.btn-capNhatDoAn')
        btnCapNhatDoAn.forEach(function (btn, index){
            btn.onclick = function (){
                const doAnUong = listDoAnUongGoc.find(au => au.MaDoAnUong === this.value)
                txtCapNhatTenDoAn.value = doAnUong.Ten
                if(doAnUong.TrangThai === 1){
                    txtCapNhatGiaDoAn.setAttribute('disabled', true)
                }
                else{
                    txtCapNhatGiaDoAn.removeAttribute('disabled')
                }
                txtCapNhatGiaDoAn.value = doAnUong.Gia
                txtCapNhatMoTaDoAn.value = doAnUong.MoTa
                comboboxCapNhatDonViDoAn.value = doAnUong.DonVi
                comboboxCapNhatTrangThaiDoAn.value = doAnUong.TrangThai
                btnXacNhanCapNhatDoAn.value = doAnUong.MaDoAnUong
                imgCapNhatDoAn.src = doAnUong.HinhAnh === '' ? './public/assets/image/mon_default.png':`./public/assets/image/${doAnUong.HinhAnh}`
            }
        })
        const btnCapNhatDoUong = document.querySelectorAll('.btn-capNhatDoUong')
        btnCapNhatDoUong.forEach(function (btn, index){
            btn.onclick = function (){
                const doAnUong = listDoAnUongGoc.find(au => au.MaDoAnUong === this.value)
                txtCapNhatTenDoUong.value = doAnUong.Ten
                if(doAnUong.TrangThai === 1){
                    txtCapNhatGiaDoUong.setAttribute('disabled', true)
                }
                else{
                    txtCapNhatGiaDoUong.removeAttribute('disabled')
                }
                txtCapNhatGiaDoUong.value = doAnUong.Gia
                txtCapNhatMoTaDoUong.value = doAnUong.MoTa
                comboboxCapNhatDonViDoUong.value = doAnUong.DonVi
                comboboxCapNhatTrangThaiDoUong.value = doAnUong.TrangThai
                btnXacNhanCapNhatDoUong.value = doAnUong.MaDoAnUong
                imgCapNhatDoUong.src = doAnUong.HinhAnh === '' ? './public/assets/image/mon_default.png':`./public/assets/image/${doAnUong.HinhAnh}`
            }
        })
    }
    function kiemTraThemTenDoAnDoUong(){
        if(txtThemTenDoAnDoUong.value === ''){
            hopLeThemTenDoAnDoUong = false
            messageErrorThemTenDoAnDoUong.innerHTML = 'Không được để trống'
        }
        else{
            hopLeThemTenDoAnDoUong = true
            messageErrorThemTenDoAnDoUong.innerHTML = ''
        }
    }
    function kiemTraThemGiaDoAnDoUong(){
        if(txtThemGiaDoAnDoUong.value === ''){
            hopLeThemGiaDoAnDoUong = false
            messageErrorThemGiaDoAnDoUong.innerHTML = 'Không được để trống'
        }
        else{
            if(parseInt(txtThemGiaDoAnDoUong.value) % 1000 === 0){
                hopLeThemGiaDoAnDoUong = true
                messageErrorThemGiaDoAnDoUong.innerHTML = ''
            }
            else{
                hopLeThemGiaDoAnDoUong = false
                messageErrorThemGiaDoAnDoUong.innerHTML = 'Giá bán phải tròn nghìn'
            }
        }
    }
    function kiemTraCapNhatTenDoAn(){
        if(txtCapNhatTenDoAn.value === ''){
            hopLeCapNhatTenDoAn = false
            messageErrorCapNhatTenDoAn.innerHTML = 'Không được để trống'
        }
        else{
            hopLeCapNhatTenDoAn = true
            messageErrorCapNhatTenDoAn.innerHTML = ''
        }
    }
    function kiemTraCapNhatGiaDoAn(){
        if(txtCapNhatGiaDoAn.value === ''){
            hopLeCapNhatGiaDoAn = false
            messageErrorCapNhatGiaDoAn.innerHTML = 'Không được để trống'
        }
        else{
            if(parseInt(txtCapNhatGiaDoAn.value) % 1000 === 0){
                hopLeCapNhatGiaDoAn = true
                messageErrorCapNhatGiaDoAn.innerHTML = ''
            }
            else{
                hopLeCapNhatGiaDoAn = false
                messageErrorCapNhatGiaDoAn.innerHTML = 'Giá đồ ăn phải tròn nghìn'
            }
        }
    }
    function kiemTraCapNhatTenDoUong(){
        if(txtCapNhatTenDoUong.value === ''){
            hopLeCapNhatTenDoUong = false
            messageErrorCapNhatTenDoUong.innerHTML = 'Không được để trống'
        }
        else{
            hopLeCapNhatTenDoUong = true
            messageErrorCapNhatTenDoUong.innerHTML = ''
        }
    }
    function kiemTraCapNhatGiaDoUong(){
        if(txtCapNhatGiaDoUong.value === ''){
            hopLeCapNhatGiaDoUong = false
            messageErrorCapNhatGiaDoUong.innerHTML = 'Không được để trống'
        }
        else{
            if(parseInt(txtCapNhatGiaDoUong.value) % 1000 === 0){
                hopLeCapNhatGiaDoUong = true
                messageErrorCapNhatGiaDoUong.innerHTML = ''
            }
            else{
                hopLeCapNhatGiaDoUong = false
                messageErrorCapNhatGiaDoUong.innerHTML = 'Giá đồ uống phải tròn nghìn'
            }
        }
    }
    function timKiemDoAnUong(){
        if(txtTimKiem.value === ''){
            renderDoAnUong(listDoAnUongGoc)
        }
        else{
            let ds = []
            listDoAnUongGoc.forEach(function (doAnUong, index) {
                let ten = doAnUong.Ten + ''
                if (txtTimKiem.value.length <= ten.length && ten.includes(txtTimKiem.value)) {
                    ds.push(doAnUong)
                }
            })
            renderDoAnUong(ds)
        }
    }
    async function themDoAnUong(formData){
        try {
            const response = await fetch('./fetch/them-do-an-uong',{
                method: 'POST',
                body: formData
            })
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            const data = await response.json()
            if(data.status === 'success'){
                window.location.href = './thuc-don'
            }
            else{
                alert(data.message)
            }
        }
        catch (error){
            console.error('Fetch error: ', error)
        }
    }
    async function capNhatDoAnUong(formData){
        try {
            const response = await fetch('./fetch/cap-nhat-do-an-uong',{
                method: 'POST',
                body: formData
            })
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            const data = await response.json()
            console.log(data)
            if(data.status === 'success'){
                if(data.message !== undefined){
                    alert(data.message)
                }
                window.location.href = './thuc-don'
            }
            else {
                alert(data.message)
            }
        }
        catch (error){
            console.error('Fetch error: ', error)
        }
    }
    function hienThiAnhThem() {
        const imgPreview = document.getElementById('img-ThemPreview');

        // Kiểm tra xem người dùng đã chọn file hay chưa
        if (fileThemDoAnUong.files && fileThemDoAnUong.files[0]) {
            const reader = new FileReader();

            // Khi file được đọc thành công
            reader.onload = function(e) {
                // Cập nhật src của img để hiển thị ảnh
                imgPreview.src = e.target.result;
            }

            // Đọc file dưới dạng DataURL (base64)
            reader.readAsDataURL(fileThemDoAnUong.files[0]);
        }
    }
    function hienThiAnhDoAnCapNhat() {

        // Kiểm tra xem người dùng đã chọn file hay chưa
        if (fileCapNhatDoAn.files && fileCapNhatDoAn.files[0]) {
            const reader = new FileReader();

            // Khi file được đọc thành công
            reader.onload = function(e) {
                // Cập nhật src của img để hiển thị ảnh
                imgCapNhatDoAn.src = e.target.result;
            }

            // Đọc file dưới dạng DataURL (base64)
            reader.readAsDataURL(fileCapNhatDoAn.files[0]);
        }
    }
    function hienThiAnhDoUongCapNhat() {

        // Kiểm tra xem người dùng đã chọn file hay chưa
        if (fileCapNhatDoUong.files && fileCapNhatDoUong.files[0]) {
            const reader = new FileReader();

            // Khi file được đọc thành công
            reader.onload = function(e) {
                // Cập nhật src của img để hiển thị ảnh
                imgCapNhatDoUong.src = e.target.result;
            }

            // Đọc file dưới dạng DataURL (base64)
            reader.readAsDataURL(fileCapNhatDoUong.files[0]);
        }
    }
    fileThemDoAnUong.onchange = function(){
        hienThiAnhThem()
    }
    fileCapNhatDoAn.onchange = function(){
        hienThiAnhDoAnCapNhat()
    }
    fileCapNhatDoUong.onchange = function (){
        hienThiAnhDoUongCapNhat()
    }
    btnThemDoAnDoUong.onclick = function (){
        kiemTraThemTenDoAnDoUong()
        kiemTraThemGiaDoAnDoUong()
        if(hopLeThemTenDoAnDoUong && hopLeThemGiaDoAnDoUong){
            const formData = new FormData()
            let newDoAnDoUong = {
                'Ten': txtThemTenDoAnDoUong.value,
                'Gia': txtThemGiaDoAnDoUong.value,
                'DonVi': comboboxThemDonViDoAnDoUong.value,
                'Loai': comboboxThemLoaiDoAnDoUong.value
            }
            let file = fileThemDoAnUong.files[0]
            formData.append('file', file)
            formData.append('data', JSON.stringify(newDoAnDoUong))
            themDoAnUong(formData)
        }
    }
    btnXacNhanCapNhatDoAn.onclick = function (){
        kiemTraCapNhatTenDoAn()
        kiemTraCapNhatGiaDoAn()
        if(hopLeCapNhatTenDoAn && hopLeCapNhatGiaDoAn){
            let formData = new FormData()
            let doAn = {
                'MaDoAnUong': this.value,
                'Ten': txtCapNhatTenDoAn.value,
                'Gia': txtCapNhatGiaDoAn.value,
                'DonVi': comboboxCapNhatDonViDoAn.value,
                'MoTa': txtCapNhatMoTaDoAn.value,
                'TrangThai': comboboxCapNhatTrangThaiDoAn.value
            }
            formData.append('file', fileCapNhatDoAn.files[0])
            formData.append('data', JSON.stringify(doAn))
            capNhatDoAnUong(formData)
        }
    }
    btnXacNhanCapNhatDoUong.onclick = function (){
        kiemTraCapNhatTenDoUong()
        kiemTraCapNhatGiaDoUong()
        if(hopLeCapNhatTenDoUong && hopLeCapNhatGiaDoUong){
            let formData = new FormData()
            let doUong = {
                'MaDoAnUong': this.value,
                'Ten': txtCapNhatTenDoUong.value,
                'Gia': txtCapNhatGiaDoUong.value,
                'DonVi': comboboxCapNhatDonViDoUong.value,
                'MoTa': txtCapNhatMoTaDoUong.value,
                'TrangThai': comboboxCapNhatTrangThaiDoUong.value
            }
            formData.append('file', fileCapNhatDoUong.files[0])
            formData.append('data', JSON.stringify(doUong))
            capNhatDoAnUong(formData)
        }
    }
    function thayDoiDonVi(){
        if(comboboxThemLoaiDoAnDoUong.value === 'Đồ ăn'){
            let newOption = `
                <option value="đĩa">đĩa</option>
                <option value="bát">bát</option>
            `;
            comboboxThemDonViDoAnDoUong.innerHTML = newOption
        }
        else  if(comboboxThemLoaiDoAnDoUong.value === 'Đồ uống'){
            let newOption = `
                <option value="ly">ly</option>
                <option value="chai">chai</option>
                <option value="lon">lon</option>
            `
            comboboxThemDonViDoAnDoUong.innerHTML = newOption
        }
    }
    btnThem.onclick = function (){
        thayDoiDonVi()
    }
    comboboxThemLoaiDoAnDoUong.onchange = function (){
        thayDoiDonVi()
    }
    txtThemGiaDoAnDoUong.oninput = function (){
        let start = this.selectionStart;
        let end = this.selectionEnd;
    
        // Loại bỏ các ký tự không phải là số
        let inputValue = this.value.replace(/[^0-9]/g, '');
        this.value = inputValue || ''
        this.setSelectionRange(start, end);
    }
    txtCapNhatGiaDoAn.oninput = function (){
        let start = this.selectionStart;
        let end = this.selectionEnd;
    
        // Loại bỏ các ký tự không phải là số
        let inputValue = this.value.replace(/[^0-9]/g, '');
        this.value = inputValue || ''
        this.setSelectionRange(start, end);
    }
    
    txtCapNhatGiaDoUong.oninput = function (){
        let start = this.selectionStart;
        let end = this.selectionEnd;
    
        // Loại bỏ các ký tự không phải là số
        let inputValue = this.value.replace(/[^0-9]/g, '');
        this.value = inputValue || ''
        this.setSelectionRange(start, end);
    }
    txtTimKiem.oninput = function (){
        timKiemDoAnUong()
    }
    comboboxDanhSachTuTrangThai.onchange = async function (){
        try{
            const response = await fetch(`./fetch/danh-sach-do-an-uong-theo-trang-thai-${this.value}`)
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            const data = await response.json()
            listDoAnUongGoc = []
            if(data != null){
                listDoAnUongGoc = Array.from(data)
                renderDoAnUong(listDoAnUongGoc)
            }
        }
        catch (error){
            console.log('Fetch error: ',error)
        }
    }
    try{
        const response = await fetch(`./fetch/danh-sach-do-an-uong-theo-trang-thai-${comboboxDanhSachTuTrangThai.value}`)
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        const data = await response.json()
        listDoAnUongGoc = []
        if(data != null){
            listDoAnUongGoc = Array.from(data)
            renderDoAnUong(listDoAnUongGoc)
        }
    }
    catch (error){
        console.log('Fetch error: ',error)
    }

})