<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - TTC System</title>
    <link rel="stylesheet" href="../../public/assets/css/style.css">
</head>
<body>

<div class="page-wrapper">
    <div class="login-card">
        <h1 class="title">ตั้งรหัสผ่านใหม่</h1>
        <p class="subtitle">เพื่อความปลอดภัย กรุณาเปลี่ยนรหัสผ่านครั้งแรกก่อนเข้าใช้งาน</p>

        <div id="alert" class="alert"></div>

        <form id="changePasswordForm" class="login-form">
            <div class="form-group">
                <label for="new_password">รหัสผ่านใหม่ (New Password)</label>
                <input type="password" id="new_password" name="new_password" 
                       placeholder="ระบุรหัสผ่านใหม่อย่างน้อย 8 ตัวอักษร" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">ยืนยันรหัสผ่าน (Confirm Password)</label>
                <input type="password" id="confirm_password" name="confirm_password" 
                       placeholder="ระบุรหัสผ่านใหม่อีกครั้ง" required>
            </div>

            <button type="submit" id="submit-btn" class="btn-login">
                บันทึกและเข้าสู่ระบบ
            </button>
            
            <a href="../logout.php" style="text-align: center; font-size: 13px; color: #6b7280; text-decoration: none; margin-top: 10px;">
                ยกเลิกและออกจากระบบ
            </a>
        </form>
    </div>
</div>

<script>
    const form = document.getElementById('changePasswordForm');
    const alert = document.getElementById('alert');
    const btn = document.getElementById('submit-btn');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const new_pass = document.getElementById('new_password').value;
        const confirm_pass = document.getElementById('confirm_password').value;

        alert.className = 'alert';
        alert.style.display = 'none';

        if (new_pass.length < 8) {
            alert.innerText = 'รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร';
            alert.className = 'alert show error';
            return;
        }

        if (new_pass !== confirm_pass) {
            alert.innerText = 'รหัสผ่านใหม่และยืนยันรหัสผ่านไม่ตรงกัน';
            alert.className = 'alert show error';
            return;
        }

        btn.disabled = true;
        btn.innerText = 'กำลังบันทึกข้อมูล...';

        try {
            const res = await fetch('../../api/auth/passwordChange.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams(new FormData(form))
            });
            
            const data = await res.json();

            if (data.success) {
                alert.innerText = data.message;
                alert.className = 'alert show success';
                setTimeout(() => {
                    window.location.href = '../dashboard/dashboard.php';
                }, 1500);
            } else {
                alert.innerText = data.message;
                alert.className = 'alert show error';
                btn.disabled = false;
                btn.innerText = 'บันทึกและเข้าสู่ระบบ';
            }
        } catch (err) {
            alert.innerText = 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์';
            alert.className = 'alert show error';
            btn.disabled = false;
            btn.innerText = 'บันทึกและเข้าสู่ระบบ';
        }
    });
</script>

</body>
</html>