@extends('layouts.app')
@section('description',$post->description)
@section('title',$post->title)
@section('content')
    <div class="row">
        <div class="post-detail">
            @can('update',$post)
                <div class="btn-group pull-right" style="margin-top: -25px">
                    <a class="btn" href="{{ route('post.edit',$post->id) }}"><i class="fa fa-pencil"></i></a>
                    <a class="btn" role="button" data-toggle="modal" data-target="#delete-post-modal">
                        <i class="fa fa-trash-o"></i>
                    </a>
                </div>
                @include('post.delete-modal',$post)
            @endcan
            <div class="center-block">
                <h2>{{ $post->title }}</h2>
                <div class="post-meta">
                           <span class="post-time">
                           <i class="fa fa-calendar-o"></i>
                           <time datetime="2016-08-05T00:10:14+08:00" content="2016-08-05">
                           {{ $post->published_at==null?'Un Published':$post->published_at->format('Y-m-d H:i') }}
                           </time>
                           </span>
                    <span class="post-category">
                           &nbsp;|&nbsp;
                           <i class="fa fa-folder-o"></i>
                           <a href="{{ route('category.show',$post->category->name) }}">
                           {{ $post->category->name }}
                           </a>
                           </span>
                    <span class="post-comments-count">
                           &nbsp;|&nbsp;
                           <i class="fa fa-comment-o" aria-hidden="true"></i>
                           <span>{{ $post->comments_count }}</span>
                           </span>
                    <span>
                           &nbsp;|&nbsp;
                           <i class="fa fa-eye"></i>
                           <span>{{ $post->view_count }}</span>
                           </span>
                </div>
            </div>
            <br>
            <div class="post-content">
                {!! $post->html_content !!}
            </div>
            <div class="tag-list">
                <i class="fa fa-tags"></i>
                @foreach($post->tags as $tag)
                    <a class="tag" href="{{ route('tag.show',$tag->name) }}">{{ $tag->name }}</a>
                @endforeach
            </div>
        </div>
        <div class="widget widget-default">
            <div class="widget-header">
                <h4>评论({{ $post->comments_count }})</h4>
            </div>
            <div class="widget-body">
                <div id="comments-container" data-api-url="{{ route('post.comments',$post->id) }}">
                </div>
                <form class="form-group" id="comment-form" method="post" action="{{ route('comment.store') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    @if(!auth()->check())
                        <label for="username">姓名<span class="required">*</span></label>
                        <input class="form-control" id="username" type="text" name="username" placeholder="您的大名">
                        <label for="email">邮箱<span class="required">*</span></label>
                        <input class="form-control" id="email" type="email" name="email" placeholder="邮箱不会公开">
                    @endif
                    <label for="comment-content">评论内容<span class="required">*</span></label>
                    <textarea placeholder="支持Markdown" style="resize: vertical" id="comment-content" name="content"
                              rows="5" spellcheck="false" class="form-control  autosize-target"></textarea>
                    <input style="margin-top: 10px" type="submit" id="comment-submit" class="btn btn-primary" value="回复"/>
                </form>
            </div>
        </div>
    </div>
@endsection