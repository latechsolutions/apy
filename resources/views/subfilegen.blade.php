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
        New Registration</a>
      </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse">
      <div class="panel-body">
        <form method="post" action="{{ url('subfilegen') }}/newgen">
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
        <form method="post" action="{{ url('subfilegen') }}/regen">
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
 <div class="panel panel-warning">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#masterdiv" href="#collapse3">
           <i class="fa fa-plus"></i>
        Remove Rejected Entries</a>
      </h4>
    </div>
    <div id="collapse3" class="panel-collapse collapse">
      <div class="panel-body">
        <form method="post" action="{{ url('subfilegen') }}/removerej">
        {{ csrf_field() }}
          <div class="col-md-8">
                 @foreach($errorrec as $rec)
        <div class="checkbox"><label><input type="checkbox" id="rejectpran" name="rejectpran[]" 
                                            value="{{ $rec->pran_no }}">{{ $rec->pran_no }}</label></input></div>

              @endforeach
          </div>
          <button type="submit" class="btn btn-warning">
            Remove Selected
          </button>
        </form>
      </div>
    </div>
  </div>
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#masterdiv" href="#collapse4">
           <i class="fa fa-plus"></i>
        Upload Response</a>
      </h4>
    </div>
    <div id="collapse4" class="panel-collapse collapse">
      <div class="panel-body">
        <form method="post" action="{{ url('subfilegen') }}/uploadresponse" enctype="multipart/form-data">
        {{ csrf_field() }}
          <div class="col-md-8">
       <input type="file" name="respfile" value="" id="respfile" />
            <label for="respfile"> Select a file to upload</label> 
           </div>
          <button type="submit" class="btn btn-warning">
            Upload Response
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