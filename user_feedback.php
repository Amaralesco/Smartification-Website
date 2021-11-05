<!-- 
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->


<?php 
    include("navbar/header.php");
    include("DB/connect.php");
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

                    <!-- http://www.jquery2dotnet.com/ -->

                    <div class="row">
                        <div class="col-s-6 col-md-3">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <h6 class="m-0 font-weight-bold text-primary">
                                                <i class="glyphicon glyphicon-star"></i>
                                                Rating

                                                <br><br>
                                            </h6>
                                            <div class="well well-sm">
                                                <div class="row">
                                                    <div class="col-xs-12 col-md-6 text-center">
                                                        <?php
                                                        $query = ' SELECT CAST(AVG(rating) AS DECIMAL(10,2))
                                                                    FROM user_feedback_rating;';

                                                        $result = pg_query($con, $query) or die('Query failed: ' . pg_last_error());
                                                        $arr_avg_rating = pg_fetch_all($result);

                                                        $query = '  SELECT COUNT(rating) 
                                                                    FROM user_feedback_rating;';

                                                        $result = pg_query($con, $query) or die('Query failed: ' . pg_last_error());
                                                        $arr_count = pg_fetch_all($result);
                                                            

                                                        ?>

                                                        <h1 class="rating-num">
                                                            <?php echo $arr_avg_rating[0]['avg'] ?> <!-- Fetches first (and only row) of collumn avg -->
                                                            <div class="rating">
                                                                <span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>
                                                            </div>
                                                        </h1> 
                                                        <!-- <div class="rating">
                                                            <span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star">
                                                            </span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star">
                                                            </span><span class="glyphicon glyphicon-star-empty"></span>
                                                        </div> -->

                                                        
                                                        <div>
                                                            <span class="glyphicon glyphicon-user"></span> From <?php echo $arr_count[0]['count'] ?>  users
                                                        </div>
                                                    </div>
                                                    
                                                        <!-- end row -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>




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