<!-- Login Validation -->
<script src="assets/js/validation.js"></script>



<!-- Show and hide Password -->
<script src="assets/js/show-hide-password.js"></script>

<!-- Format Number  -->
<script src="assets/js/format_number.js"></script>
<!-- Dissable Future Date -->
<!-- <script src="assets/js/disable_future_date.js"></script> -->

<!-- Bootstrap Bundle js -->
<script src="assets/js/bootstrap5.bundle.min.js"></script>

<script src="assets/js/tooltip.js"></script>

<script src="assets/js/login.js"></script>

<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/jquery-ui.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<!-- Alertify JS CDN Link -->
<script src="assets/js/alertify.min.js"></script>


<script src="assets/js/sweetalert.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
if(isset($_SESSION['status']) && $_SESSION['status'] !='')
{
    ?>
    <script>
        swal({
            title: "<?php echo $_SESSION['status']; ?>",
            // text: "You clicked the button!",
            icon: "<?php echo $_SESSION['status_code']; ?>",
            button: "OK",
        });
    </script>
    <?php
    unset($_SESSION['status']);
}
?>

<!-- Loading animation -->
<script src="assets/js/aos.js"></script>

<script>
AOS.init();
</script>


</body>

</html>