@extends('layouts.app')
  
@section('title', 'Create Product')
  
@section('contents')
    <h1 class="mb-0">Add Video</h1>
    <hr />
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row mb-3">
            <div class="col">
            <label>Title</label>
                <input type="text" name="title" class="form-control" placeholder="Title">
            </div>
            <div class="col">
                <label>Upload Video</label>
                <input type="file" name="video" class="form-control" placeholder="Video">
            </div>
        </div>
 
        <div class="row">
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection