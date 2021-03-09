@extends('admin.layouts.master')

@section('content')

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

{!! Form::open(array('files' => true, 'route' => 'hotdeals.store', 'id' => 'form-with-validation', 'class' => 'form-horizontal')) !!}

<div class="form-group">
    {!! Form::label('title', 'New category*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('name', old('name'), array('class'=>'form-control')) !!}
        
    </div>
</div> 


<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
      {!! Form::submit( trans('coreadmin::templates.templates-view_create-create') , array('class' => 'btn btn-primary')) !!}
    </div>
</div>

{!! Form::close() !!}

<table class="table table-striped table-hover table-responsive datatable" id="datatable">
    <thead>
        <tr>
            <th>Voucher</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody id="sortable">
        @foreach ($HotDealCategory as $row)
            <tr data-id="{{ $row->id }}">
                <td>{{ $row->name }}</td>
                <td><a href="{{ route('add.hot.deals.category' , $row->id) }}" class="btn btn-primary"> Add Hot Deals </a></td>
            </tr>
        @endforeach
    </tbody>
</table>






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