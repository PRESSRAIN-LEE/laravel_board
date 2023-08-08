<?php

namespace App\Http\Controllers;

use App\Models\Board;   //"Board 라는 데이터베이스를 사용한다" 선언(Model)
use Illuminate\Http\Request;


class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boards = Board::where('board_state', 'Y')
        //-> where('board_title', 'like', '1%')
                ->orderby('grp', 'DESC')
                ->orderby('sort', 'ASC')
                ->orderby('id', 'DESC')
                ->paginate(10);
                //->get();
        return view('board.index')
        ->with('boards', $boards);
        /*
        $list = [
            'boards' => $boards->paginate(10),
            //$data = [
            //    'authCheck' => request('authCheck'),
            //    'authCheck' => 'Samsung'
            //],
        ];
        return view('board.index', $list);
        */
    }

     /*
    function search($request)
    {
        dd($request);
        $boards = Board::where('board_state', 'Y')
        -> where('board_title', 'like', '1%')
                ->orderby('grp', 'DESC')
                ->orderby('sort', 'ASC')
                ->orderby('id', 'DESC')
                ->paginate(10);
                //->get();
        return view('board.index')
        ->with('boards', $boards);
    }
    */

    //검색
    public function search(Request $request){
        //$word = $search;
        //$searches = Board::search($word)->paginate(10);
        //dd($request->searchText);
        $boards = Board::where('board_state', 'Y')
        -> where('board_title', 'like', $request->searchText . '%')
                ->orderby('grp', 'DESC')
                ->orderby('sort', 'ASC')
                ->orderby('id', 'DESC')
                ->paginate(10);
                //->get();
        return view('board.index')
        ->with('boards', $boards);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('board.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$request->file('board_file1');

        // 파일 업로드 확인
        //$request->hasFile('board_file1');

        //$validator = Validator::make($data = Input::all(), Board::$rules);
        //if($validator->fails()){
         //   return redirect()->back()->withErrors($validator->errors())->withInput();
        //}

        #$files1 = $request->file('board_file1');
        #$files2 = $request->file('board_file2');
        //return($files->getClientOriginalName());
        //dd(storage_path());

        if($request->hasFile('board_file1')){
            $path1 = $request->file('board_file1')->store('board');     //저장 될 폴더명
            $originalFileName1 = $request->file('board_file1')->getClientOriginalName();
            $saveFileName1 = $request->file('board_file1')->hashName();
        }else{
            $originalFileName1 = "";
            $saveFileName1 = "";
        }
        
        if($request->hasFile('board_file2')){
            $path2 = $request->file('board_file2')->store('board');     //저장 될 폴더명
            $originalFileName2 = $request->file('board_file2')->getClientOriginalName();
            $saveFileName2 = $request->file('board_file2')->hashName();
        }else{
            $originalFileName2 = "";
            $saveFileName2 = "";
        }

        //$path = $request->file('files')->store('D:\work\00.GIT\uploads\attachFiles');
        //$path = $request->file('files')->store(Storage::disk('public'));
        //dd($path1);
        //dd($request->file('files')->getClientOriginalName());
        
        $member_seq = $request->input('member_seq');
        $member_name = $request->input('member_name');
        $board_title = $request->input('board_title');
        $board_content = $request->input('board_content');

        $boardPage = new Board;
        $boardPage -> member_seq = $member_seq;
        $boardPage -> member_name  = $member_name;
        $boardPage -> board_title = $board_title;
        $boardPage -> board_content = $board_content;
        $boardPage -> grp = 0;
        $boardPage -> sort = 0;
        $boardPage -> depth = 0;
        $boardPage -> board_file1 = $saveFileName1;
        $boardPage -> board_file1_ori = $originalFileName1;
        $boardPage -> board_file2 = $saveFileName2;
        $boardPage -> board_file2_ori = $originalFileName2;
        $boardPage -> save();

        $boardPage -> grp = $boardPage -> id;
        $boardPage -> save();
        
        /*
        $board = Board::create([
            //디비 테이블의 필드명 => 입력단에서 넘어옴 입력 필드
            'grp' => $request->input('grp'),
            'sort' => $request->input('sort'),
            'depth' => $request->input('depth'),

            'member_seq' =>$request->input('member_seq'),

            'board_title' => $request->input('board_title'),
            'member_name' =>$request->input('member_name'),
            'board_content' =>$request->input('board_content'),

            'board_file1' => $saveFileName1,
            'board_file1_ori' => $originalFileName1,
            'board_file2' => $saveFileName2,
            'board_file2_ori' => $originalFileName2,
        ]);
        */

        //$result = $request -> all();
        //$data = array(
        //    'result' => $request
        //);
        //return response() -> json($data);

        return redirect('/board');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function replyStore(Request $request, $id)
    {
        //"update 테이블 set re_step = re_step + 1 where ref = "&ref&" and re_step > "&re_step 
        $board = Board::find($id);
        $grp = $request->input('grp');
        $sort = $request->input('sort');
        $depth = $request->input('depth');
        
        $member_seq = $request->input('member_seq');
        $member_name = $request->input('member_name');
        $board_title = $request->input('board_title');
        $board_content = $request->input('board_content');

        //업데이트
        Board::where([
            ['grp',$grp],
            ['sort','>',$sort],
        ])->increment('sort', 1);

        $commentPage = new Board;
        $commentPage->member_seq = $member_seq;
        $commentPage->member_name  = $member_name;
        $commentPage->board_title = $board_title;
        $commentPage->board_content = $board_content;
        $commentPage->grp = $grp; 
        $commentPage->sort = $sort+1; 
        $commentPage->depth = $depth+1;
        $commentPage->save();
        
        //$board = Board::find($grp);
        //$board->depth = ($board->depth + 1);
        //$board->save();

        return;

        //dd("REPLY");
        /*
        if($request->hasFile('board_file1')){
            $path1 = $request->file('board_file1')->store('board');     //저장 될 폴더명
            $originalFileName1 = $request->file('board_file1')->getClientOriginalName();
            $saveFileName1 = $request->file('board_file1')->hashName();
        }else{
            $originalFileName1 = "";
            $saveFileName1 = "";
        }
        
        if($request->hasFile('board_file2')){
            $path2 = $request->file('board_file2')->store('board');     //저장 될 폴더명
            $originalFileName2 = $request->file('board_file2')->getClientOriginalName();
            $saveFileName2 = $request->file('board_file2')->hashName();
        }else{
            $originalFileName2 = "";
            $saveFileName2 = "";
        }

        //$path = $request->file('files')->store('D:\work\00.GIT\uploads\attachFiles');
        //$path = $request->file('files')->store(Storage::disk('public'));
        //dd($path1);
        
        //dd($request->file('files')->getClientOriginalName());
        dd(Board::find($id));
        
        $board = Board::create([
            //디비 테이블의 필드명 => 입력단에서 넘어옴 입력 필드
            'grp' => $request->input('grp'),
            'sort' => $request->input('sort'),
            'depth' => $request->input('depth'),
            'member_seq' =>$request->input('member_seq'),
            'board_title' => $request->input('board_title'),
            'member_name' =>$request->input('member_name'),
            'board_content' =>$request->input('board_content'),

            'board_file1' => $saveFileName1,
            'board_file1_ori' => $originalFileName1,
            'board_file2' => $saveFileName2,
            'board_file2_ori' => $originalFileName2,
        ]);

        //$result = $request -> all();
        //$data = array(
        //    'result' => $request
        //);
        //return response() -> json($data);
        */
        //return redirect('/board');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board, $id)
    {
        $board = Board::find($id);
        return view('board.show')
        ->with('board', $board);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function edit(Board $board, $id)
    {
        $board = Board::find($id);
        return view('board.edit')
        ->with('board', $board);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Board $board)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board)
    {
        //
    }

    //조횟수 증가
    public function viewCnt(Request $request, $id){
        //return ($id);
        $board = Board::find($id);
        $board->board_read = ($board->board_read + 1);
        $board->save();
    }

    //답변(reply)
    public function reply($id)
    {
        $board = Board::find($id);
        return view('board.reply')
        ->with('board', $board);
    }

    //첨부파일 다운로드
    public function download(Request $request, $id, $idx)
    {
        $board = Board::find($id);
//dd($request->idx);
//return $request->idx;
        switch($request->idx) {
            case "1":
                $path = storage_path("app/board/" . $board->board_file1);
                if (!\File::exists($path)) {
                    //return response()->json(['status' => false], 404);
                    return("파일이 없습니다.");
                }
                return response()->download($path, $board->board_file1_ori);
                break;
            case "2":
                $path = storage_path("app/board/" . $board->board_file2);
                if (!\File::exists($path)) {
                    return response()->json(['status' => false], 404);
                    return("파일이 없습니다.");
                }
                return response()->download($path, $board->board_file2_ori);
                break;
            default:
                //return ("C");
        }
        
        //return response()->download(storage_path('app/board/' . $board->board_file1));
    }
}