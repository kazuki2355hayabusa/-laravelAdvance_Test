<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\TodoListRequest;
use App\Models\Todo;
use App\Models\Tag;




class TodoListController extends Controller
{
     public function index(Request $request)
    {
        $request->session()->forget('txt');

        $user = Auth::user();
        $tags = Tag::all();
        $todo_lists = Todo::where('users_id',Auth::user()->id)->get();
        
        return view('index',['todo_lists' => $todo_lists,
                    'users' =>$user,
                    'tags' => $tags]);
    }

    public function add(TodoListRequest $request)
    {
        $add_todo_data = $request->all();
        Todo::create( $add_todo_data);
        return redirect('/home');
    }

    public function update(TodoListRequest $request)
    {
        $flag = $request->input('search_flag');
        $update_todo_data = $request->except(['search_flag']);
        unset($update_todo_data['_token']);
        Todo::where('id',$request->id)->update($update_todo_data);
        if($flag === '1'){
            return redirect('/search');
        }else{
            return redirect('/home');
        }
    }
    public function delete(Request $request)
    {
            $flag = $request->input('search_flag');
            Todo::find($request->id)->delete();
            if($flag === '1'){
                return redirect('/search');
            }else{
                return redirect('/home');
            }
    }

    public function logout(Request $request)
    {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerate();
            return redirect('/');
    }

   public function migrate(Request $request)
   {
        $user = Auth::user();
        $tags = Tag::all();
        $data = $request->session()->get('txt');
        if($data === null)
        {
            $sraech_lists = Todo::where('todo_value',)->get();

        }else{
            $sraech_lists = Todo::where('todo_value','LIKE BINARY',"%{$data['search_todo_data']}%")->where('tags_id','LIKE BINARY',"%{$data['search_tag_data']}%")->get();
        }
        return view('search',
            ['search_datas' =>$sraech_lists,
            'users' => $user,
            'tags' => $tags]);

   }


    public function search(Request $request)
   {
    

        $search_tag_data = $request->tags_id;
        $search_todo_data = $request->todo_value;
        $txt = ['search_tag_data'=> $search_tag_data, 
                'search_todo_data' => $search_todo_data];
        $request->session()->put('txt',$txt);


        $query = Todo::query();

        if (isset($search_tag_data)) {
                $query->where('tags_id', $search_tag_data);
        }

        if(isset($search_todo_data)){
            $query->where('todo_value','LIKE BINARY',"%{$search_todo_data}%");
        }

    
        

        $sraech_datas = $query->orderBy('tags_id','asc')->get();
  
        $tags = Tag::all();
        $user = Auth::user();
        return view('search',
            ['search_datas'=> $sraech_datas,
            'tags'=> $tags,
            'users'=> $user]);
   }
   
}
