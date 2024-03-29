<?php include_once('header.php');
include_once('Database_prj.php'); ?>

<?php $sql = "select * from tbl_customer;";
$result = mysqli_query($conn,$sql);
?>
<div id="content">
    <h1 style="font-weight: bold">All users</h1>
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">User ID</th>
            <th scope="col">Username</th>
            <th scope="col">Fullname</th>
            <th scope="col">PhoneNumber</th>
            <th scope="col">Address</th>

        </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()) {?>
            <tr>
                <th scope="row"><?php echo $row['cus_id']?></th>
                <td><?php echo $row['cus_username']?></td>
                <td><?php echo $row['fullname']?></td>
                <td><?php echo $row['cus_phone']?></td>
                <td><?php echo $row['cus_address']?></td>

                <td><button type="button" class="btn btn-danger" onclick="delete_user(<?php echo $row['cus_id']?>)">Delete</button></td>
            </tr>

        <?php }
        if (isset($_POST['cus_id'])) {
            $user_id = $_POST['cus_id'];
            $delete_user = "DELETE FROM tbl_customer WHERE cus_id = ".$user_id;
            $deleted_user = mysqli_query($conn, $delete_user);
            if ($deleted_user) {
                $update_user = "UPDATE tbl_customer SET cus_id = cus_id - 1 where cus_id > ".$user_id;
                $reorder_user = mysqli_multi_query($conn, $update_user);
                if ($reorder_user) {
                    echo 'Order of user_id updated successfully.';
                } else {
                    echo 'Error updating order of user_id: ' . mysqli_error($conn);
                }
            }
            else {
                echo 'Error executing SQL script: ' . mysqli_error($conn);
            }
        }

        ?>
        </tbody>
    </table>
</div>

<script>
    function delete_user(cus_id) {
        // Make AJAX request to the PHP file
        var xhr = new XMLHttpRequest();
        xhr.open('POST', window.location.href, true);
        // Create a new FormData object and append the value to it
        var formData = new FormData();
        formData.append('cus_id', cus_id);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                window.location.href = "user_manage.php";
            }
        };
        xhr.send(formData);
    }
</script>





<?php
$conn->close();
include_once ('footer.php')?>
