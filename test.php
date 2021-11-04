<?php
include("navbar/header.php");
include("DB/connect.php");
$count = 0;
?>


<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include("navbar/sidebar.php"); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include("navbar/topbar.php"); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="row">

                        <div class="col-lg-4">

                            <!-- Basic Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-1 font-weight-bold text-primary">Maintenance</h6>
                                </div>
                                <div class="card-body">


                                    <div class="formcontainer">

                                        <!-- style="text-align:center" -->
                                        <form method="POST" action="maintenance_result.php" style="vertical-align:top">
                                        <p> Sensor: <br></p>
                                            <!-- Fetch Sensors requiring Maintenance -> It will also fetch if it has been solved, which is accounted for  in the foreach-->
                                            <?php
                                            $query = '  SELECT DISTINCT ON (sensor) * FROM measurements
                                                            INNER JOIN automatic_monitoring
                                                            ON automatic_monitoring.measurements_log_id = measurements.measurements_log_id
                                                            ORDER BY  sensor, automatic_monitoring.time_stamp DESC';

                                            $result = pg_query($con, $query) or die('Query failed: ' . pg_last_error());
                                            $arr_sensor_with_maintenance = pg_fetch_all($result);


                                            /* This structure makes it impossible to fix an already fixed table */
                                            foreach ($arr_sensor_with_maintenance as $sensor) {

                                                if ('f' == $sensor['solved'] && $sensor['risk'] != 0 ) { // f = false
                                            ?>
                                                    <!-- Prints Sensors as Radio Option -->                       
                                                    <input type="radio" name="sensor" value="<?php echo $sensor['sensor'] ?>" required> <?php echo   $sensor['sensor'] ?>
                                                    <br>    
                                                    

                                            <?php
                                                    $count++;
                                                    continue;
                                                }
                                                

                                                //echo $sensor['sensor']  . " <br> <br>";
                                            }
                                            

                                            ?>

                                            <br>
                                            <input type="text" placeholder="Engineer Name" name="mender" required style="width: 80% !important;"> <br>
                                            <br>
                                            <input type="text" placeholder="Problem" name="problem" required style="width: 80% !important;"> <br>
                                            <br>
                                            <input type="number" placeholder="Cost" name="cost" required style="width: 80% !important;">
                                            <br>
                                            <br>
                                            <!-- <input type="password" placeholder="Password" name="password" required style="width: 80% !important;">
                                            <br> -->

                                            <!-- This one was better for aesthetics  -->

                                            <!-- <div class="form-group">
                                                <label for="Description">Description</label>
                                                <textarea class="form-control" id="Description" rows="3"></textarea>
                                            </div> -->

                                            <input type="text" placeholder="Description" name="description" required style="width: 80% !important;"> <br><br>

                                            <!-- <input type="tel" id="phone" name="phone" placeholder="Phone number: 96XXXXXXX" pattern="[0-9]{9}" required"><br><br> -->
                                            <!-- <b>Role&nbsp;&nbsp;</b>
                                            
                                            <br><br> -->
                                            <?php
                                            if($count == 0){
                                                echo "No Sensor needs maintenance";
                                            }
                                            else{
                                            ?>  
                                                <div class="buttonMiddle">
                                                    <button class="btn btn-info" id="submit" type="submit">Register</button>
                                                </div>
                                            <?php } ?>
                                            
                                            
                                        </form>
                                    </div>



                                </div>
                                <!-- /.card body -->
                            </div>

                        </div>
                    </div>
                    <!-- /.row   -->


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</php>