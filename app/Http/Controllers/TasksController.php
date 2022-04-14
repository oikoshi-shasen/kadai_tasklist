<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct(){
         $this->middleware('auth');
     }
        
    public function index()
    {
       
            $tasks = Task::all();
            return view('tasks.index', [
                'tasks' => $tasks,
            ]);
        }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;

        // メッセージ作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     // postでtasks/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required|max:255',
        ]);
        // メッセージを作成
        $task = new Task;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();

        // トップページへリダイレクトさせる
        // これがViewの代わり
        return redirect('/');
    }

    // getでtasks/（任意のid）にアクセスされた場合の「取得表示処理」
       public function show($id)
    {
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);

        // メッセージ詳細ビューでそれを表示
        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    // getでtasks/（任意のid）/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);

        // メッセージ編集ビューでそれを表示
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    // putまたはpatchでtasks/（任意のid）にアクセスされた場合の「更新処理」
   public function update(Request $request, $id)
    {
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        // メッセージを更新
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required|max:255',
        ]);
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    // deleteでtasks/（任意のid）にアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        // メッセージを削除
        $task->delete();

        // トップページへリダイレクトさせる
        return redirect('/');
    }
}