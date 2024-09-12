<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MepExpo</title>
    <link rel="stylesheet" href="style.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="icon" href="images/logo.jpg" type="image/jpg" sizes="32x32">
    <style>
        .container-table h3{
            font-size: 28px;
            text-align: center;
            width: 80%;
            margin: 80px 100px 0 0;
            color: #f44336;
        }
        .container-table p{
            font-size: 14px;
            text-align: center;
            width: 80%;
        }
        .container-table{
            width: 80%;
            margin: 80px 100px 100px 200px;
        }
        .container-table .content-table{
            width: 80%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            min-width: 400px;
            border-radius: 5px 5px 0 0;
            box-shadow: 0 0 20px rgba(0, 0, 0, .15);
        }
        .container-table .content-table thead tr{
            background-color: #f44336;
            color: #fff;
            text-align: left;
            font-weight: bold;
        }
        .container-table .content-table th,
        .container-table .content-table td{
            padding: 12px 15px;
        }
        .container-table .content-table tbody tr{
            border-bottom: 1px solid #dddddd;
        }
        .container-table .content-table tbody tr:nth-of-type(even){
            background-color: #f3f3f3;
        }
        .container-table .content-table tbody tr:last-of-type{
            border-bottom: 2px solid #f44336;
        }
        .container-table .button{
            justify-content: center;
            margin-left: 400px;
            display: flex;
            flex-direction: row;
            gap: 20px;
        }
        .container-table .btn{
            margin-top: 25px;
            text-decoration: none;
            color: #f44336;
            border: 1px solid #fff;
            padding: 12px 34px;
            font-size: 13px;
            background: #fff3f3;
            position: relative;
            cursor: pointer;
            border-radius: 10px;
        }
        .container-table .btn:hover{
            color: #f44336;
            border: 1px solid #f44336;
            background: none;
            transition: 1s;
        }
    </style>
</head>
<body>
    <div class="container-table">
        <h3>Alloted Course Details</h3>
        <p>Your application has been processed successfully. 
            Below are your details along with the allotted course based on your preferences and cutoff score. 
            Please review your information:</p>
        <table class="content-table">
            <thead>
                <tr>
                    <th>Register Number</th>
                    <th>Student Name</th>
                    <th>HSE Mark</th>
                    <th>Cut Off</th>
                    <th>Alloted Course</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "application";

                $connection = new mysqli($servername, $username, $password, $database);

                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                $sql = "SELECT * FROM student_details";
                $result = $connection->query($sql);

                if(!$result){
                    die("Invalid Query ". $connection->error);
                }
                while($row = $result->fetch_assoc()){
                    echo"<tr>
                        <td>" . $row["register_no"] . "</td>
                        <td>" . $row["student_name"] . "</td>
                        <td>" . $row["hse_mark"] . "</td>
                        <td>" . $row["cutt_off"] . "</td>
                        <td>" . $row["allotted_course"] . "</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
        <p>
            We are pleased to offer you the highest preference course that matches your eligibility. 
            For any discrepancies or further assistance, please reach our office.
            Congratulations on your successful allocation, and we look forward to welcoming you to our Institution!
        </p>
        <div class="button">
            <a href="application.html" class="btn">Back</a>
        </div>
    </div>
</body>
</html>