<?php $__env->startSection('content'); ?>
<style>
    .hotdeals ,.hotdeals ul {
        list-style: none;
        padding: 0px;
    }
    .hotdeals li{
        float: left;
        min-height: 90px;
    }
    
</style>
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

<?php echo Form::open(array('files' => true, 'route' => 'category.hot.deals.store', 'id' => 'form-with-validation', 'class' => 'form-horizontal')); ?>

    <input type="hidden" name="id" value="<?php echo e($HotDealCategory->id); ?>">
    <div class="form-group">
        <?php echo Form::label('title', 'New category*', array('class'=>'col-sm-2 control-label')); ?>

        <div class="col-sm-10">
            <?php echo Form::text('name', $HotDealCategory['name'], array('class'=>'form-control')); ?>

            
        </div>
    </div>
    <?php
        $hotDealsId = json_decode($HotDealCategory->hot_deal_id , true);
    ?>
    <ul class="hotdeals">
        <?php $__currentLoopData = $hotdeals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <ul class="row">
                    <li class="col-md-2"  style="line-height: 6">
                        <?php if($hotDealsId != null): ?>
                            <input type="checkbox" name="isCheck[]" <?php echo e((in_array($row->id , $hotDealsId)) ? 'checked' : ''); ?> value="<?php echo e($row->id); ?>">        
                        <?php endif; ?>
                        <?php if($hotDealsId == null): ?>
                            <input type="checkbox" name="isCheck[]" value="<?php echo e($row->id); ?>">        
                        <?php endif; ?>
                    </li>
                    
                    <li class="col-md-10">
                        <img src="<?php echo e(asset('uploads/'.$row->banner)); ?>" style="max-width: 140px" >        
                    </li>
                </ul>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/hotdeals/hotdealcategory/edit.blade.php ENDPATH**/ ?>