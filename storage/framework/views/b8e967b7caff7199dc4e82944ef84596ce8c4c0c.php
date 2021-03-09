<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-sm-10 col-sm-offset-2">
        <h1><?php echo e(trans('coreadmin::templates.templates-view_create-add_new')); ?></h1>

        <?php if($errors->any()): ?>
        	<div class="alert alert-danger">
        	    <ul>
                    <?php echo implode('', $errors->all('<li class="error">:message</li>')); ?>

                </ul>
        	</div>
        <?php endif; ?>
    </div>
</div>

<?php echo Form::open(array('files' => true, 'route' => config('coreadmin.route').'.hotdeals.store', 'id' => 'form-with-validation', 'class' => 'form-horizontal')); ?>



<div class="form-group">
    <?php echo Form::label('category', 'Select Category*', array('class'=>'col-sm-2 control-label')); ?>

    <div class="col-sm-10">
        
        <select class="form-control" name="category">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($v->id); ?>"><?php echo e($v->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
</div>
<div class="form-group">
    <?php echo Form::label('offers', 'Select Offer*', array('class'=>'col-sm-2 control-label')); ?>

    <div class="col-sm-10">
        
        <select class="form-control" name="offers">
                <option value="0" class="select0">Select</option>
            <?php $__currentLoopData = $offer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($v->id); ?>" class="cat_<?php echo e($v->category); ?>"><?php echo e($v->title); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
</div>
<div class="form-group">
    <?php echo Form::label('vouchers', 'Select Voucher*', array('class'=>'col-sm-2 control-label')); ?>

    <div class="col-sm-10">
        
        <select class="form-control" name="voucher_id">
            <option value="0" class="select0">Select</option>
            <?php $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($v->id); ?>" class="offer_<?php echo e($v->voucher_of); ?>"><?php echo e($v->title); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
</div>
<div class="form-group">
    <?php echo Form::label('banner', 'Banner*', array('class'=>'col-sm-2 control-label')); ?>

    <div class="col-sm-10">
        <?php echo Form::file('banner'); ?>

        
    </div>
</div>

<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
      <?php echo Form::submit( trans('coreadmin::templates.templates-view_create-create') , array('class' => 'btn btn-primary')); ?>

    </div>
</div>

<?php echo Form::close(); ?>

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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/hotdeals/create.blade.php ENDPATH**/ ?>