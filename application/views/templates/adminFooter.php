    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo site_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo site_url('/assets/js/jquery-ui.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo site_url('assets/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>


    <!-- Custom scripts for all pages-->
    <script src="<?php echo site_url('assets/vendor/js/sb-admin.min.js'); ?>"></script>

    <!-- custom js -->
     <script src="<?php echo site_url('assets/js/admindashboard.js'); ?>"></script>

     <!-- Chosen script -->
     <script src="<?php echo site_url('/assets/chosen/chosen.jquery.js'); ?>"></script>
     

     <script>
      $(document).ready(function(){
          $(".chosen").chosen({no_results_text: "Oops, pas de resultat!"});
      });
    </script>
  </body>

</html>
