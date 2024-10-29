    <footer class="main-footer">
        <strong>Copyright &copy; 2024 Rayhan Andhiny.</strong>
        Tugas Akhir gw.
    </footer>

</div><!-- ./wrapper -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- jQuery -->
<script src="tmplt/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="tmplt/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="tmplt/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="tmplt/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- ChartJS -->
<script src="tmplt/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="tmplt/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="tmplt/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="tmplt/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="tmplt/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="tmplt/plugins/moment/moment.min.js"></script>
<script src="tmplt/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="tmplt/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="tmplt/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="tmplt/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="tmplt/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="tmplt/dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="tmplt/dist/js/pages/dashboard.js"></script>
<!-- DataTables  & Plugins -->
<script src="tmplt/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="tmplt/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="tmplt/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="tmplt/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="tmplt/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="tmplt/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<!-- Page specific script -->
<script>
    $('#table').DataTable();
</script>
<!-- Sertakan library HERE Maps -->
<script src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
<script src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
<script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
<script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
<!-- navlink -->
<script>
    $(document).ready(function()
    {
        var currentPath = window.location.pathname.split('/').pop();

        $('nav a.nav-link').each(function()
        {
            if ($(this).attr('href') === currentPath) 
            {
                $(this).addClass('active');
            }
        });
    });
</script>

</body>
</html>
