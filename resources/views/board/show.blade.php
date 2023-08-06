@extends('layouts.layout')

@section('head_tag')
@endsection

@section('content-fluid')
<div class="row">
	{{-- 좌측 메뉴 --}}
	@include('inc.leftMenu')
	{{-- 좌측 메뉴 끝--}}

	{{-- 우측 본문--}}
	<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
		<h3>게시판 상세</h3>
		<div class="row">
			<div class="col-12 border border-1 mt-5">
				<h3>{{$board -> board_title}}</h3>
				<p>{!!$board -> board_content!!}</p>
				<hr>
				<div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
					<a href='{{url('/')}}/board/{{$board -> id}}/edit' class="btn btn-secondary me-md-2 mx-1">수정</a>
					<a href='{{url('/')}}/board/{{$board -> id}}/reply' class="btn btn-warning me-md-2 mx-1">답변</a>
					<a href='javascript:goDel({{$board -> id}});'class="btn btn-danger me-md-2 mx-1">삭제</a>
					{{-- <button class="btn btn-danger" type="button" id='btnDel'>삭제</button> --}}
				  </div>
			</div>
		</div>
	</div>
	{{-- 우측 본문 끝 --}}
</div>

{{-- footer 메뉴 --}}
@include('inc.footer')
{{-- footer 메뉴 끝--}}
@endsection

@section('body_end_tag')
	<script>
		$(document).ready(function(){
			$("#btnDel").click(function(){
            	//goDel();
        	});
		});

		function goDel(pa){
			var form = $('#frm')[0];
			var formData = new FormData(form);
			//var formData = new FormData();
			//var files = $('#files');
			//formData.append('files',$(files)[0].files[0]);
			
			$.ajax({
				type: 'POST',
				url: '/board/store',
				data: formData,
				contentType: false,
				processData: false,
				success: function(response){
					console.log(response);
					//$('#fileSaveName').val(response);
				},
				error : function(request, status, error ) {   // 오류가 발생했을 때 호출된다.
					//console.log('code:'+request.status+'\n'+'message:'+request.responseText+'\n'+'error:'+error);
					console.log('code:'+request.status+'\n'+'error:'+error);
				}
			});
		}
	</script>
@endsection
