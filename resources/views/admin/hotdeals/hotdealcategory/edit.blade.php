@extends('admin.layouts.master')

@section('content')
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

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
                </ul>
        	</div>
        @endif
    </div>
</div>

{!! Form::open(array('files' => true, 'route' => 'category.hot.deals.store', 'id' => 'form-with-validation', 'class' => 'form-horizontal')) !!}
    <input type="hidden" name="id" value="{{ $HotDealCategory->id }}">
    <div class="form-group">
        {!! Form::label('title', 'New category*', array('class'=>'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
            {!! Form::text('name', $HotDealCategory['name'], array('class'=>'form-control')) !!}
            
        </div>
    </div>
    @php
        $hotDealsId = json_decode($HotDealCategory->hot_deal_id , true);
    @endphp
    <ul class="hotdeals">
        @foreach ($hotdeals as $row)
            <li>
                <ul class="row">
                    <li class="col-md-2"  style="line-height: 6">
                        @if($hotDealsId != null)
                            <input type="checkbox" name="isCheck[]" {{ (in_array($row->id , $hotDealsId)) ? 'checked' : '' }} value="{{ $row->id }}">        
                        @endif
                        @if($hotDealsId == null)
                            <input type="checkbox" name="isCheck[]" value="{{ $row->id }}">        
                        @endif
                    </li>
                    
                    <li class="col-md-10">
                        <img src="{{ asset('uploads/'.$row->banner) }}" style="max-width: 140px" >        
                    </li>
                </ul>
            </li>
        @endforeach
    </ul>
    
    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
          {!! Form::submit( trans('coreadmin::templates.templates-view_create-create') , array('class' => 'btn btn-primary')) !!}
        </div>
    </div>
{!! Form::close() !!}

    

    






    @section('javascript')
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
    @endsection
@endsection