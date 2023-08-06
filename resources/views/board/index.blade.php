@extends('layouts.layout')

@section('head_tag')
@endsection

@section('content-fluid')
<div class="row">
  {{-- 좌측 메뉴 --}}
  @include('inc.leftMenu')
  {{-- 좌측 메뉴 끝--}}

  {{-- {{$authCheck = $_GET["authCheck"]}} --}}
  <?php
  // {{request("authCheck") ? request("authCheck") : null}}
  //$v_keyname = request("authCheck");
  //dd( $v_keyname );
  //dd(is_array( $v_keyname ));
   
  //값이 있을 경우에는 체크박스에서 체크를 하기 위한 함수
  function check( $val , $array ){
    //dd(is_array( $val , $array ));
    // if (is_array( $val , $array )){
    // 	echo "checked" ;
    // }
  }
  ?>

  <!--'//우측 본문-->
  <div class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <h3>게시판 목록</h3>

    <div class="row">
        <form class="form-inline" action="{{ url('/board/search') }}" method="GET">
        <div class="col">검색</div>
        <div class="col-6">
          <input type="text" class="form-control" id="searchText" placeholder="검색어" name='searchText' value="{{ request('searchText') }}">
          <button type="submit" class="btn btn-primary">검색</button>
        </div>
        </form>
    </div>

    <div class="row">
      <div class="col">
        총 {{$boards->count()}}건 {{$boards->currentPage()}} / {{$boards->lastPage()}}페이지
      </div>
    </div>

    @php
        $boardNum = $boards->total() - ($boards->perPage() * ($boards->currentPage() - 1));
    @endphp

    <table class="table table-hover">
      <thead class="table-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">아이디</th>
          <th scope="col">이름</th>
          <th scope="col">제목</th>
          <th scope="col">파일1</th>
          <th scope="col">파일2</th>
          <th scope="col">조회</th>
          <th scope="col">등록일</th>
        </tr>
      </thead>
      <tbody>
        @foreach ( $boards as $board)
        <tr style='cursor:pointer;'>
          <th scope="row">
            {{-- $board->id --}}
            {{ $boardNum-- }}
          </th>
          <td>{{ $board->member_seq }}</td>
          <td>{{ $board->member_name }}</td>
          <td>
              <a href='javascript:goView({{ $board->id }});'>
                @if($board->depth > 0)
                  @for ($i=0; $i<$board->depth; $i++)
                    &nbsp;&nbsp;
                  @endfor
                  └Re: {{ $board->board_title }}
                @else
                  {{ $board->board_title }}
                @endif
              </a>
          </td>
          <td>
            @if ($board->board_file1)
              <a href=''>파일</a>
            @endif
          </td>
          <td>
            @if ($board->board_file2)
              <a href=''>파일</a>
            @endif
          </td>
          <td>{{ $board->board_read }}</td>
          <td>{{ $board->created_at }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
        {!! $boards->links() !!}
      </ul>
    </nav>

    <a href='{{ url('board/create') }}' class='btn btn-primary'>글쓰기</a>
  </div>
  <!--'//우측 본문 끝-->
</div>

  {{-- footer 메뉴 --}}
  @include('inc.footer')
  {{-- footer 메뉴 끝--}}
@endsection

@section('body_end_tag')
  <script>
      function goView(pa){
          var url = "/board/" + pa + "/viewCnt/";
          $.ajax({
              type: "GET",
              url: url,
              //dataType: "JSON",
              success: function(result) {
                  // 성공시 http status code 200
                  //console.log(result);
                  location.href = "/board/" + pa + "/show/"
              },
              error: function(xhr, status, error) {
                  // 실패시 http status code 200 이 아닌 경우
                  console.log(xhr);
              }
          });
      }
  </script>
@endsection
