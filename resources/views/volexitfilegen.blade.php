@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
      <div class="col-md-10 col-sm-offset-1">
        @if(session('message'))
        
   <div class="alert alert-danger alert-dismissable">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     {{ session('message') }}
        </div>   
        @endif
<div class="panel-group" id="masterdiv">
  <div class="panel panel-warning">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#masterdiv" href="#collapse1">
          <i class="fa fa-plus"></i>
        Generate Voluntary Exit File</a>
      </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse">
      <div class="panel-body">
        <form method="post" action="{{ url('genvolexitfile') }}/newgen">
        {{ csrf_field() }}
          <button type="submit" class="btn btn-primary" >
            Generate File
          </button>
          
        </form>
      </div>
    </div>
  </div>
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#masterdiv" href="#collapse2">
           <i class="fa fa-plus"></i>
        Regenerate Existing File</a>
      </h4>
    </div>
    <div id="collapse2" class="panel-collapse collapse">
      <div class="panel-body">
        <form method="post" action="{{ url('genvolexitfile') }}/regen">
        {{ csrf_field() }}
          <div class="col-md-8">
            <select id="rfname" name="rfname" class="form-control">
              @foreach($existingfiles as $file)
              <option value="{{ $file->file_name }}">{{ $file->file_name }}</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-warning">
            Generate File
          </button>
        </form>
      </div>
    </div>
  </div>

  
      
</div>
      </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
  
</script>
@endsection