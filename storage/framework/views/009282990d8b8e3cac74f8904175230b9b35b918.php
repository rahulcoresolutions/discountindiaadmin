<tr>
    <td>
        <input type="hidden" name="f_show[]" value="1" class="show_hid">
        <input type="checkbox" value="1" checked class="show2">
    </td>
    <td>
        <select name="f_type[]" class="form-control type" required="required">
            <?php $__currentLoopData = $fieldTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($key); ?>"
                        <?php if($key == old('f_type.'.$index)): ?> selected <?php endif; ?>><?php echo e($option); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    <td>
        <input type="text" name="f_title[]" value="<?php echo e(old('f_title.'.$index)); ?>" class="form-control title"
               required="required" placeholder="<?php echo e(trans('coreadmin::templates.templates-menu_field_line-field_db_name')); ?>">





        <!-- File size limit -->
        <label class="size"><?php echo e(trans('coreadmin::templates.templates-menu_field_line-size_limit')); ?></label>
        <input type="text" name="f_size[]" value="<?php echo e(old('f_size.'.$index, '2')); ?>" class="form-control size"
               placeholder="<?php echo e(trans('coreadmin::templates.templates-menu_field_line-size_limit_placeholder')); ?>" style="display: none;">
        <!-- /File size limit -->

        <!-- File dimensions limit -->
        <label class="dimensions"><?php echo e(trans('coreadmin::templates.templates-menu_field_line-maximum_width')); ?></label>
        <input type="text" name="f_dimension_w[]" value="<?php echo e(old('f_dimension_w.'.$index, '4096')); ?>"
               class="form-control dimensions"
               placeholder="<?php echo e(trans('coreadmin::templates.templates-menu_field_line-maximum_width_placeholder')); ?>" style="display: none;">
        <label class="dimensions"><?php echo e(trans('coreadmin::templates.templates-menu_field_line-maximum_height')); ?></label>
        <input type="text" name="f_dimension_h[]" value="<?php echo e(old('f_dimension_h.'.$index, '4096')); ?>"
               class="form-control dimensions"
               placeholder="<?php echo e(trans('coreadmin::templates.templates-menu_field_line-maximum_height_placeholder')); ?>" style="display: none;">
        <!-- /File dimensions limit -->






        <!-- Value for radio button -->
        <input type="text" name="f_value[]" value="<?php echo e(old('f_value.'.$index)); ?>" class="form-control value"
               placeholder="<?php echo e(trans('coreadmin::templates.templates-menu_field_line-value')); ?>" style="display: none;">
        <!-- /Value for radio button -->


        <!-- Value for dropdown button -->
        <div class="dropdown-list" style="display: none; margin-top: 10px;">
            <div class="row dropdown-list-repeat">
                <div class="col-md-5">
                    <input type="text" name="f_dropdonw_values[]" value="<?php echo e(old('f_dropdonw_values.'.$index)); ?>" class="form-control dropdown_value"
                   placeholder="Key" >  
                </div>
                <div class="col-md-5">
                    <input type="text" name="f_dropdonw_values[]" value="<?php echo e(old('f_dropdonw_values.'.$index)); ?>" class="form-control dropdown_value"
                   placeholder="Value">
                </div>
                <div class="col-md-2 add-more-button" style="padding-top: 8px;">
                    <i class="fa fa-plus text-danger add-more-option" style="cursor: pointer;"></i>
                </div>
            </div>
        </div>
        <!-- /Value for dropdown button -->


        <!-- Default value of a checkbox -->
        <select name="f_default[]" class="form-control default_c" style="display: none;">
            <?php $__currentLoopData = $defaultValuesCbox; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($key); ?>"
                        <?php if($key == old('f_default.'.$index)): ?> selected <?php endif; ?>><?php echo e($option); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <!-- /Default value of a checkbox -->

        <!-- Use ckeditor on textarea field -->
        <select name="f_texteditor[]" class="form-control texteditor" style="display: none;">
            <option value="0"
                    <?php if($key == old('f_texteditor.'.$index)): ?> selected <?php endif; ?>><?php echo e(trans('coreadmin::templates.templates-menu_field_line-dont_use_ckeditor')); ?>

            </option>
            <option value="1"
                    <?php if($key == old('f_texteditor.'.$index)): ?> selected <?php endif; ?>><?php echo e(trans('coreadmin::templates.templates-menu_field_line-use_ckeditor')); ?>

            </option>
        </select>
        <!-- /Use ckeditor on textarea field -->

        <!-- Select for relationship -->
        <select name="f_relationship[]" class="form-control relationship" style="display: none;">
            <option value=""><?php echo e(trans('coreadmin::templates.templates-menu_field_line-select_relationship')); ?></option>
            <?php $__currentLoopData = $menusSelect; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($key); ?>"
                        <?php if($key == old('f_relationship.'.$index)): ?> selected <?php endif; ?>><?php echo e($option); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <!-- /Select for relationship -->
        <div class="relationship-holder"></div>

        <!-- ENUM values -->
        <label class="enum"><?php echo e(trans('coreadmin::templates.templates-menu_field_line-enum_values')); ?></label>
        <input type="text" name="f_enum[]" value="<?php echo e(old('f_enum.'.$index)); ?>" class="form-control enum tags"
               placeholder="<?php echo e(trans('coreadmin::templates.templates-menu_field_line-enum_values_placeholder')); ?>" style="display: none;">
        <!-- /ENUM values -->
    </td>
    <td>
        <input type="text" name="f_label[]" value="<?php echo e(old('f_label.'.$index)); ?>" class="form-control"
               required="required" placeholder="<?php echo e(trans('coreadmin::templates.templates-menu_field_line-field_visual_title_placeholder')); ?>">
        <input type="text" name="f_helper[]" value="<?php echo e(old('f_helper.'.$index)); ?>" class="form-control"
               placeholder="<?php echo e(trans('coreadmin::templates.templates-menu_field_line-comment_below_placeholder')); ?>">
    </td>
    <td>
        <select name="f_validation[]" class="form-control" required="required">
            <?php $__currentLoopData = $fieldValidation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($key); ?>"
                        <?php if($key == old('f_validation.'.$index)): ?> selected <?php endif; ?>><?php echo e($option); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </td>
    <td><a href="#" class="rem btn btn-danger"><i class="fa fa-minus"></i></a></td>
</tr>
<?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/packages/core-solutions/core-admin/src/Views/templates/menu_field_line.blade.php ENDPATH**/ ?>