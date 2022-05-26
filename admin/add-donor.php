<?php

session_start(); ?>
<?php require_once('header.php')?>
<?php require_once('sidebar.php')?>
<?php
    if(!$_SESSION['user'])
    {
        header('Location: login.php');
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) 
        {
            $error1 = "*Required";
            } 
            else {
                $name = test_input($_POST["name"]);
            if (!preg_match("/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s\W|_]*$/",$name)) {
                $nameErr = "*Only letters and white space allowed";
            }
        }
        

        if(empty($_POST["address"])){
            $error2 = "*Required";
        }
        else{
            $address = test_input($_POST["address"]);
            if (!preg_match("/(?i)([0-9A-ZẮẰẲẴẶĂẤẦẨẪẬÂÁÀÃẢẠĐẾỀỂỄỆÊÉÈẺẼẸÍÌỈĨỊỐỒỔỖỘÔỚỜỞỠỢƠÓÒÕỎỌỨỪỬỮỰƯÚÙỦŨỤÝỲỶỸỴ']+\\s?\\b){2,}/",$address)) 
            {
                $addressErr = "Invalid Address";
            }
        }
        
        if (empty($_POST["area"])) 
        {
            $error3 = "*Required";
            } 
            else {
                $area = test_input($_POST["area"]);
            if (!preg_match("/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s\W|_]*$/",$area)) 
            {
                $areaErr = "Invalid Area";
            }
        }

        if (empty($_POST["sub-area"])) 
        {
            $error4 = "*Required";
            } 
            else {
                $sub_area = test_input($_POST["sub-area"]);
            if (!preg_match("/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s\W|_]*$/",$sub_area)) 
            {
                $sub_areaErr = "Invalid Sub Area";
            }
        }

        if (empty($_POST["nid"])) 
        {
            $error5 = "*Required";
            } 
            else {
                $nid = test_input($_POST["nid"]);
            if (!preg_match("/^[0-9]*$/",$nid)) 
            {
                $nidErr = "Only numbers";
            }
        }
        
        if (empty($_POST["phone"])) 
        {
            $error6 = "*Required";
            } 
            else {
                $phone = test_input($_POST["phone"]);
            if (!preg_match("/(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b/",$phone)) 
            {
                $phoneErr = "Phone number should contain only numbers";
            }
        }
    
        if (empty($_POST["email"])) 
        {
            $error7 = "*Required";
        } 
        else {
            $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            {
                $emailErr = "Invalid email format";
            }
        }

        if (empty($_POST["schedule"]))
        {
            $error8 = "*Required";
        }

        if(empty($nameErr) && empty($addressErr) && empty($areaErr) && empty($sub_areaErr) && empty($nidErr) && empty($phoneErr) && empty($emailErr)){
        {
            add_new_donor();
        }
    }
}

    function add_new_donor()
    {
        if(!empty($_POST['name']) && !empty($_POST['address']) && !empty($_POST['area']) && !empty($_POST['sub-area']) && !empty($_POST['branch']) && !empty($_POST['bg']) && !empty($_POST['nid']) && !empty($_POST['phone']) && !empty($_POST['email']) && !empty($_POST['schedule'])) 
        {
            $name = $_POST['name'];
            $address = $_POST['address'];
            $area = $_POST['area'];
            $sub_area = $_POST['sub-area'];
            $branch = $_POST['branch'];
            $bg = $_POST['bg'];
            $nid = $_POST['nid'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $schedule = date("d-m-Y h:i:s A", strtotime($_POST['schedule']));

            $conn = oci_connect('TESTORACLE', 'Tu01228671340', 'localhost/XE:BloodBank','AL32UTF8');
            $query = "INSERT INTO donor(d_id, b_id, d_name, address, area, subarea, blood_group, national_id, phone, email, schedule) VALUES (dnr.nextval, $branch, '$name', '$address', '$area', '$sub_area', '$bg', '$nid', '$phone', '$email', TO_DATE('$schedule', 'DD-MM-YYYY hh:mi:ss AM'))";
            $stid = oci_parse($conn, $query);
            $result = oci_execute($stid);

            if(!$result) {
                echo "Failed !";
                echo $schedule;
            }
            else {
                //echo "Successfully added New Donor !";
                echo "<script>window.location.href='donor.php';</script>";
            }
        }
        else {
            echo "<p id=\"warning\">Fill All The Information !</p>";
        }
    }

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>


<div class="donor-section">
    
    <h1 class="menu-title">Add New Donor : </h1>
    <a href="donor.php" class="hlink cat-link">Back to Donor List</a>
    <form id="add-donor-form" name="donorform" action="add-donor.php" method="post" >
       <br>
        <p class="form-text">Donor Name : 
            <span class="error" style="color: red;"><?php echo isset($error1) ? $error1 : '' ;?></span>
            <span class="error" style="color: red;"><?php echo isset($nameErr) ? $nameErr : '' ;?></span>
        </p>
        <input name="name" class="form-field" type="text" placeholder="Name">
        
        <p class="form-text">Address : 
            <span class="error" style="color: red;"><?php echo isset($error2) ? $error2 : '' ;?></span>
            <span class="error" style="color: red;"><?php echo isset($addressErr) ? $addressErr : '' ;?></span>
        </p>
        <textarea name="address" id="textarea" class="form-field" cols="30" rows="10" placeholder="Address"></textarea>
        
        <p class="form-text">Area : 
            <span class="error" style="color: red;"><?php echo isset($error3) ? $error3 : '' ;?></span>
            <span class="error" style="color: red;"><?php echo isset($areaErr) ? $areaErr : '' ;?></span>
        </p>
        <input name="area" class="form-field" type="text" placeholder="Area">
        
        <p class="form-text">Sub Area : 
            <span class="error" style="color: red;"><?php echo isset($error4) ? $error4 : '' ;?></span>
            <span class="error" style="color: red;"><?php echo isset($sub_areaErr) ? $sub_areaErr : '' ;?></span>
        </p>
        <input name="sub-area" class="form-field" type="text" placeholder="Sub Area">
        
        <p id="pcat" class="form-text">Select Branch : </p>
             <select name="branch" style="width: 100%;">
                 <?php
                    $conn = oci_connect('TESTORACLE', 'Tu01228671340', 'localhost/XE:BloodBank','AL32UTF8');

                   $stid = oci_parse($conn, "SELECT * FROM branch");
                   oci_execute($stid);
                 
                    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                        echo "<option value=\"".$row['B_ID']."\">".$row['B_NAME']." ,".$row['ADDRESS']." ,".$row['AREA']."</option>";
                    }
                 ?>
            </select>
        
        <p id="pcat" class="form-text">Blood Group : </p>
             <select name="bg">
                 <?php
                    $conn = oci_connect('TESTORACLE', 'Tu01228671340', 'localhost/XE:BloodBank','AL32UTF8');

                   $stid = oci_parse($conn, "SELECT * FROM blood ORDER BY blood_group ASC");
                   oci_execute($stid);
                 
                    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                        echo "<option value=\"".$row['BLOOD_GROUP']."\">".$row['BLOOD_GROUP']."</option>";
                    }
                 ?>
            </select>
        
        <p class="form-text">National ID : 
            <span class="error" style="color: red;"><?php echo isset($error5) ? $error5 : '' ;?></span>
            <span class="error" style="color: red;"><?php echo isset($nidErr) ? $nidErr : '' ;?></span>
        </p>
        <input name="nid" class="form-field" type="text" placeholder="National id">
        
        <p class="form-text">Phone : 
            <span class="error" style="color: red;"><?php echo isset($error6) ? $error6 : '' ;?></span>
            <span class="error" style="color: red;"><?php echo isset($phoneErr) ? $phoneErr : '' ;?></span>
        </p>
        <input name="phone" class="form-field" type="text" placeholder="Phone">
        
        <p class="form-text">Email : 
            <span class="error" style="color: red;"><?php echo isset($error7) ? $error7 : '' ;?></span>
            <span class="error" style="color: red;"><?php echo isset($emailErr) ? $emailErr : '' ;?></span>
        </p>
        <input name="email" class="form-field" type="text" placeholder="Email"> 

        <p class="form-text">Appointment Schedule :
            <span class="error" style="color: red;"><?php echo isset($error8) ? $error8 : '' ;?></span>
        </p>  
        <input name="schedule" class="form-field" type="date" >

        <input type="submit" name="submit" id="submit" value="Add New Donor" class="form-field">
        
    </form>
</div>

<?php require_once('footer.php')?>
