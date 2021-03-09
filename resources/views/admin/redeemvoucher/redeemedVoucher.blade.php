@extends('admin.layouts.master')
<style type="text/css">
    .dt-buttons{
        float: left;
    }
    .m-t-5{
        margin-top: 15%
    }
</style>
@section('content')

{{-- <p>{!! link_to_route(config('coreadmin.route').'.offers.create', trans('coreadmin::templates.templates-view_index-add_new') , null, array('class' => 'btn btn-success')) !!}</p> --}}
{{ csrf_field() }}
@if ($vouchers->count())
    
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">{{ trans('coreadmin::templates.templates-view_index-list') }}</div>
        </div>
        <div class="portlet-body">
            <form method="post" action="{{ route('get.voucher.details.filter') }}">  
                {{ csrf_field() }}
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
                    @foreach ($vouchers as $row)
                        @foreach( $row['vocuherDetails'] as $k => $v )
                            <tr data-id="{{ $row->id }}" data-order="{{ $row->order }}">
                                <td>{{ $v['customerDetails']['name'] }}</td>
                                <td>{{ $v['voucherDetails']['title'] }}</td>
                                <td>{{ $row->voucher_unique_id }}</td>
                                <td>{{ date_format($v->created_at , 'Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>

            </table>

           {{--  <div class="row">
                <div class="col-xs-12">
                    <button class="btn btn-danger" id="delete">
                        {{ trans('coreadmin::templates.templates-view_index-delete_checked') }}
                    </button>
                </div>
            </div> --}}
         {{--    
            {!! Form::open(['route' => config('coreadmin.route').'.offers.massDelete', 'method' => 'post', 'id' => 'massDelete']) !!}
                <input type="hidden" id="send" name="toDelete">
            {!! Form::close() !!} --}}
        </div>
	</div>
@else
    {{ trans('coreadmin::templates.templates-view_index-no_entries_found') }}
@endif

@endsection

@section('javascript')
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
@stop