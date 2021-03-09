
<style type="text/css">
    .dt-buttons{
        float: left;
    }
    .m-t-5{
        margin-top: 15%
    }
</style>
<?php $__env->startSection('content'); ?>


<?php echo e(csrf_field()); ?>

<?php if($vouchers->count()): ?>
    
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption"><?php echo e(trans('coreadmin::templates.templates-view_index-list')); ?></div>
        </div>
        <div class="portlet-body">
            <form method="post" action="<?php echo e(route('get.voucher.details.filter')); ?>">  
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="offerId" value="<?php echo $id ?>">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="from">Date From:</label>
                            <input type="date" class="form-control" id="from" name="from" max="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="to">Date To:</label>
                            <input type="date" class="form-control" id="to" name="to" max="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary m-t-5"> Filter </button>
                    </div>
                </div>
            </form>            
            <table class="table table-striped table-hover table-responsive" id="example">

                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Voucher</th>
                        <th>Voucher Id</th>
                        <th>Created At</th>
                    </tr>
                </thead>

                <tbody id="sortable">
                    <?php $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = $row['vocuherDetails']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr data-id="<?php echo e($row->id); ?>" data-order="<?php echo e($row->order); ?>">
                                <td><?php echo e($v['customerDetails']['name']); ?></td>
                                <td><?php echo e($v['voucherDetails']['title']); ?></td>
                                <td><?php echo e($row->voucher_unique_id); ?></td>
                                <td><?php echo e(date_format($v->created_at , 'Y-m-d')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>

            </table>

           
         
        </div>
	</div>
<?php else: ?>
    <?php echo e(trans('coreadmin::templates.templates-view_index-no_entries_found')); ?>

<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <script>
        $(document).ready(function() {
            $('#example thead tr').clone(true).appendTo( '#example thead' );
            $('#example thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
         
                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
         
            var table = $('#example').DataTable( {
                orderCellsTop: true,
                fixedHeader: true,
                dom: 'Bfrtip',
                aaSorting: [],
                buttons: [      
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            } );
            $('.dt-buttons button').addClass('btn btn-primary');


        } );
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/redeemvoucher/redeemedVoucher.blade.php ENDPATH**/ ?>