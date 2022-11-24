<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/reset.css" />
   <title>Document</title>
</head>
<style>
  input,
    select {
      vertical-align: middle;
    }
    .flex {
      display: flex;
    }

    .between {
      justify-content: space-between;
    }
  .mb-15 {
      margin-bottom: 15px;
    }
  .mb-30 {
      margin-bottom: 30px;
    }
    .input-add {
      width: 80%;
      padding: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
      appearance: none;
      font-size: 14px;
      outline: none;
    }

    .button-add {
      text-align: left;
      border: 2px solid #dc70fa;
      font-size: 12px;
      color: #dc70fa;
      background-color: #fff;
      font-weight: bold;
      padding: 8px 16px;
      border-radius: 5px;
      cursor: pointer;
      transition: 0.4s;
      outline: none;
    }

  .title {
      font-weight: bold;
      font-size: 24px;
    }
    .input-add {
      width: 80%;
      padding: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
      appearance: none;
      font-size: 14px;
      outline: none;
    }
    
    table {
      text-align: center;
      width: 100%
    }
    /*tr {
      height: 50px;
    }*/
    .input-update {
      width: 90%;
      padding: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
      appearance: none;
      font-size: 14px;
      outline: none;
    } 
  .container{
    background-color:#2d197c;
    height: 100vh;
    width: 100vw;
    position: relative;
  }
  .card{
    background-color: #fff;
    width: 50vw;
    padding: 30px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border-radius: 10px;
  }
  .button-update {
      text-align: left;
      border: 2px solid #fa9770;
      font-size: 12px;
      color: #fa9770;
      background-color: #fff;
      font-weight: bold;
      padding: 8px 16px;
      border-radius: 5px;
      cursor: pointer;
      transition: 0.4s;
      outline: none;
    }
     .button-update:hover {
      background-color: #fa9770;
      border-color: #fa9770;
      color: #fff;
    }

    .button-delete {
      text-align: left;
      border: 2px solid #71fadc;
      font-size: 12px;
      color: #71fadc;
      background-color: #fff;
      font-weight: bold;
      padding: 8px 16px;
      border-radius: 5px;
      cursor: pointer;
      transition: 0.4s;
      outline: none;
    }

    .btn-delete {
      border: 2px solid #71fadc;
      color: #71fadc;
    }

    .btn-delete:hover {
      background-color: #71fadc;
      border-color: #71fadc;
      color: #fff;
    }
    .select-tag {
    padding: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 14px;
    outline: none;
  }
  .auth {
  display: flex;
  align-items: center;
  font-size: 16px;
}

.auth>.detail {
  margin-right: 1rem;
}
.btn {
  text-align: left;
  font-size: 12px;
  background-color: #fff;
  font-weight: bold;
  padding: 8px 16px;
  border-radius: 5px;
  cursor: pointer;
  transition: 0.4s;
  outline: none;
}

.btn-logout {
  border: 2px solid #FF0000;
  color: #FF0000;
}

.btn-logout:hover {
  background-color: #FF0000;
  border-color: #FF0000;
  color: #fff;
}
.btn-search {
  display: inline-block;
  border: 2px solid #cdf119;
  color: #cdf119;
  text-decoration: none;
  margin-bottom: 10px;
}

.btn-search:hover {
  background-color: #cdf119;
  border-color: #cdf119;
  color: #fff;
}
.card__header {
  display: flex;
  justify-content: space-between;
}

</style>
<body>
  <div class="container">
    <div class="card">
      <div class="card__header">
        <p class="title mb-15">Todo List</p>
        <div class="auth md-15">
          <p class="detail">「{{$users->name}}」でログイン中</p>
          <form action="/logout" method="post">
            @csrf
            <input type="submit" class="btn btn-logout" value="ログアウト">
          </form>
        </div>
      </div>  
         <a class="btn btn-search" href="/search">タスク検索</a>
      @foreach($errors->all() as $error)
        <li>
          {{$error}}
        </li>
      @endforeach
      <div class="todo">
        <form action="/add" method="post" class="flex between mb-30">
         @csrf
          <input type="hidden" name="users_id" value={{$users->id}}>
          <input type="text" class="input-add" name="todo_value">
          <select name="tags_id" class="select-tag">
          @foreach($tags as $tag)
            <option value="{{$tag->id}}">{{$tag->tag_name}}
            </option>
          @endforeach
         </select>          
          <input type="submit" value="追加" class="button-add">
        </form>
        <table> 
          <tr>
            <th>作成日</th>
            <th>タスク名</th>
            <th>タグ</th>
            <th>更新</th>
            <th>削除</th>
          </tr>
          @foreach($todo_lists as $todo_list)
          <tr>
            
             <form method="post" class="flex between mb-30">
              @csrf
            <td>
              {{$todo_list->created_at}}
            </td>
            <td>
                  <input type="hidden"  name="id" value="{{$todo_list->id}}">
                  <input type="hidden" name="users_id" value={{$users->id}}>
                  <input class="input-update" type="text" name ="todo_value" value="{{$todo_list->todo_value}}">
            </td>
            <td>      
                  <select class="select-tag" name="tags_id">
                   
                  @foreach($tags as $tag)
                    @if($tag->id === $todo_list->tags_id)
                    <option value="{{$tag->id}}" selected>{{$tag->tag_name}}</option>
                    @else
                    <option value="{{$tag->id}}">{{$tag->tag_name}}</option>
                    @endif
                  @endforeach
                  </select>
                  
            </td>
            <td>
              <button type="submit" class="button-update" formaction="/update">更新</button>
            </td>
            <td>
              <button type="submit" class="btn btn-delete" formaction="/delete">削除</button>
            </td>
            </form>
          <tr>   
          @endforeach
        </table>
      </dev>   
    </div>    
  </div>
</body>
</html>