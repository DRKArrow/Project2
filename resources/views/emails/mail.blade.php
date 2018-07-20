<div align="center">
	<h3 align="center" style="color: red">Học viện CNTT Bách khoa thông báo khai giảng lớp {{$class}}</h3>
	<img src="http://www.bkacad.com/upload_images/Hoc%20vien/bach_khoa__bkacad_2_logo_bkacad.png" style="width: 100%;max-width: 400px;height: auto;" align="center">
	<h4 align="center">Ngày khai giảng: {{$date}}</h4>
	<hr>
</div>
<h3 style="font-weight: bold" align="center">Danh sách học viên: </h3>
<div style="width: 100%;margin: auto" align="center">
	<table cellpadding="0" cellspacing="0" width="100%" align="center" border="1px" style="font-family:Verdana,sans-serif;font-size:15px;line-height:1.5;border: 1px solid #ddd;text-align: left;text-decoration: none;width:100%!important">
		<thead>
			<tr>
				<th style="padding: 15px">STT</th>
				<th style="padding: 15px">Họ tên</th>
				<th style="padding: 15px">Email</th>
				<th style="padding: 15px">Số điện thoại</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1; ?>
			@foreach($students as $student)
				<tr>
					<td style="padding: 15px">{{$i}}</th>
					<td style="padding: 15px">{{$student->student_name}}</td>
					<td style="padding: 15px;text-decoration: none">{{$student->student_email}}</td>
					<td style="padding: 15px">{{$student->student_phone}}</td>
				</tr>
			<?php $i++;?>
			@endforeach
		</tbody>
	</table>
</div>
<hr>
<div>
	<b><span style="font-size:10.0pt;font-family:'Verdana';color:#31849b">Bachkhoa IT Academy (BKACAD)</span></b>
	<p class="MsoNormal" style="text-align:justify"><span style="font-size:9.0pt;font-family:'Verdana';color:#31849b">Hanoi University of Science Technology (HUST)<u></u><u></u></span></p>
	<p class="MsoNormal" style="text-align: justify;color: #31849b;font-size: 10.0pt;font-family: 'Verdana';">Đồ án thứ 2 của học viên.</p>
	<p class="MsoNormal" style="text-align: justify;color: #31849b;font-size: 12.0pt;font-family: 'Verdana';">Đinh Tuấn Dũng - BKC08K8</p>
</div>