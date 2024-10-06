document.addEventListener('DOMContentLoaded', async function () {
    let eBangDanhSachMAnMenu = document.querySelector('#danhSachMA tbody');
    let eBangDanhSachMAnDH = document.querySelector('#danhSachMAnDH tbody')
    const eTxtSoDT = document.querySelector('#txt-soDT')
    const eKMTD = document.querySelector('#khuyenMai-tichDiem')
    const txtKM = document.querySelector('#txt-khuyenMai')
    const eTxtTichDiem = document.querySelector('#txt-tichDiem')
    const btnTaoDH = document.querySelector('#btn-taoDH')
    const txtSoTienKhachHang = document.querySelector('#txt-soTienKhachHang')
    const txtTinhTien = document.querySelector('#txt-tienThoi')

    let danhSachMAnMenu = []
    let danhSachGoc = [];
    let eTongTien = document.querySelector('.tongTienDH')
    let tichDiem = 0
    let khuyenMai = 0
    let maKhuyenMai = null
    let tongTienGoc = 0
    let tongTienThucTe = 0
    let tichDiemKH = 0
    let ktKhachHang = false
    let ktDonHang = false
    async function apDungKM(){
        if(ktKhachHang){
            try {
                eBangDanhSachMAnDH = document.querySelector('#danhSachMAnDH tbody')
                let btnBoS = eBangDanhSachMAnDH.querySelectorAll('.btn-bo')
                const response = await fetch(`./fetch/dieu-kien-khuyen-mai-${btnBoS.length}`)
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                let data = await response.json()
                if(data !== null){
                    txtKM.value = data.ChuDe
                    maKhuyenMai = data.MaKhuyenMai
                    khuyenMai = parseFloat(data.PhanTram)

                }
                else {
                    maKhuyenMai = null
                    txtKM.value = ''

                }
            }
            catch (error){
                console.error('Fetch error: ',error)
            }

        }
    }
    function tinhTongTien(){

        let btnBoS = eBangDanhSachMAnDH.querySelectorAll('.btn-bo')
        let tongTien = 0
        btnBoS.forEach(function (element, index){
            let soLuong = element.closest('tr').querySelector('.inputSL').value;
            let donGia = element.closest('tr').querySelector('.giaMA')
            donGia = donGia.textContent
            tongTien += parseInt(soLuong) * parseInt(donGia)
        })
        tongTienGoc = tongTien
        let giamGia = tichDiem * 1000 + khuyenMai * tongTienGoc

        tongTien = tongTienGoc - giamGia
        tongTienThucTe = tongTien
        eTongTien.value = tongTien
    }
    async function renderDanhSachMAnMenu(ds) {
        eBangDanhSachMAnMenu.innerHTML = '';
        ds.forEach(function (doAnUong) {
            const newRow = `<tr>
                                <td>${doAnUong.Ten}</td>
                                <td>${doAnUong.Gia}</td>
                                <td><button type="button" value="${doAnUong.MaDoAnUong}">Chọn</button></td>
                            </tr>`;
            eBangDanhSachMAnMenu.innerHTML += newRow;
        });

        // Sau khi danh sách được render, gán sự kiện click cho từng dòng
        let eMonAnMenus = eBangDanhSachMAnMenu.querySelectorAll('button');
        eMonAnMenus.forEach(function (element) {
            element.onclick = function () {
                let indexDoAnUong = ds.findIndex(item => item.MaDoAnUong === element.value);
                let doAnUongDaXoa = ds.splice(indexDoAnUong, 1); // Lấy phần tử bị xóa
                renderDanhSachMAnMenu(ds); // Render lại danh sách sau khi xóa
                renderDanhSachMAnDH(doAnUongDaXoa[0])
                ktDonHang = true
                if(ktKhachHang && ktDonHang ) {
                    eKMTD.classList.remove('d-none')
                }
                else {
                    eKMTD.classList.add('d-none')
                }
                btnTaoDH.removeAttribute('disabled')
                tinhTongTien()
            };
        });
        await apDungKM()
        tinhTongTien()
    }
    async function renderDanhSachMAnDH(doAnUong){
        const newRow = document.createElement('tr');
        let btnBoS = eBangDanhSachMAnDH.querySelectorAll('.btn-bo')
        newRow.style.cursor = 'pointer'
        newRow.innerHTML =  `
                            <td>${btnBoS.length + 1}</td>
                            <td>${doAnUong.Ten}</td>
                            <td>
                                <div class="input-group">
                                    <button type="button" class="btn-tru">-</button>
                                    <input class="inputSL" type="text" value="1" style="width: 50px">
                                    <button type="button" class="btn-cong">+</button>
                                </div>
                            </td>
                           
                            <td>${doAnUong.DonVi}</td>
                            <td class="giaMA">${doAnUong.Gia}</td>
                             <td>
                                <textarea class="txt-ghiChu form-control"  rows="2"></textarea>
                            </td>
                            <td>
                                <button type="button" value="${doAnUong.MaDoAnUong}" class="btn-bo">Chọn</button>
                            </td>
                        `;
        eBangDanhSachMAnDH.appendChild(newRow);

        btnBoS = eBangDanhSachMAnDH.querySelectorAll('.btn-bo')
        btnBoS.forEach(function (element, index){
            element.onclick = async function (){
                let indexDoAnUong = danhSachGoc.findIndex(item => item.MaDoAnUong === element.value);
                let danhSachCopy = Array.from(danhSachGoc)
                let doAnUongDaXoa = danhSachCopy.splice(indexDoAnUong, 1); // Lấy phần tử bị xóa


                let row = this.closest('tr');
                // Kiểm tra và xóa thẻ <tr>
                if (row) {
                    row.remove(); // Xóa thẻ <tr> khỏi DOM
                }
                btnBoS = eBangDanhSachMAnDH.querySelectorAll('.btn-bo')
                danhSachMAnMenu.push(...doAnUongDaXoa); // Chuyển món ăn bị xóa vào mảng khác
                renderDanhSachMAnMenu(danhSachMAnMenu)

                if(danhSachMAnMenu.length === danhSachGoc.length){
                    ktDonHang= false
                    btnTaoDH.setAttribute('disabled', true)

                }
                else {
                    btnTaoDH.removeAttribute('disabled')
                }
                if(ktKhachHang === true && ktDonHang === true) {
                    eKMTD.classList.remove('d-none')
                }
                else {
                    eKMTD.classList.add('d-none')
                    tichDiem = 0
                    eTxtTichDiem.value= tichDiem

                }
                tinhTongTien()

            }
        })
        let eCongSL = eBangDanhSachMAnDH.querySelectorAll('.btn-cong')
        let eTruSL = eBangDanhSachMAnDH.querySelectorAll('.btn-tru')
        let eInputSL = eBangDanhSachMAnDH.querySelectorAll('.inputSL')


        eCongSL.forEach(function (elementC, index){
            elementC.onclick = function (){
                elementC.previousElementSibling.value = parseInt(elementC.previousElementSibling.value) + 1
                tinhTongTien()
            }


        })
        eTruSL.forEach(function (elementT, index){
            elementT.onclick = function (){
                if(parseInt(elementT.nextElementSibling.value) > 1){
                    elementT.nextElementSibling.value = parseInt(elementT.nextElementSibling.value) - 1
                }
                tinhTongTien()

            }
        })
        eInputSL.forEach(function (elementIN, index){
            elementIN.oninput = function (){
                this.value = parseInt(this.value)
                let start = this.selectionStart;
                let end = this.selectionEnd;
                this.value = this.value.replace(/[^0-9]/g, '');
                this.setSelectionRange(start, end);
                if(parseInt(elementIN.value) <= 0 || elementIN.value ===''){
                    elementIN.value = 1
                }

            }
        })

        await apDungKM()
        tinhTongTien()
    }
    async function getKhachHang(soDienThoai){
        const eThongTinKH = document.querySelector('#thongTinKH')
        let eKH = 'Số điện thoại chưa đăng ký'


        if(soDienThoai.length === 10){
            const response = await fetch(`./fetch/so-dien-thoai-khach-hang-${soDienThoai}`)

            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            let data = await response.json();

            if(data !== null){
                ktKhachHang = true
                tichDiemKH = data.TichDiem
                eKH = `Họ và tên: ${data.TenKhachHang}</br>Tích điển: ${data.TichDiem}`
                await apDungKM()
                tinhTongTien()
            }
            else {
                eKMTD.classList.add('d-none')
            }

            if(ktKhachHang === true && ktDonHang === true){
                eKMTD.classList.remove('d-none')

            }

            eThongTinKH.innerHTML = eKH
        }
        else{
            eThongTinKH.innerHTML = ''
            eKMTD.classList.add('d-none')
        }

    }

    eTxtSoDT.addEventListener('input', function (){
        let start = this.selectionStart;
        let end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9]/g, '');
        this.setSelectionRange(start, end);

        getKhachHang(this.value)

    })


    eTxtTichDiem.addEventListener('input', function () {
        if (ktKhachHang === true && ktDonHang === true) {
            let start = this.selectionStart;
            let end = this.selectionEnd;

            // Loại bỏ các ký tự không phải là số
            let inputValue = this.value.replace(/[^0-9]/g, '');

            // Chuyển giá trị thành số nguyên
            let numericValue = parseInt(inputValue, 10);

            // Kiểm tra nếu giá trị lớn hơn 100 thì đặt lại về giá trị trước đó
            if (numericValue > 100) {
                numericValue = 100;
            }
            if(numericValue * 1000 > (tongTienGoc - tongTienGoc*khuyenMai)){

                numericValue = (tongTienGoc - tongTienGoc*khuyenMai) / 1000

            }
            if (numericValue > tichDiemKH){
                numericValue = tichDiemKH
            }

            // Cập nhật giá trị vào input
            this.value = numericValue || 0;  // Nếu là NaN, đặt về chuỗi rỗng

            // Cập nhật lại vị trí con trỏ
            this.setSelectionRange(start, end);

            // Cập nhật giá trị tichDiem
            tichDiem = numericValue || 0;  // Nếu là NaN, đặt về 0

            // Gọi hàm tính tổng tiền
            tinhTongTien();
        }
        else {
            eTxtTichDiem.value = 0
        }
    });

    btnTaoDH.onclick = async function (){
        let btnBoS = eBangDanhSachMAnDH.querySelectorAll('.btn-bo')
        let newObjDonHang = {
            'SoDienThoai' :eTxtSoDT.value.length === 10 ? eTxtSoDT.value : null,
            'TichDiem': eTxtTichDiem.value,
            'MaKhuyenMai': maKhuyenMai,
            'DanhSachDAU': [],
            'TongTien':eTongTien.value
        }
        btnBoS.forEach(function (element){
            let soLuong = element.closest('tr').querySelector('.inputSL').value;
            let ghiChu = element.closest('tr').querySelector('.txt-ghiChu').value
            newObjDonHang.DanhSachDAU.push({'MaDoAnUong': element.value, 'SoLuong': soLuong, 'GhiChu': ghiChu})
        })
        try {
            let response = await fetch('./fetch/them-don-hang',{
                method: 'POST',
                headers: {
                    'Content-type': 'application/json'
                },
                body: JSON.stringify(newObjDonHang)
            })
            // Kiểm tra mã trạng thái HTTP
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }

            // Lấy dữ liệu phản hồi từ server
            let data = await response.json();
            if(data.status === 'success'){
                window.location.href = './don-hang'
            }
        }
        catch (error){
            console.log('Fetch error: ', error)
        }
    }
    txtSoTienKhachHang.oninput = function (){
        let start = this.selectionStart;
        let end = this.selectionEnd;

        // Loại bỏ các ký tự không phải là số
        let inputValue = this.value.replace(/[^0-9]/g, '');
        this.value = inputValue || '';  // Nếu là NaN, đặt về chuỗi rỗng
        // Cập nhật lại vị trí con trỏ
        this.setSelectionRange(start, end);
        tinhTongTien();
        if(this.value === ''){
            txtTinhTien.value = ''
        }
        else {
            let tienThoi = parseInt(this.value) - tongTienThucTe
            txtTinhTien.value = tienThoi
        }
    }

    try {
        let response = await fetch('./fetch/danh-sach-do-an-uong');
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        let data = await response.json();

        danhSachMAnMenu.push(...data);
        danhSachGoc.push(...data)


        if (danhSachMAnMenu.length > 0) {
            renderDanhSachMAnMenu(danhSachMAnMenu);
        }
    } catch (error) {
        console.error('Fetch error: ', error);
    }
});
