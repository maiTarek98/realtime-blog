@extends('layouts.app')
@push('custom-css')
<style type="text/css">
    .finds{
        border: 1px solid #dedada;
    border-radius: 3px;
    padding: 20px;
    margin: 30px 0px;
    }
</style>
@endpush
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create A New Post :</div>

                <div class="card-body">
                        @csrf
                        <input type="hidden" name="user_id" id="user_id" value="{{Auth::user()->name}}">
                        <div class="row mb-3">
                            <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Title of Post') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required="" autocomplete="title" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="text" class="col-md-4 col-form-label text-md-end">{{ __('Detail Of post') }}</label>

                            <div class="col-md-6">
                                <textarea id="text" type="text" class="form-control @error('text') is-invalid @enderror" name="text" required autocomplete="current-text"> </textarea>

                                @error('text')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary save-post">
                                    {{ __('Add') }}
                                </button>
                            </div>
                        </div>
                </div>
            </div>

             <div class="card" style="margin-top: 7%;">
                <div class="card-header">{{ __('All Posts') }}</div>

                <div class="card-body">
                    <div class="posts"> 
                    @if(count($posts)>0)
                        @foreach($posts as $post)
                        <div class="finds">                     
                             <blockquote class="blockquote">
                              <small class="mb-0">{{ $post->user->name }}</small>
                              <p class="mb-0">{!! $post->text !!}</p>
                            </blockquote>
                            <hr/>
                                                    @csrf
                        <input type="hidden" name="user_id" id="user_comment" class="user_comment" value="{{Auth::user()->name}}">
                        <input type="hidden" name="post_id" id="post_id" class="post_id" value="{{$post->id}}">

                        <div class="row mb-3">
                            <label for="comment" class="col-md-4 col-form-label text-md-end">{{ __('Leave your comment') }}</label>

                            <div class="col-md-6">
                                <textarea id="comment" type="text" class="form-control @error('comment') is-invalid @enderror comment" name="comment" required autocomplete="current-text"> </textarea>

                                @error('comment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary save-comment">
                                    {{ __('Send Comment') }}
                                </button>
                            </div>
                        </div>
                        <div class="comments{{$post->id}}"> 
                            @if(count($post->comments)>0)
                                @foreach($post->comments as $comment)
                                    <blockquote class="blockquote">
                                      <small class="mb-0">{{ $comment->user->name }}</small>  
                                      <p class="mb-0">{{ $comment->comment }}</p>
                                    </blockquote>
                                    <hr/>
                                @endforeach
                            @else
                            <p class="no-comments">No Comments Yet</p>
                            @endif
                        </div>
</div>

                        @endforeach
                    @else
                    <p class="no-posts">No posts Yet</p>
                    @endif
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
// Save post
$(".save-post").on('click',function(){
    var _title=$("#title").val();
    var _name=$("#user_id").val();
    var _text = $("#text").val();
    var vm=$(this);
    // Run Ajax
    $.ajax({
        url:"{{ route('save-post') }}",
        type:"post",
        dataType:'json',
        data:{
            title:_title,
            text:_text,
            user_id:_name,
            _token:"{{ csrf_token() }}"
        },
        beforeSend:function(){
            vm.text('Saving...').addClass('disabled');
        },
        success:function(res){
            var _html='<blockquote class="blockquote animate__animated animate__bounce">\
            <small class="mb-0">'+_name+'</small><p class="mb-0">'+_text+'</p>\
            </blockquote><hr/>';
            if(res.bool==true){
                // $(".posts").prepend(_html);
                $(".post").val('');
                $(".post-count").text($('blockquote').length);
                $(".no-posts").hide();
                $("#title").val('');
                $("#text").val('');
            }
            vm.text('Save').removeClass('disabled');
        }   
    });
});

// Save post
$(".save-comment").on('click',function(){
       var vm=$(this);

    var _user_comment=$(".user_comment").val();
    var _post_id =$(this).closest('.finds').find('.post_id').val();
    console.log(_post_id);
        var _comment=$(this).closest('.finds').find('.comment').val();
    // Run Ajax
    $.ajax({
        url:"{{ route('save-comment') }}",
        type:"post",
        dataType:'json',
        data:{
            comment:_comment,
            post_id:_post_id,
            _user_comment:_user_comment,
            _token:"{{ csrf_token() }}"
        },
        beforeSend:function(){
            vm.text('Saving...').addClass('disabled');
        },
        success:function(res){
            var _html='<blockquote class="blockquote animate__animated animate__bounce">\
            <small class="mb-0">'+_user_comment+'</small><p class="mb-0">'+_comment+'</p>\
            </blockquote><hr/>';
            if(res.bool==true){
                $(".comments"+_post_id).prepend(_html);
                $(".comment").val('');
                $(".comment-count").text($('blockquote').length);
                $(".no-comments").hide();
            }
            vm.text('Save').removeClass('disabled');
        }   
    });
});




</script>

  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('aa35ee2777a09db1380c', {
      cluster: 'eu'
    });

    var channel = pusher.subscribe('notify_post');
    channel.bind('addPost', function(arr_data) {
      //   alert('dff');
      //   // console.log($arr_data.user_id);
      // alert(JSON.stringify(arr_data.user_id));


      var _html='<blockquote class="blockquote animate__animated animate__bounce">\
            <small class="mb-0">'+arr_data.user_id+'</small><p class="mb-0">'+arr_data.text+'</p>\
            </blockquote><hr/>';
                $(".posts").prepend(_html);

    });
  </script>

@endsection