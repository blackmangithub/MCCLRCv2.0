<!-- Alertify JS link -->
<script src="assets/js/alertify.min.js"></script>

<!-- Format_number -->
<script src="assets/js/format_number.js"></script>

<!-- Future Date Disable JS -->
<script src="assets/js/disable_future_date.js"></script>

<!-- Bootstrap JS  -->
<script src="assets/js/bootstrap.bundle.min.js"></script>

<!-- JQuery JS -->
<script src="assets/js/jquery-3.6.1.min.js"></script>

<!-- JQuery Datatables -->
<script src="assets/js/jquery.dataTables.min.js"></script>

<!-- Boostrap 5 Datatables -->
<script src="assets/js/chart.min.js"></script>

<!-- Chart.js -->
<script src="assets/js/dataTables.bootstrap5.min.js"></script>

<!-- Dselect JS -->
<script src="assets/js/dselect.js"></script>



<!-- <script src="assets/js/bootstrap.bundle.min.js"></script> -->
<!-- <script src="assets/js/jquery-3.6.0.min.js"></script> -->
<script src="assets/js/datatables.min.js"></script>
<script src="assets/js/pdfmake.min.js"></script>
<script src="assets/js/vfs_fonts.js"></script>
<script src="assets/js/custom.js"></script>




<script type="text/javascript">
// JQuery DataTable 
$(document).ready(function() {
     $('#myDataTable').DataTable({

     });
});
$(document).ready(function() {
     $('#myDataTable2').DataTable({

     });
});
// $(document).ready(function() {
//      $('#example').DataTable({

//           dom: 'Bfrtip',
//           buttons: [
//                'copy', 'csv', 'excel', 'pdf', 'print'
//           ]

//      });
// var table = $('#example').DataTable({
//      buttons: [
//           'copy', 'csv', 'excel', 'pdf', 'print'
//      ]
// })

// table.buttons().container().appenndTo('#example_wrapper .col-md-6:eq(0)');
// });
$(document).ready(function() {

     var table = $('#example').DataTable({

          buttons: ['copy', 'csv', 'excel', 'pdf', 'print']

     });


     table.buttons().container()
          .appendTo('#example_wrapper .col-md-6:eq(0)');

});
</script>

<!-- Tooltip link -->
<script src="assets/js/tooltip.js"></script>
<!-- Custom JS -->
<script src="assets/js/main.js"></script>
<!-- Validate Login Form -->
<script src="assets/js/validation.js"></script>

<!-- Loading animation -->
<script src="assets/js/aos.js"></script>

<script>
AOS.init();
</script>

</body>

</html>