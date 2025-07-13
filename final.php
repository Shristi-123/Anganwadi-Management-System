<?php
// Database connection details
$servername = "localhost"; // Database host
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "anganwadi_db"; // Name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle Children data submission
    if (isset($_POST['add_child'])) {
        $name = $_POST['child_name'];
        $gender = $_POST['child_gender'];
        $dob = $_POST['child_dob'];
        $guardian_name = $_POST['guardian_name'];
        $conn->query("INSERT INTO child (name, gender, dob, guardian_name) VALUES ('$name', '$gender', '$dob', '$guardian_name')");
    }

    // Handle Medical Records data submission
    if (isset($_POST['add_medical_record'])) {
        $checkup_date = $_POST['checkup_date'];
        $child_id = $_POST['child_id'];
        $health_status = $_POST['health_status'];
        $conn->query("INSERT INTO medical_record (checkup_date, child_id, health_status) VALUES ('$checkup_date', '$child_id', '$health_status')");
    }

    // Handle Stock data submission
    if (isset($_POST['add_stock'])) {
        $item_name = $_POST['item_name'];
        $quantity = $_POST['quantity'];
        $date_received = $_POST['date_received'];
        $supervisor_id = $_POST['supervisor_id'];
        $conn->query("INSERT INTO stock (ItemName, Quantity, DateReceived, SupervisorID) VALUES ('$item_name', '$quantity', '$date_received', '$supervisor_id')");
    }

    // Handle Attendance data submission
    if (isset($_POST['add_attendance'])) {
        $unique_id = $_POST['unique_id'];
        $attendance_date = $_POST['attendance_date'];
        $time_of_coming = $_POST['time_of_coming'];
        $time_of_going = $_POST['time_of_going'];
        $conn->query("INSERT INTO attendancetable (unique_id, attendance_date, time_of_coming, time_of_going) VALUES ('$unique_id', '$attendance_date', '$time_of_coming', '$time_of_going')");
    }

    // Handle Supervisors data submission
    if (isset($_POST['add_supervisor'])) {
        $name = $_POST['supervisor_name'];
        $contact_number = $_POST['supervisor_contact'];
        $email = $_POST['supervisor_email'];
        $conn->query("INSERT INTO supervisor (Name, ContactNumber, Email) VALUES ('$name', '$contact_number', '$email')");
    }

    // Handle Helpers data submission
    if (isset($_POST['add_helper'])) {
        $name = $_POST['helper_name'];
        $contact_number = $_POST['helper_contact'];
        $id_proof = $_POST['id_proof'];
        $supervisor_id = $_POST['helper_supervisor_id'];
        $conn->query("INSERT INTO helper (Name, ContactNumber, IDProof, SupervisorID) VALUES ('$name', '$contact_number', '$id_proof', '$supervisor_id')");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Anganwadi Management System</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    header {
      background-color: #4CAF50;
      color: white;
      padding: 15px;
      text-align: center;
    }
    nav ul {
      list-style: none;
      padding: 0;
      text-align: center;
      margin: 0;
    }
    nav ul li {
      display: inline-block;
      margin: 0 15px;
    }
    nav ul li a {
      color: white;
      text-decoration: none;
    }
    main {
      padding: 20px;
    }
    section {
      background: white;
      padding: 20px;
      margin-bottom: 30px;
      border-radius: 8px;
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
    }
    h2 {
      margin-top: 0;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
    }
    th {
      background-color: #f2f2f2;
    }
    footer {
      background-color: #4CAF50;
      color: white;
      text-align: center;
      padding: 15px;
    }
    form {
      margin-bottom: 20px;
    }
    input, select {
      margin: 5px 0;
      padding: 10px;
      width: 100%;
      box-sizing: border-box;
    }
  </style>
</head>
<body>
  <header>
    <h1>Anganwadi Management System</h1>
    <nav>
      <ul>
        <li><a href="#child">Child</a></li>
        <li><a href="#medical_record">Medical Records</a></li>
        <li><a href="#stock">Stock</a></li>
        <li><a href="#attendance">Attendance</a></li>
        <li><a href="#supervisors">Supervisors</a></li>
        <li><a href="#helpers">Helpers</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <!-- Children Section -->
    <section id="child">
      <h2>Add Child</h2>
      <form method="POST">
        <input type="text" name="child_name" placeholder="Name" required>
        <input type="text" name="child_gender" placeholder="Gender" required>
        <input type="date" name="child_dob" placeholder="Date of Birth" required>
        <input type="text" name="guardian_name" placeholder="Guardian Name" required>
        <button type="submit" name="add_child">Add Child</button>
      </form>
      <h2>Children List</h2>
      <table>
        <thead>
          <tr>
            <th>child_id</th>
            <th>name</th>
            <th>gender</th>
            <th>dob</th>
            <th>guardian_name</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = $conn->query("SELECT * FROM child");
          if ($result) {
              if ($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                      echo "<tr>
                              <td>".$row['child_id']."</td>
                              <td>".$row['name']."</td>
                              <td>".$row['gender']."</td>
                              <td>".$row['dob']."</td>
                              <td>".$row['guardian_name']."</td>
                            </tr>";
                  }
              } else {
                  echo "<tr><td colspan='5'>No data found</td></tr>";
              }
          } else {
              echo "<tr><td colspan='5'>Error: " . $conn->error . "</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </section>

    <!-- Medical Records Section -->
    <section id="medical_record">
      <h2>Add Medical Record</h2>
      <form method="POST">
        <input type="date" name="checkup_date" placeholder="Checkup Date" required>
        <input type="number" name="child_id" placeholder="Child ID" required>
        <input type="text" name="health_status" placeholder="Health Status" required>
        <button type="submit" name="add_medical_record">Add Medical Record</button>
      </form>
      <h2>Medical Records List</h2>
      <table>
        <thead>
          <tr>
            <th>record_id</th>
            <th>checkup_date</th>
            <th>child_id</th>
            <th>health_status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = $conn->query("SELECT * FROM medical_record");
          if ($result) {
              if ($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                      echo "<tr>
                              <td>".$row['record_id']."</td>
                              <td>".$row['checkup_date']."</td>
                              <td>".$row['child_id']."</td>
                              <td>".$row['health_status']."</td>
                            </tr>";
                  }
              } else {
                  echo "<tr><td colspan='4'>No data found</td></tr>";
              }
          } else {
              echo "<tr><td colspan='4'>Error: " . $conn->error . "</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </section>

    <!-- Stock Section -->
    <section id="stock">
      <h2>Add Stock</h2>
      <form method="POST">
        <input type="text" name="item_name" placeholder="Item Name" required>
        <input type="number" name="quantity" placeholder="Quantity" required>
        <input type="date" name="date_received" placeholder="Date Received" required>
        <input type="number" name="supervisor_id" placeholder="Supervisor ID" required>
        <button type="submit" name="add_stock">Add Stock</button>
      </form>
      <h2>Stock List</h2>
      <table>
        <thead>
          <tr>
            <th>StockID</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Date Received</th>
            <th>SupervisorID</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = $conn->query("SELECT * FROM stock");
          if ($result) {
              if ($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                      echo "<tr>
                              <td>".$row['StockID']."</td>
                              <td>".$row['ItemName']."</td>
                              <td>".$row['Quantity']."</td>
                              <td>".$row['DateReceived']."</td>
                              <td>".$row['SupervisorID']."</td>
                            </tr>";
                  }
              } else {
                  echo "<tr><td colspan='5'>No data found</td></tr>";
              }
          } else {
              echo "<tr><td colspan='5'>Error: " . $conn->error . "</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </section>

    <!-- Attendance Section -->
    <section id="attendance">
      <h2>Add Attendance</h2>
      <form method="POST">
        <input type="number" name="unique_id" placeholder="Unique ID" required>
        <input type="date" name="attendance_date" placeholder="Attendance Date" required>
        <input type="time" name="time_of_coming" placeholder="Time of Coming" required>
        <input type="time" name="time_of_going" placeholder="Time of Going" required>
        <button type="submit" name="add_attendance">Add Attendance</button>
      </form>
      <h2>Attendance List</h2>
      <table>
        <thead>
          <tr>
            <th>id</th>
            <th>unique_id</th>
            <th>attendance_date</th>
            <th>Time_of_coming</th>
            <th>Time_of_going</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = $conn->query("SELECT * FROM attendancetable");
          if ($result) {
              if ($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                      echo "<tr>
                              <td>".$row['id']."</td>
                              <td>".$row['unique_id']."</td>
                              <td>".$row['attendance_date']."</td>
                              <td>".$row['time_of_coming']."</td>
                              <td>".$row['time_of_going']."</td>
                            </tr>";
                  }
              } else {
                  echo "<tr><td colspan='5'>No data found</td></tr>";
              }
          } else {
              echo "<tr><td colspan='5'>Error: " . $conn->error . "</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </section>

    <!-- Supervisors Section -->
    <section id="supervisors">
      <h2>Add Supervisor</h2>
      <form method="POST">
        <input type="text" name="supervisor_name" placeholder="Name" required>
        <input type="text" name="supervisor_contact" placeholder="Contact Number" required>
        <input type="email" name="supervisor_email" placeholder="Email" required>
        <button type="submit" name="add_supervisor">Add Supervisor</button>
      </form>
      <h2>Supervisors List</h2>
      <table>
        <thead>
          <tr>
            <th>SupervisorID</th>
            <th>Name</th>
            <th>Contact Number</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = $conn->query("SELECT * FROM supervisor");
          if ($result) {
              if ($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                      echo "<tr>
                              <td>".$row['SupervisorID']."</td>
                              <td>".$row['Name']."</td>
                              <td>".$row['ContactNumber']."</td>
                              <td>".$row['Email']."</td>
                            </tr>";
                  }
              } else {
                  echo "<tr><td colspan='4'>No data found</td></tr>";
              }
          } else {
              echo "<tr><td colspan='4'>Error: " . $conn->error . "</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </section>

    <!-- Helpers Section -->
    <section id="helpers">
      <h2>Add Helper</h2>
      <form method="POST">
        <input type="text" name="helper_name" placeholder="Name" required>
        <input type="text" name="helper_contact" placeholder="Contact Number" required>
        <input type="text" name="id_proof" placeholder="ID Proof" required>
        <input type="number" name="helper_supervisor_id" placeholder="Supervisor ID" required>
        <button type="submit" name="add_helper">Add Helper</button>
      </form>
      <h2>Helpers List</h2>
      <table>
        <thead>
          <tr>
            <th>HelperID</th>
            <th>Name</th>
            <th>Contact Number</th>
            <th>ID Proof</th>
            <th>SupervisorID</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = $conn->query("SELECT * FROM helper");
          if ($result) {
              if ($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                      echo "<tr>
                              <td>".$row['HelperID']."</td>
                              <td>".$row['Name']."</td>
                              <td>".$row['ContactNumber']."</td>
                              <td>".$row['IDProof']."</td>
                              <td>".$row['SupervisorID']."</td>
                            </tr>";
                  }
              } else {
                  echo "<tr><td colspan='5'>No data found</td></tr>";
              }
          } else {
              echo "<tr><td colspan='5'>Error: " . $conn->error . "</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </section>
    
  </main>

  <footer>
    &copy; 2025 Anganwadi System. All rights reserved.
  </footer>

  <?php
  $conn->close();
  ?>
</body>
</html>


