<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-sm-10 col-sm-offset-2">
        <h1>Category</h1>

        <?php if($errors->any()): ?>
        	<div class="alert alert-danger">
        	    <ul>
                    <?php echo implode('', $errors->all('<li class="error">:message</li>')); ?>

                </ul>
        	</div>
        <?php endif; ?>
    </div>
</div>

<?php echo Form::open(array('files' => true, 'route' => 'hotdeals.store', 'id' => 'form-with-validation', 'class' => 'form-horizontal')); ?>


<div class="form-group">
    <?php echo Form::label('title', 'New category*', array('class'=>'col-sm-2 control-label')); ?>

    <div class="col-sm-10">
        <?php echo Form::text('name', old('name'), array('class'=>'form-control')); ?>

        
    </div>
</div> 


<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
      <?php echo Form::submit( trans('coreadmin::templates.templates-view_create-create') , array('class' => 'btn btn-primary')); ?>

    </div>
</div>

<?php echo Form::close(); ?>


<table class="table table-striped table-hover table-responsive datatable" id="datatable">
    <thead>
        <tr>
            <th>Voucher</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody id="sortable">
        <?php $__currentLoopData = $HotDealCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr data-id="<?php echo e($row->id); ?>">
                <td><?php echo e($row->name); ?></td>
                <td><a href="<?php echo e(route('add.hot.deals.category' , $row->id)); ?>" class="btn btn-primary"> Add Hot Deals </a></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>






    <?php $__env->startSection('javascript'); ?>
        <script type="text/javascript">
            $(document).ready(function(){
                $('select[name=category]').change(function(){
                    $('select[name=offers] .select0').attr('selected' , 'selected');
                    $('select[name=voucher_id] .select0').attr('selected' , 'selected');
                    let selectedCategory = $(this).val();

                    $('select[name=offers] option').hide();
                    $('select[name=offers] .cat_'+selectedCategory).show();
                });
                $('select[name=offers]').change(function(){
                    $('select[name=voucher_id] .select0').attr('selected' , 'selected');
                    let selectedCategory = $(this).val();
                    console.log(selectedCategory);

                    $('select[name=voucher_id] option').hide();
                    $('select[name=voucher_id] .offer_'+selectedCategory).show();
                });
            });
        </script>
    <?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/hotdeals/hotdealcategory/create.blade.php ENDPATH**/ ?>