{{-- 
    
    ID and Location that we have here, is NOT the ID from products table. 
    It's from the products_in_storage table. 

    - ID is p_id
    
--}}

@extends('layouts.app')


@section('content')
<div class="row m-0">
	
	<div class="col-2 p-0">
		<div class="left_sidebar">
			@include('inc.sidebar')
		</div>
	</div>

	<div class="col-10 p-0">

		@include('inc.navbar')
        @include('inc.message')
        
        @php
            $thisProduct = $products::find($id);
            $realProduct = $productsInStorage::find($key);
        @endphp

    <input type="hidden" value="{{$id}}" id="getPID">
    <input type="hidden" value="{{$location}}" id="getLocation">
		<div class="container pt-4">
			<div class="action_box d-flex align-items-center justify-content-between">
                <h2 class="main_content__title">Tạo Hạn Sử Dụng cho {{ $thisProduct->name }}</h2>
			</div>
            <form id="expirationForm">
            <table class="lotus_table">
                <thead>
                    <tr>
                        <th><img src="/uploaded/{{$thisProduct->product_image}}" alt=""></th>
                        <th>{{ $thisProduct->name }}</th>
                        <th>Kho: @if ($location == 1) Nơ Trang Long @else Tân Tạo @endif</th>
                        <th>Tồn kho: {{ $realProduct->amount }}</th>
                        <th><a href="" id="addExpDate">Tạo HSD</a></th>
                    </tr>
                </thead>
                
                
                    <tbody id="expirationDates">
                        <tr></tr>
                    </tbody>
                
            </table>
            </form>
                <input type="submit" value="Tạo các phiên bản" id="submitExpi">
		</div>
	</div>

</div>

@endsection
