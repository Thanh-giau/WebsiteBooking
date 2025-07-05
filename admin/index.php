<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

require 'includes/check_auth.php';
require 'includes/db_connect.php';  // tạo $link
require 'includes/header.php';
require 'includes/sidebar.php';
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 main-content">
  <div class="d-flex justify-content-between align-items-center 
              pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard Admin</h1>
  </div>

  <div class="alert alert-success">
    Chào mừng <strong><?php echo $_SESSION['admin_name']; ?></strong> đã trở lại!
  </div>

  <?php
  // 1. Bác sĩ
  $sql_doctors = "
    SELECT d.id, u.name AS doctor_name, d.specialty
    FROM doctors d
    JOIN users u ON d.user_id = u.id
    ORDER BY d.id
  ";
  $res_doctors = mysqli_query($link, $sql_doctors)
    or die('Lỗi truy vấn doctors: '.mysqli_error($link));

  // 2. Bệnh nhân
  $sql_patients = "
    SELECT id, name, email, phone
    FROM users
    WHERE role = 'patient'
    ORDER BY id
  ";
  $res_patients = mysqli_query($link, $sql_patients)
    or die('Lỗi truy vấn patients: '.mysqli_error($link));

  // 3. Dịch vụ
  $sql_services = "
    SELECT id, name, duration_minutes, price
    FROM services
    ORDER BY id
  ";
  $res_services = mysqli_query($link, $sql_services)
    or die('Lỗi truy vấn services: '.mysqli_error($link));

  // 4. Lịch hẹn
  $sql_appointments = "
    SELECT a.id,
           p.name   AS patient_name,
           doc.name AS doctor_name,
           s.name   AS service_name,
           a.appointment_time,
           a.status
    FROM appointments a
    LEFT JOIN users    p   ON a.patient_id  = p.id
    LEFT JOIN doctors  d   ON a.doctor_id   = d.id
    LEFT JOIN users    doc ON d.user_id      = doc.id
    LEFT JOIN services s   ON a.service_id   = s.id
    ORDER BY a.appointment_time DESC
  ";
  $res_appointments = mysqli_query($link, $sql_appointments)
    or die('Lỗi truy vấn appointments: '.mysqli_error($link));
  ?>

  <!-- Bảng Bác sĩ -->
  <h2>Danh sách Bác sĩ</h2>
  <table class="table">
    <thead><tr><th>ID</th><th>Tên</th><th>Chuyên khoa</th></tr></thead>
    <tbody>
    <?php while($r = mysqli_fetch_assoc($res_doctors)): ?>
      <tr>
        <td><?= $r['id'] ?></td>
        <td><?= htmlspecialchars($r['doctor_name']) ?></td>
        <td><?= htmlspecialchars($r['specialty']) ?></td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>

  <!-- Bảng Bệnh nhân -->
  <h2>Danh sách Bệnh nhân</h2>
  <table class="table">
    <thead><tr><th>ID</th><th>Tên</th><th>Email</th><th>Điện thoại</th></tr></thead>
    <tbody>
    <?php while($r = mysqli_fetch_assoc($res_patients)): ?>
      <tr>
        <td><?= $r['id'] ?></td>
        <td><?= htmlspecialchars($r['name']) ?></td>
        <td><?= htmlspecialchars($r['email']) ?></td>
        <td><?= htmlspecialchars($r['phone']) ?></td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>

  <!-- Bảng Dịch vụ -->
  <h2>Danh sách Dịch vụ</h2>
  <table class="table">
    <thead><tr><th>ID</th><th>Tên</th><th>Thời gian</th><th>Giá</th></tr></thead>
    <tbody>
    <?php while($r = mysqli_fetch_assoc($res_services)): ?>
      <tr>
        <td><?= $r['id'] ?></td>
        <td><?= htmlspecialchars($r['name']) ?></td>
        <td><?= $r['duration_minutes'] ?> phút</td>
        <td><?= number_format($r['price'],0,',','.') ?> ₫</td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>

  <!-- Bảng Lịch hẹn -->
  <h2>Danh sách Lịch hẹn</h2>
  <table class="table">
    <thead>
      <tr>
        <th>ID</th><th>Bệnh nhân</th><th>Bác sĩ</th>
        <th>Dịch vụ</th><th>Thời gian</th><th>Trạng thái</th>
      </tr>
    </thead>
    <tbody>
    <?php while($r = mysqli_fetch_assoc($res_appointments)): ?>
      <tr>
        <td><?= $r['id'] ?></td>
        <td><?= htmlspecialchars($r['patient_name']) ?></td>
        <td><?= htmlspecialchars($r['doctor_name']) ?></td>
        <td><?= htmlspecialchars($r['service_name']) ?></td>
        <td><?= date('d/m/Y H:i', strtotime($r['appointment_time'])) ?></td>
        <td><?= ucfirst($r['status']) ?></td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>

</main>

<?php require 'includes/footer.php'; ?>
