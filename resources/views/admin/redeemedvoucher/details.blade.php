@extends('admin.layouts.master')

@section('content')

    @if( $voucherDetails )
        @php
            $voucherTitle = $voucherDetails['title'];
            $voucherTerms = $voucherDetails['terms_condition'];
            $voucherId = $voucherDetails['voucher_unique_id'];
            $voucherOfferTitle = $voucherDetails['Offer']['title'];
        @endphp
        <table class="table">
            <thead>
                <tr>
                    <th>Voucher</th>
                    <th>Voucher Id</th>
                    <th>Voucher From</th>
                    <th>Voucher Terms</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $voucherTitle }}</td>
                    <td>{{ $voucherId }}</td>
                    <td>{{ $voucherOfferTitle }}</td>
                    <td>{{ $voucherTerms }}</td>
                </tr>
            </tbody>
        </table>
        <form method="POST" action="{{ route('craete.voucher.redeem') }}"> 
            <input type="hidden" name="voucher_unique_id" value="{{ $voucherId }}">
            <input type="hidden" name="customer_unique_id" value="{{ $customerId }}">
            <input type="hidden" name="status" value="1">
            {{ csrf_field() }}
            <input type="submit" value="Redeem" class="btn btn-primary">
        </form>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-2">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    @endif
    @if( $voucherDetails == null )
    <div class="row">
        <div class="col-md-12" style="padding: 10px;border: 2px solid #ededed;text-align: center" >       
            <h2 style="padding: 0; margin: 0">Not a valid voucher</h2>
        </div>
    </div>
    @endif
@section('javascript')
{{-- <script type="text/javascript">
    $(document).ready(function(){
        $('.getVoucherDetails').click(function(){
            $.ajax({
                url : "{{ route('get.voucher.details') }}",
                type : "GET",
                data : {id : $('input[name=voucher_unique_id]').val()},
                success : function(res){
                    console.log(res);
                }
            });
        });
    });

    
</script> --}}
@endsection
@endsection