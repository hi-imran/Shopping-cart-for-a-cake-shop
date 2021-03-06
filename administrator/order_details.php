<?php
include "lib/connection.php";
include "lib/login_check.php";


if(isset($_GET['move_to_old'])) {
    $sql = "UPDATE `orders` SET `status` = 'old' WHERE `order_id` = $_GET[move_to_old]";
    $db->query($sql);
    header("Location: orders.php?status=new&msg=Order has been Moved to Old");
}



include "lib/header.php";
?>


            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                   
                    <!-- Column -->
                    <div class="col-lg-12 col-xlg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">

                                <?php
                                if(isset($msg))
                                    print ' <div class="alert alert-success" role="alert">'.$msg.'</div>';
                                ?>
                                <h2 class="box-title">Order Details</h2>
                                
                                <br>
                                
                                <?php

                                 $sql = "SELECT * FROM `orders` WHERE `order_id` = '$_GET[order_id]' ";
                                 $res = $db->query($sql);
                                 $row = $res->fetch_array();

                                 $sql2 = "SELECT * FROM `customers` WHERE `cust_id` = '$row[cust_id]' ";
                                 $res2 = $db->query($sql2);
                                 $row2 = $res2->fetch_array();

                                 print '<h3 class="box-title">Customer Details</h3>
                                  <table class="table">
                                    <tr>
                                        <td>Name</td>
                                        <td>'.$row2['fullname'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>'.$row2['email'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td>'.$row2['phone'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Address</td>
                                        <td>'.$row2['address'].'</td>
                                    </tr>
                                  </table>
                                 ';
                               
                                 print '<h3 class="box-title">Shipping Details</h3>
                                  <table class="table">
                                    <tr>
                                        <td>Shipping Name</td>
                                        <td>'.$row['shipping_fullname'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Shipping Address</td>
                                        <td>'.$row['shipping_address'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Shipping Phone</td>
                                        <td>'.$row['shipping_phone'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Payment Info</td>
                                        <td>'.$row['payment_info'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Date</td>
                                        <td>'.date("D, d-M-Y, h:ia",$row['timestamp']).'</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>'.$row['status'].'</td>
                                    </tr>
                                  </table>

                                  <h3 class="box-title">Cart Items</h3>
                                  <table class="table">
                                    <tr>
                                        <td>No</td>
                                        <td>Pid</td>
                                        <td>Name</td>
                                        <td>Image</td>
                                        <td>Price</td>
                                        <td>Quantity</td>
                                        <td>Subtotal</td>
                                    </tr>

                                 ';
                                
                                $no = 0;
                                $sql = "SELECT * FROM `cart_items` WHERE `order_id` = '$_GET[order_id]' ";
                                $res = $db->query($sql);
                                while($row = $res->fetch_array()) {
                                     
                                     $sql2 = "SELECT * FROM `products` WHERE `id` = '$row[pid]' ";
                                     $res2 = $db->query($sql2);
                                     $row2 = $res2->fetch_array();

                                     $no++;
                                     $sub = $row['quantity'] * $row['purchase_price'];

                                     print "<tr>
                                        <td>$no</td>
                                        <td>$row[pid]</td>
                                        <td>$row2[name]</td>
                                        <td><img src = \"../$row2[image]\" width = 50></td>
                                        <td>$row[purchase_price]</td>
                                        <td>$row[quantity]</td>
                                        <td>$sub</td>
                                    </tr>";

                                }

                                 ?>
                                       
                                    </table>

                                <br>
                                <center>
                                <a href="order_details.php?move_to_old=<?php print $_GET['order_id'];?>"
                                class="btn btn-danger " onclick = "return confirm('Are you sure?');">Move to Old Orders</a>
                                &nbsp; &nbsp; &nbsp; &nbsp; 
                                <a href="print.php?order_id=<?php print $_GET['order_id'];?>"
                                class="btn btn-primary " target = _blank>Print Order</a>
                                </center>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->

                                
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->

 <?php
 include "lib/footer.php";
 ?>