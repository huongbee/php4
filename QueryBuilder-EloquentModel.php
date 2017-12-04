Truy vấn lọc dữ liệu
Yêu cầu: Thực hiện các câu truy vấn sau trên CSDL db_banhang

1. Liệt kê danh sách sản phẩm gồm có tên Tên sp, Mô tả,Đơn giá.

SELECT ten_mon, noi_dung_tom_tat, don_gia
FROM mon_an

2. Liệt kê danh sách sản phẩm gồm có tên Tên loại, Tên sp, Mô tả, Đơn giá và sắp xếp Tên loại theo chiều tăng dần.

SELECT l.ten_loai, ten_mon, noi_dung_tom_tat, don_gia
FROM mon_an m INNER JOIN loai_mon_an l ON m.ma_loai = l.ma_loai
ORDER BY l.ten_loai
 
3. Liệt kê danh sách khách hàng gồm có các thông tin sau: tên khách hàng, giới tính, địa chỉ, điện thoại, danh sách sẽ được sắp tăng dần theo tên khách hàng.

SELECT ten_khach_hang, phai, dia_chi, dien_thoai
FROM khach_hang
ORDER BY ten_khach_hang

4. Liệt kê danh sách sản phẩm gồm có: Tên sp, Mô tả, Đơn giá, và sắp xếp giảm theo cột đơn giá

SELECT ten_mon, noi_dung_tom_tat, don_gia
FROM mon_an
order by don_gia desc


5. Liệt kê danh sách sản phẩm gồm có: Tên sp, Mô tả, Đơn giá. Chỉ liệt kê các Sản phẩm bánh sầu riêng.

SELECT ten_mon, noi_dung_tom_tat, don_gia
FROM mon_an
where ten_mon like "%sầu riêng%"

6. Liệt kê danh sách sản phẩm mà trong tên sp có từ 'crepe'.

SELECT *
FROM mon_an
where ten_mon like "%crepe %" or ten_mon like "% crepe%"


7. Liệt kê danh sách các Sản phẩm có đơn giá từ 50.000 VNĐ đến 100.000 VNĐ

SELECT *
FROM mon_an
where don_gia between 50000 and 100000



9. Liệt kê các sản phẩm có đơn giá lớn hơn 1.500.000 VNĐ

SELECT *
FROM thuc_don
where don_gia > 1500000

10. Liệt kê thông tin các sản phẩm 'Smoke Chicken Pizza', 'Bánh Gato Trái cây Việt Quất', 'Bánh Táo - Mỹ'.

SELECT *
FROM mon_an
where ten_mon in ("Bánh canh", "Gà quay", "Súp ngô cua")



11. Cho biết tên sản phẩm, Mô tả, đơn giá của 10 sản phẩm có đơn giá cao nhất.

SELECT ten_mon, noi_dung_tom_tat, don_gia
FROM mon_an
order by don_gia desc
limit 0,10

12. Liệt kê danh sách sản phẩm gồm có tênsp, đơn giá, khuyến mãi.

SELECT ten_mon, don_gia, khuyen_mai
FROM mon_an

13. Liệt kê danh sách khách hàng gồm có các thông tin sau: tên khách hàng, email, địa chỉ, điện thoại.

SELECT ten_khach_hang, email, dia_chi, dien_thoai
FROM khach_hang



14. Liệt kê danh sách loại sản phẩm gồm có các thông tin sau: tên loại, mô tả, sắp tăng dần theo tên loại.

SELECT ten_loai, mo_ta
FROM loai_mon_an
order by ten_loai

15. Liệt kê danh sách sản phẩm gồm có: tên sản phẩm, Mô tả. Có sắp tăng theo cột tên sp, và sắp giảm theo cột đơn giá.
--------------------------------------------------------------------------
SELECT ten_mon, noi_dung_tom_tat, don_gia
FROM mon_an
order by ten_mon asc, don_gia desc

--------------------------------------------------------------------------

16. Liệt kê danh sách tin tức: tiêu đề, tóm tắt. Chỉ liệt kê các tin tức có tiêu đề bắt đầu là 'N'.

SELECT tieu_de, tom_tat
FROM tin_tuc
where tieu_de like "N%"

