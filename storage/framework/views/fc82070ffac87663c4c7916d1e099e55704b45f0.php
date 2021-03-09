<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-sm-10 col-sm-offset-2">
            <h1><?php echo e(trans('coreadmin::qa.menus-createCrud-create_new_crud')); ?></h1>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php echo implode('', $errors->all('
                        <li class="error">:message</li>
                        ')); ?>

                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php echo Form::open(['class' => 'form-horizontal']); ?>


    <div class="form-group">
        <?php echo Form::label('parent_id', trans('coreadmin::qa.menus-createCrud-crud_parent'), ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
            <?php echo Form::select('parent_id', $parentsSelect, old('parent_id'), ['class'=>'form-control']); ?>

        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label('name', trans('coreadmin::qa.menus-createCrud-crud_name'), ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
            <?php echo Form::text('name', old('name'), ['class'=>'form-control', 'placeholder'=> trans('coreadmin::qa.menus-createCrud-crud_name_placeholder')]); ?>

        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label('title', trans('coreadmin::qa.menus-createCrud-crud_title'), ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
            <?php echo Form::text('title', old('title'), ['class'=>'form-control', 'placeholder'=> trans('coreadmin::qa.menus-createCrud-crud_title_placeholder')]); ?>

        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label('roles', trans('coreadmin::qa.menus-createCrud-roles'), ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
                    <label>
                        <?php echo Form::checkbox('roles['.$role->id.']',$role->id,old('roles.'.$role->id)); ?>

                        <?php echo $role->title; ?>

                    </label>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>


    <div class="form-group">
        <?php echo Form::label('soft', trans('coreadmin::qa.menus-createCrud-soft_delete'), ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
            <?php echo Form::select('soft', [1 => trans('coreadmin::strings.yes'), 0 => trans('coreadmin::strings.no')], old('soft'), ['class' => 'form-control']); ?>

        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label('icon', trans('coreadmin::qa.menus-createCrud-icon'), ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
            <?php echo Form::text('icon', old('icon','fa-database'), ['class'=>'form-control', 'placeholder'=> trans('coreadmin::qa.menus-createCrud-icon_placeholder')]); ?>

        </div>
    </div>

    <hr/>

    <h3><?php echo e(trans('coreadmin::qa.menus-createCrud-add_fields')); ?></h3>

    <table class="table">
        <tbody id="generator">
            <tr>
                <td><?php echo e(trans('coreadmin::qa.menus-createCrud-show_in_list')); ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php if(old('f_type')): ?>
                <?php $__currentLoopData = old('f_type'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $fieldName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('tpl::menu_field_line', ['index' => $index], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <?php echo $__env->make('tpl::menu_field_line', ['index' => ''], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="form-group">
        <div class="col-md-12">
            <button type="button" id="addField" class="btn btn-success"><i
                        class="fa fa-plus"></i> <?php echo e(trans('coreadmin::qa.menus-createCrud-add_field')); ?>

            </button>
        </div>
    </div>

    <hr/>

    <div class="form-group">
        <div class="col-md-12">
            <?php echo Form::submit(trans('coreadmin::qa.menus-createCrud-create_crud'), ['class' => 'btn btn-primary']); ?>

        </div>
    </div>

    <?php echo Form::close(); ?>


    <div style="display: none;">
        <table>
            <tbody id="line">
                <?php echo $__env->make('tpl::menu_field_line', ['index' => ''], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </tbody>
        </table>

        <!-- Select for relationship column-->
        <?php $__currentLoopData = $models; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <select name="f_relationship_field[<?php echo e($key); ?>]" class="form-control relationship-field rf-<?php echo e($key); ?>">
                <option value=""><?php echo e(trans('coreadmin::qa.menus-createCrud-select_display_field')); ?></option>
                <?php $__currentLoopData = $model; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2 => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($option); ?>"
                            <?php if($option == old('f_relationship_field.'.$key)): ?> selected <?php endif; ?>><?php echo e($option); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <!-- /Select for relationship column-->
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>

    <script>
        function typeChange(e) {
            var val = $(e).val();
            // Hide all possible outputs
            $(e).parent().parent().find('.value').hide();
            $(e).parent().parent().find('.default_c').hide();
            $(e).parent().parent().find('.relationship').hide();
            $(e).parent().parent().find('.title').show().val('');
            $(e).parent().parent().find('.texteditor').hide();
            $(e).parent().parent().find('.size').hide();
            $(e).parent().parent().find('.dimensions').hide();
            $(e).parent().parent().find('.enum').hide();
            $(e).parent().parent().find('.relationship-field').hide();

            // Show a checbox which enables/disables showing in list
            $(e).parent().parent().parent().find('.show2').show();
            $(e).parent().parent().parent().find('.show_hid').val(1);
            switch (val) {
                case 'radio':
                    $(e).parent().parent().find('.value').show();
                    break;
                case 'checkbox':
                    $(e).parent().parent().find('.default_c').show();
                    break;
                case 'relationship':
                    $(e).parent().parent().find('.relationship').show();
                    $(e).parent().parent().find('.title').hide().val('-');
                    break;
                case 'textarea':
                    $(e).parent().parent().find('.show2').hide();
                    $(e).parent().parent().find('.show_hid').val(0);
                    $(e).parent().parent().find('.texteditor').show();
                    break;
                case 'file':
                    $(e).parent().parent().find('.size').show();
                    break;
                case 'enum':
                    $(e).parent().parent().find('.enum').show();
                    break;
                case 'photo':
                    $(e).parent().parent().find('.size').show();
                    $(e).parent().parent().find('.dimensions').show();
                    break;
                case'dropdown':
                    $(e).parent().parent().find('.dropdown-list').show();
                    break;
            }
        }

        function relationshipChange(e) {
            var val = $(e).val();
            $(e).parent().parent().find('.relationship-field').remove();
            var select = $('.rf-' + val).clone();
            $(e).parent().parent().find('.relationship-holder').html(select);
        }

        $(document).ready(function () {
            $('.type').each(function () {
                typeChange($(this))
            });
            $('.relationship').each(function () {
                relationshipChange($(this))
            });

            $('.show2').change(function () {
                var checked = $(this).is(":checked");
                if (checked) {
                    $(this).parent().find('.show_hid').val(1);
                } else {
                    $(this).parent().find('.show_hid').val(0);
                }
            });

            // Add new row to the table of fields
            $('#addField').click(function () {
                var line = $('#line').html();
                var table = $('#generator');
                table.append(line);
            });

            // Remove row from the table of fields
            $(document).on('click', '.rem', function () {
                $(this).parent().parent().remove();
            });

            $(document).on('change', '.type', function () {
                typeChange($(this))
            });
            $(document).on('change', '.relationship', function () {
                relationshipChange($(this))
            });

            $(document).on('click','.add-more-option', function(){
                var clonedDiv = $(this).parents('.dropdown-list-repeat:first').clone();
                $(this).parents('.dropdown-list').append(clonedDiv);
                $(this).parents('.dropdown-list').find('.dropdown-list-repeat:last').find('input').val('');
                $(this).parents('.dropdown-list').find('.dropdown-list-repeat:last').find('.add-more-button').remove();
            });
        });

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/packages/core-solutions/core-admin/src/Views/qa/menus/createCrud.blade.php ENDPATH**/ ?>