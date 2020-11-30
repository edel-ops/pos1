<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Comidas Rapidas Mary <?php echo date('Y');?></div>
            <div>
                <a href="https://facebook.com/edel.net/" target="_blank">Facebook</a>
                &middot;
                <a href="https://facebook.com" target="_blank">Website</a>
            </div>
        </div>
    </div>
</footer>
</div>
</div>
<script src="<?php echo base_url(); ?>/js/jquery-3.5.1.min.js"></script>
<script src="<?php echo base_url(); ?>/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>/js/scripts.js"></script>
<script src="<?php echo base_url(); ?>/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/demo/datatables-demo.js"></script>
<script>
    $('#modal-confirma').on('show.bs.modal', function(e){
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>
</body>

</html>