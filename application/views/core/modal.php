<div class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php $this->load->view($contenido_modal); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $().ready(() => {
        $('.modal').modal('show')
    })
</script>