<link rel="stylesheet" href="/plugins/datatables/dataTables.bootstrap.css">
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables/dataTables.bootstrap.min.js"></script>

<script>
    $(function () {
        var lenguaje_datatable = "//cdn.datatables.net/plug-ins/1.10.10/i18n/Spanish.json";
        $('.tabla_completa').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            stateSave: true,
            "language": {
                "url": lenguaje_datatable
            }
        });
    });
</script>