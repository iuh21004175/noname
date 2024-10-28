document.addEventListener('DOMContentLoaded', async function () {
    let tableMenu = document.querySelector('#danhSachMA tbody');
    let tableListMon = document.querySelector('#danhSachMAnDH tbody')
    const txtSoDienThoai = document.querySelector('#txt-soDT')
    const eKMTD = document.querySelector('#khuyenMai-tichDiem')


    const khuyenMaiChuDe = document.querySelector('#khuyenMai')
    const txtTiLeKhuyenMai = document.querySelector('#txt-tiLeKhuyenMai')
    const txtTichDiem = document.querySelector('#txt-tichDiem')
    const txtSoTienKhachHang = document.querySelector('#txt-soTienKhachHang')
    const txtTinhTien = document.querySelector('#txt-tienThoi')
    const txtTimMon = document.querySelector('#txt-TimMon')

    const btnTaoDonHang = document.querySelector('#btn-taoDH')

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
                tableListMon = document.querySelector('#danhSachMAnDH tbody')
                let btnBoS = tableListMon.querySelectorAll('.btn-bo')
                const response = await fetch(`./fetch/dieu-kien-khuyen-mai-${btnBoS.length}`)
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                let data = await response.json()
                if(data !== null){
                    khuyenMaiChuDe.textContent = data.ChuDe
                    txtTiLeKhuyenMai.value = parseInt(parseFloat(data.PhanTram) * 100) + ' %'
                    maKhuyenMai = data.MaKhuyenMai
                    khuyenMai = parseFloat(data.PhanTram)

                }
                else {
                    maKhuyenMai = null
                    txtKhuyenMai.value = ''

                }
            }
            catch (error){
                console.error('Fetch error: ',error)
            }

        }
    }
    function tinhTongTien(){

        let btnBoS = tableListMon.querySelectorAll('.btn-bo')
        let tongTien = 0
        btnBoS.forEach(function (element, index){
            let soLuong = element.closest('tr').querySelector('.inputSL').value;
            let donGia = danhSachGoc.find(au => au.MaDoAnUong === element.value).Gia
            tongTien += parseInt(soLuong) * parseInt(donGia)
        })
        tongTienGoc = tongTien
        let giamGia = tichDiem * 1000 + khuyenMai * tongTienGoc

        tongTien = tongTienGoc - giamGia
        tongTienThucTe = tongTien
        eTongTien.value = parseInt(tongTien).toLocaleString('de-DE')
    }
    async function renderDanhSachMAnMenu(ds) {
        tableMenu.innerHTML = '';
        ds.forEach(function (doAnUong) {
            const srcIMG = doAnUong.HinhAnh === '' ? './public/assets/image/mon_default.png':`./public/assets/image/${doAnUong.HinhAnh}`
            const newRow = `<tr>
                                <td>
                                    <img src="${srcIMG}" alt="${doAnUong.Ten}" height="100">
                                    <input type="hidden" class="mon" value="${doAnUong.MaDoAnUong}">
                                </td>
                                <td class="align-middle">${doAnUong.Ten}</td>
                                <td class="align-middle">${parseInt(doAnUong.Gia).toLocaleString('de-DE')} <i class="fa-solid fa-dong-sign"></i></td>
                            </tr>`;
            tableMenu.innerHTML += newRow;
        });

        // Sau khi danh sách được render, gán sự kiện click cho từng dòng
        let rows = tableMenu.querySelectorAll('tr');
        rows.forEach(function (row) {
            row.onclick =  async function () {
                const mon = row.querySelector('.mon')
                let indexDoAnUong = ds.findIndex(item => item.MaDoAnUong === mon.value);
                let doAnUongDaXoa = ds.splice(indexDoAnUong, 1); // Lấy phần tử bị xóa
                await renderDanhSachMAnMenu(ds); // Render lại danh sách sau khi xóa
                await renderDanhSachMAnDH(doAnUongDaXoa[0])
                ktDonHang = true
                if(ktKhachHang && ktDonHang ) {
                    eKMTD.classList.remove('d-none')
                }
                else {
                    eKMTD.classList.add('d-none')
                }
                btnTaoDonHang.removeAttribute('disabled')
                await apDungKM()
                tinhTongTien()
            };
        });
        await apDungKM()
        tinhTongTien()
    }
    async function renderDanhSachMAnDH(doAnUong){
        const newRow = document.createElement('tr');
        let btnBoS = tableListMon.querySelectorAll('.btn-bo')
        newRow.style.cursor = 'pointer'
        newRow.innerHTML =  `
                            <td class="text-center align-middle">${btnBoS.length + 1}</td>
                            <td class="text-center align-middle">${doAnUong.Ten}</td>
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center">
                                    <div class="input-group justify-content-center" style="max-width: 120px;">
                                        <button type="button" class="btn btn-outline-secondary btn-sm btn-tru">
                                            <i class="fas fa-minus"></i> <!-- Icon dấu trừ -->
                                        </button>
                                        <input class="form-control text-center inputSL" type="text" value="1" style="max-width: 50px;">
                                        <button type="button" class="btn btn-outline-secondary btn-sm btn-cong">
                                            <i class="fas fa-plus"></i> <!-- Icon dấu cộng -->
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center align-middle">${doAnUong.DonVi}</td>
                            <td class="text-center align-middle">${parseInt(doAnUong.Gia).toLocaleString('de-DE')} <i class="fa-solid fa-dong-sign"></i></td>
                             <td class="text-center align-middle">
                                <textarea class="txt-ghiChu form-control"  rows="2"></textarea>
                            </td>
                            <td class="text-center align-middle">
                                <button type="button" value="${doAnUong.MaDoAnUong}" class="btn-bo btn btn-outline-danger">&times;</button>
                            </td>
                        `;
        tableListMon.appendChild(newRow);

        btnBoS = tableListMon.querySelectorAll('.btn-bo')
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
                btnBoS = tableListMon.querySelectorAll('.btn-bo')
                danhSachMAnMenu.push(...doAnUongDaXoa); // Chuyển món ăn bị xóa vào mảng khác
                danhSachMAnMenu.sort((a, b) => b.MaDoAnUong.localeCompare(a.MaDoAnUong))
                await renderDanhSachMAnMenu(danhSachMAnMenu)

                if(danhSachMAnMenu.length === danhSachGoc.length){
                    ktDonHang= false
                    btnTaoDonHang.setAttribute('disabled', true)

                }
                else {
                    btnTaoDonHang.removeAttribute('disabled')
                }
                if(ktKhachHang === true && ktDonHang === true) {
                    eKMTD.classList.remove('d-none')
                }
                else {
                    eKMTD.classList.add('d-none')
                    tichDiem = 0
                    txtTichDiem.value= tichDiem

                }
                await apDungKM()
                tinhTongTien()

            }
        })
        let eCongSL = tableListMon.querySelectorAll('.btn-cong')
        let eTruSL = tableListMon.querySelectorAll('.btn-tru')
        let eInputSL = tableListMon.querySelectorAll('.inputSL')


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
                eKH = `Họ và tên: ${data.TenKhachHang}</br>Tích điểm: ${data.TichDiem}`
                await apDungKM()
                tinhTongTien()
            }
            else {
                ktKhachHang=false
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
            ktKhachHang=false
        }

    }
    function timKiemMon(){
        if (txtTimMon.value === '') {
            renderDanhSachMAnMenu(danhSachMAnMenu);
        } else {
            let ds = [];
            let timKiem = txtTimMon.value.toLowerCase(); // Chuyển input tìm kiếm về chữ thường
    
            danhSachMAnMenu.forEach(function (mon, index) {
                let tenMon = mon.Ten.toLowerCase(); // Chuyển tên món ăn về chữ thường
                if (timKiem.length <= tenMon.length && tenMon.includes(timKiem)) {
                    ds.push(mon);
                }
            });
    
            renderDanhSachMAnMenu(ds);
        }
    }
    
    txtTimMon.oninput = function (){
        timKiemMon()
    }
    txtSoDienThoai.addEventListener('input', function (){
        let start = this.selectionStart;
        let end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9]/g, '');
        this.setSelectionRange(start, end);

        getKhachHang(this.value)

    })


    txtTichDiem.addEventListener('input', function () {
        if (ktKhachHang === true && ktDonHang === true) {
            let start = this.selectionStart;
            let end = this.selectionEnd;

            // Loại bỏ các ký tự không phải là số
            let inputValue = this.value.replace(/[^0-9]/g, '');

            // Chuyển giá trị thành số nguyên
            let numericValue = parseInt(inputValue, 10);

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
            txtTichDiem.value = 0
        }
    });
    
    btnTaoDonHang.onclick = async function (){
        let btnBoS = tableListMon.querySelectorAll('.btn-bo')
        let newObjDonHang = {
            'SoDienThoai' :txtSoDienThoai.value.length === 10 ? txtSoDienThoai.value : null,
            'TichDiem': txtTichDiem.value,
            'MaKhuyenMai': maKhuyenMai,
            'DanhSachDAU': [],
            'TongTien':tongTienThucTe
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
    txtSoTienKhachHang.oninput = function () {
        let start = this.selectionStart;
        let end = this.selectionEnd;

        // Loại bỏ các ký tự không phải là số hoặc dấu chấm
        let inputValue = this.value.replace(/[^0-9.]/g, '');

        // Chỉ cho phép một dấu chấm
        let parts = inputValue.split('.');
        if (parts.length > 2) {
            inputValue = parts[0] + '.' + parts.slice(1).join('');
        }

        // Định dạng lại với dấu chấm phân cách hàng nghìn
        let numberValue = parseFloat(inputValue.replace(/\./g, '').replace(/,/g, ''));
        if (!isNaN(numberValue)) {
            this.value = numberValue.toLocaleString('de-DE'); // Sử dụng định dạng với dấu chấm
        } else {
            this.value = '';
        }



        tinhTongTien();
        if (this.value === '') {
            txtTinhTien.value = '';
        } else {
            let tienThoi = numberValue - tongTienThucTe;
            txtTinhTien.value = tienThoi.toLocaleString('de-DE'); // Định dạng số tiền trả lại
        }
        // Cập nhật lại vị trí con trỏ
        this.setSelectionRange(start, end);
    };

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
