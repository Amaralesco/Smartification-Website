
<?php include( "navbar/header.php"); ?>
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

                    <!-- Connection to the DataBase -->
                    <?php include("DB/connect.php");?>

                    <!-- Content Row -->
                    <div class="row">


                        
                        <!-- State of the Equipment -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <h6 class="m-0 font-weight-bold text-primary">
                                                <i class="fas fa-tachometer-alt fa-s"></i>
                                                State of the Equipment    
                                                
                                                <br><br>
                                            </h6>

                                                
                                                    
                                                
                                            <div class="h5 mb-0 font-weight-bold text-gray-700 bg-gray-200">
                                                
                                                
                                                <?php 
                                                    $query = 'SELECT activity FROM activities';
                                                    $result = pg_query($con, $query) or die('Query failed: ' . pg_last_error());
                
                                                                                                        
                                                    $arr_activities = pg_fetch_all($result);

                                                    //----New Query

                                                    $query = 'SELECT activity from MEASUREMENTS
                                                                ORDER BY time_stamp DESC
                                                                LIMIT 1';
                                                    $result = pg_query($con, $query) or die('Query failed: ' . pg_last_error());                                                                                                                             
                                                    $arr_lastActivity = pg_fetch_array($result);
                                                                                                        
                                                    foreach($arr_activities as $activity){

                                                        if($arr_lastActivity['activity'] == $activity['activity']){
                                                            ?>
                                                            <div class= 'text-gray-100 bg-gray-500'>
                                                            <?php echo $activity['activity'] . "<br> <br>";
                                                            ?> </div>
                                                            <?php 
                                                            continue;    
                                                        }

                                                        echo $activity['activity'] . "<br> <br>";
                                                        
                                                    }

                                                ?>



                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Content Column -->     
                        <div class="col-lg-6 mb-4">

                            <!-- Illustrations -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Monitoring</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                                            src="img/undraw_Customer_survey_re_v9cj.svg" alt="...">
                                    </div>
                                    <p>This page provides the user with the possibility to monitor his application</p>
                                    <a target="_blank" rel="ugc" href="https://docs.google.com/forms/d/e/1FAIpQLSfm6HfKkzYcOiMGZXGJO0CfZ7mUJclj--3jBRu1cSAI8TmKRQ/viewform"> If you want, you can also use this form 
                                    to send feedback to the developer &rarr;</a>
                                </div>
                            </div>
                        </div>
                    </div>

                            
                    <!-- Content Row -->
                    <div class="row">
                        <!-- Content Column -->     
                        <div class="col-lg-6 mb-4">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Sensors Values</h6>
                                </div>
                            

                                <?php 
                                
                                

                                    $query = 'SELECT sensor FROM sensors';
                                    $result = pg_query($con, $query) or die('Query failed: ' . pg_last_error());

                                    
                                    
                                    $arr_sensors = pg_fetch_all($result);
                                    
                                    //print_r($arr_sensors);

                                    $query = 'SELECT DISTINCT ON (sensor) * FROM measurements
                                    INNER JOIN automatic_monitoring
                                    ON automatic_monitoring.measurements_log_id = measurements.measurements_log_id
                                    ORDER BY  sensor, automatic_monitoring.time_stamp DESC';

                                    $result = pg_query($con, $query) or die('Query failed: ' . pg_last_error());

                                    $arr_monitoring = pg_fetch_all($result);
                                    $num = pg_num_rows($result);


                                    $query = 'SELECT DISTINCT ON (sensor) * FROM measurements
                                            ORDER BY  sensor, time_stamp DESC';

                                    $result = pg_query($con, $query) or die('Query failed: ' . pg_last_error());

                                    $arr_measurements = pg_fetch_all($result);
                                    $num_measurements = pg_num_rows($result);
                                    

                                
                                ?>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr class="table-active">
                                                    <th>Sensor</th>
                                                    <th>Value</th>
                                                    <th>Activity</th>
                                                    <th>Time of Measure</th>                                                    
                                                    <th>Risk</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr class="table-active">
                                                    <th>Sensor</th>
                                                    <th>Value</th>
                                                    <th>Activity</th>
                                                    <th>Time of Measure</th>
                                                    <th>Risk</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>

                                            
                                            
                                                <?php
                                                
                                                foreach($arr_sensors as $index=>$sensor){
                                                
                                                    $increment = 0;
                                                    
                                                    foreach ($arr_monitoring as $item){
                                                                                                    
                                                        
                                                        if($item['sensor'] == $sensor['sensor'] && $item['solved'] == 'f'){// $item['sensor'] // It searches unsolved solutions as well
                                                            
                                                            if($item['risk'] == 0){echo "<tr class='table-success'>" ;}
                                                            elseif($item['risk'] == 3){echo "<tr class='table-danger'>" ;}
                                                            else {echo "<tr class='table-warning'>" ;}
                                                            
                                                            echo "<td>"; echo $item['sensor']; echo "</td>";
                                                            echo "<td>"; echo $item['value']; echo "</td>";
                                                            echo "<td>"; echo $item['activity']; echo "</td>";
                                                            echo "<td>"; echo $item['time_stamp']; echo "</td>";
                                                            echo "<td>"; echo $item['risk']; echo "</td>";                                                        
                                                            
                                                        }
                                                        else{
                                                            $increment ++; //to notify if it didn't write that specific sensor
                                                            
                                                        }                                                       
                                                    }
                                                    if ($increment == $num){ //it iterated among all the sensors, and found no common entries with monitoring
                                                        $increment = 0;
                                                        foreach($arr_measurements as $measurements){
                                                            if($measurements['sensor'] == $arr_sensors[$index]['sensor']){ //prints from measurements
                                                                echo "<tr class='table-success'>" ;
                                                                echo "<td>"; echo $arr_sensors[$index]['sensor']; echo "</td>";
                                                                echo "<td>"; echo $measurements['value']; echo "</td>";
                                                                echo "<td>"; echo $measurements['activity']; echo "</td>";
                                                                echo "<td>"; echo $measurements['time_stamp']; echo "</td>";
                                                                echo "<td>"; echo 0 ; /* risk */echo "</td>";
                                                            }
                                                            else{
                                                                $increment ++; //to notify if it didn't find that specific sensor
                                                                
                                                            }
                                                        }

                                                        if($increment == $num_measurements){ //it iterated among all the measurements, and found no common entries with sensors
                                                            echo "<tr class='table-success'>" ;
                                                            echo "<td>"; echo $arr_sensors[$index]['sensor']; echo "</td>";//prints from sensors aka no measurements yet
                                                            echo "<td>"; /* echo $item['value'];  */echo "</td>";
                                                            echo "<td>";/*  echo $item['activity']; */ echo "</td>";
                                                            echo "<td>"; /* echo $item['time_stamp']; */ echo "</td>";
                                                            echo "<td>"; /* echo $item['risk']; */ echo "</td>";
                                                        }

                                                    }                     
                                                    $increment = 0; //reset counter                                                                                                                                    
                                                }
                                                ?>
                                            </tr>
                                
                                        </table>
                                    </div>  
                                </div>
                            </div>  

                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <?php

                            $query = "SELECT * FROM measurements
                            WHERE sensor = 'Battery'
                            Order by time_stamp DESC
                            LIMIT 1";

                            $result = pg_query($con, $query) or die('Query failed: ' . pg_last_error());

                            $arr_battery = pg_fetch_all($result);
                            
                            //print_r($arr_measurements);

                        
                        
                        ?>


                        <div class="col-xl-3 col-md-6 mb-4 h-100" >                            
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Battery
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                        <?php echo $arr_battery[0]['value'];?>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: <?php echo $arr_battery[0]['value'] ;?>%" aria-valuenow="100" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.Content Row -->

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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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