17. Liệt kê danh sách các sản phẩm có ký tự cuối cùng của sp ăn là 'n'.

SELECT *
FROM mon_an
where ten_mon like "n%"


18. Liệt kê danh sách sản phẩm mà trong tên sản phẩm có từ 'pizza'.

SELECT *
FROM mon_an
where ten_mon like "%gà %" or ten_mon like "% gà%"



20. Liệt kê danh sách các sản phẩm có đơn giá từ 50.000 VNĐ đến 150.000 VNĐ

SELECT *
FROM mon_an
where don_gia between 50000 and 150000

21. Liệt kê các sản phẩm có nội dung tóm tắt chứa 'nấm' và 'ớt xanh', gồm các thông tin: tên sp, đơn giá.

SELECT ten_mon, don_gia
FROM mon_an
where noi_dung_tom_tat like "%cà chua%" and noi_dung_tom_tat like "%dưa chuột%"



----------------------------------------------------------------------------------------------------------------------

2.2. Truy vấn có nhóm và thống kê dữ liệu
 Yêu cầu: Thực hiện các truy vấn sau

1. Thống kê tổng số sản phẩm theo Loại, gồm các thông tin: Tên Loại sản phẩm, tổng số sản phẩm, có sắp tăng theo tổng số sản phẩm

SELECT l.ten_loai, count(m.ma_mon) as tong_so_mon_an
FROM loai_mon_an l INNER JOIN mon_an m ON l.ma_loai = m.ma_loai
GROUP BY l.ma_loai
order by count(m.ma_mon)


2. Cho biết đơn giá trung bình của sản phẩm theo từng Loại sản phẩm.

SELECT m.ma_loai, ceiling(avg(don_gia)) as don_gia_trung_binh //ceiling(num_expr): Số nguyên lớn nhất lớn hơn hoặc bằng giá tri.
FROM loai_mon_an l INNER JOIN mon_an m ON l.ma_loai = m.ma_loai
GROUP BY l.ma_loai


3. Cho biết sản phẩm có đơn giá thấp nhất theo từng loại sản phẩm (làm tương tự cho lớn nhất).
--------MIN-----------------
SELECT l.ma_loai, m.ma_mon, m.ten_mon, min(m.don_gia) as don_gia_thap_nhat
FROM loai_mon_an l INNER JOIN mon_an m ON l.ma_loai = m.ma_loai
GROUP BY l.ma_loai
 

---------MAX------------------
SELECT l.ma_loai, m.ma_mon, m.ten_mon, max(m.don_gia) as don_gia_thap_nhat
FROM loai_mon_an l INNER JOIN mon_an m ON l.ma_loai = m.ma_loai
GROUP BY l.ma_loai

4. Cho biết tổng giá tiền và số sản phẩm của sản phẩm có đơn giá trong khoảng 50.000đ đến 100.000đ theo từng loại sản phẩm.

SELECT l.ma_loai, count(m.ma_mon) as so_mon_an, sum(m.don_gia) as tong_gia_tien
FROM loai_mon_an l INNER JOIN mon_an m ON l.ma_loai = m.ma_loai
where m.don_gia between 50000 and 100000
GROUP BY l.ma_loai
 
5. Thống kê hóa đơn gồm các thông tin sau: số hóa đơn, ngày đặt, tổng số sản phẩm, tổng thành tiền.

SELECT ct.ma_hoa_don,count(ct.ma_hoa_don) as so_hoa_don, hd.ngay_dat, sum(ct.so_luong) as tong_so_mon, sum(ct.don_gia) as thanh_tien
from chi_tiet_hoa_don ct INNER JOIN hoa_don hd ON ct.ma_hoa_don=hd.ma_hoa_don
group by ct.ma_hoa_don

6. Cho biết đơn giá trung bình sản phẩm thuộc loại sản phẩm là 'Bánh ngọt'.


SELECT l.ma_loai, l.ten_loai, ceiling(avg(m.don_gia)) as trung_binh
FROM loai_mon_an l INNER JOIN mon_an m ON l.ma_loai = m.ma_loai
group by m.ma_loai
having l.ten_loai like "Bún, mì, miến, phở"


