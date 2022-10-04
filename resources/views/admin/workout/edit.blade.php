@extends('admin.layouts.app')
@section('title', 'Library Update')

@section('style')

@endsection
@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body"> 
            <div class="row">
            <div class="col-12 col-md-8 col-lg-8">
                <div class="card">                  
                <form method="post" action="{{ route('workoutlibrary.update', $workout_data->id) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-header">
                      <h4>Update Library</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Workout Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                            name="title" value="{{ $workout_data->title }}" placeholder="Workout title" required=""
                            value="{{ old('title') }}"
                            >
                            @if ($errors->has('title'))
                            <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Select Measurement</label>
                            <select class="form-control form-control-sm @error('measurement_id') is-invalid @enderror" name="measurement_id" required>
                                <option value="">--Select--</option>
                                @if($measurements)
                                    @foreach($measurements as $measurement)
                                        <option value="{{$measurement->id}}"
                                        {{ $workout_data->measurement_id == $measurement->id ? 'selected' : ''}}
                                        >{{ $measurement->name}} ( {{ $measurement->unit }} )</option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('measurement_id'))
                            <div class="invalid-feedback">{{ $errors->first('measurement_id') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Select sport</label>
                            <select class="form-control form-control-sm @error('sport_id') is-invalid @enderror" name="sport_id">
                                <option value="">--Select--</option>
                                @if($sports)
                                    @foreach($sports as $sport)
                                        <option value="{{$sport->id}}"
                                        {{ $workout_data->sport_id == $sport->id ? 'selected' : ''}}
                                        >{{ $sport->name}} </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group mb-0">
                            <label>Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" 
                            required="" placeholder="Workout Description...." value="">{!! $workout_data->description !!}</textarea>
                            @if ($errors->has('description'))
                            <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Video Url</label>
                            <input type="url" class="form-control @error('video') is-invalid @enderror"
                            name="video" value="{{ $workout_data->video }}" placeholder="Video Url" required=""
                            value="{{ old('video') }}"
                            >
                            <iframe width="100" height="80"
                                src="{!! $workout_data->video !!}">
                            </iframe>
                            @if ($errors->has('video'))
                            <div class="invalid-feedback">{{ $errors->first('video') }}</div>
                            @endif
                        </div>
                         <div class="form-group ">
                            <label>ACI Index    </label>  
                            <input type="radio" name="is_aci_index" value="1" {{ $workout_data->is_aci_index == 1 ? 'checked' : ''}}  >      
                            Yes 
                            <input type="radio" name="is_aci_index" value="0" {{ $workout_data->is_aci_index == 0 ? 'checked' : ''}} >      
                            No 
                        </div>
                        <div class="form-group mb-0">
                            <label>Tips Content</label>
                            <textarea class="form-control @error('tips_content') is-invalid @enderror" name="tips_content" 
                            required="" placeholder="Tips Content...." value="">{!! $workout_data->tips_content !!}</textarea>
                            @if ($errors->has('tips_content'))
                            <div class="invalid-feedback">{{ $errors->first('tips_content') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Select Status</label>
                            <select class="form-control form-control-sm @error('status') is-invalid @enderror" name="status" required>
                                <option value="1" {{ $workout_data->status == 1 ? 'selected' : ''}}>Active</option>
                                <option value="0" {{ $workout_data->status == 0 ? 'selected' : ''}}>Inactive</option>
                            </select>
                            @if ($errors->has('status'))
                            <div class="invalid-feedback">{{ $errors->first('status') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer text-right">
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('script')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'description' );
    CKEDITOR.replace( 'tips_content' );
    
</script>
@if ($message = Session::get('error'))  
    <script>
      swal('{{ $message }}', 'Warning', 'error');
    </script>
  @endif
@endsection
